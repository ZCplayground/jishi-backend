<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;

class UsersController extends Controller
{
    public function signup(Request $request) // 注册
    {
        // 前端发送 json 'tel'=>手机号，'passwd'=>'密码'
        $data = $request->getContent();
        $data = json_decode($data, true);

        // 查看该手机号是否已经被注册。
        $duplicate = User::where('tel',$data['tel']);

        if($duplicate != null) //错误情况：该手机号已经被注册
        // 后端返回 json 'info' => 'tel number exists.'
        // http 状态码：400
        { 
            return response()->json([
                'info' => 'tel number exists.'
            ], 400);
        }
        
        $passwd = $request->passwd;
        $len = strlen($passwd);
        if($len < 6 && $len > 18)//错误情况：密码长度过短或过长
        // 后端返回 json 'info' => 'passwd too short or long.'
        // http 状态码：401
        {
            return response()->json([
                'info' => 'passwd too short or long.'
            ], 401);
        }

        // 正确情况：成功注册
        $user = User::create([ // 存入数据库
            'tel' => $data['tel'],
            'newhere' => true,
            'passwd' => bcrypt($request->passwd),
        ]);
        
        // 后端返回 json 'info' => 'signup success.' http状态码 200
        return response()->json([
            'info' => 'signup success.'
        ], 200);
    }

    public function login(Request $request) // 登陆
    {
        // 前端发送 json 'tel'=>手机号，'passwd'=>'密码'
        $data = $request->getContent();
        $data = json_decode($data, true);

        if (Auth::attempt(['tel' => $data['tel'], 'passwd' => $data['passwd']])) 
        // 手机号存在于数据库，密码符合邮箱，且正确
        {
            $user = User::where('tel', $data['tel']); // 查询到这个用户元组

            $user->token = createtoken(); // 用户登陆时新建一个token，插入数据库
            $time_out = strtotime("+2 hours");
            $user->time_out = $time_out; // token 过期时间是2个小时。

            /* 正确情况：成功登陆
            后端返回 json 'info' => 'login success.'
                            'id' => userid，之后的交互都是用此值代表用户。是后端查表用的主码
                            'token' => token
                             http状态码 200
            */
            return response()->json([
                'info' => 'login success.',
                'id' => $user->id,
                'token' => $user->token
            ], 200);
        }
        else
        {   // 错误情况：登录失败，用户名不存在或者密码错误
            // 后端返回 json 'info' => 'login failure.' http 状态码：400
            return response()->json([
                'info' => 'login failure.'
            ], 400);
        }
    }

    // 生成token，copy自 https://blog.csdn.net/qq_26291823/article/details/53337518
    public function createtoken() 
    {
        $str = md5(uniqid(md5(microtime(true)),true));  //生成一个不会重复的字符串
        $str = sha1($str);  //加密
        return $str;
    }

    /* token验证逻辑，检查token是否相同且是否过期。
    $id: int型，用户id，User表的主码
    $token: stirng，前端发来的要验证的token
    
    每个接口都必须调用这个函数验证token
    */
    public function checktoken($id, $token)
    {   
        $user = User::where('id', $id);
        if($user)
        {
            if($user->token == $token)
            {
                if((time() - $user->time_out) > 0)
                {
                    return 'timeout'; // 长时间未操作，token超时，要重新登陆
                }
                $new_time_out = time() + 7200; // 更新token时间，7200秒是两小时
                $user->time_out = $new_time_out; 
                return 'success'; // token验证成功并刷新时间，可以继续获得接口信息。
            }
            else 
                return 'tokenerror'; // token有误
        }
        else 
            return 'iderror'; // user id 有误
    }

    public function logout(Request $request)
    { // 前端发送 json 'id'=> userid
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = User::where('id', $data['id']);
        if($user)
        {
            $user->time_out = time(); // token超时时间设定为当下时间，之后token验证必定超时，实现登出。
             // 成功登出返回http 200
            return response()->json([
                'info' => 'logout success.'
            ], 200);
        }
        else
        {
            //出错情况：userid 错误，返回http 400
            return response()->json([
                'info' => 'user id does not exist.'
            ], 400);
        }
    }

    // 忘记密码第一步：验证手机号是否已经注册
    public function passwdForget(Request $request)
    { // 前端发送 json 'tel' => 手机号
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = User::where('tel', $data['tel']);
        if($user)
        {
            // 该手机号存在。返回id和http 200
            return response()->json([
                'info' => 'user exists.',
                'id' => $user->id
            ], 200);
        }
        else
        {   // 手机号不存在。返回http 400
            return response()->json([
                'info' => 'tel does not exist.'
            ], 400);
        }
    }

    // 忘记密码第二步：密码改为新密码
    public function passwdReset(Request $request)
    { /* 前端发送 json 'id' => userid
                      'passwd' => 新密码
        */
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = User::where('id', $data['id']);
        if($user)
        {
            $user->passwd = bcrypt($request->passwd);
            // 成功修改密码。返回http 200
            return response()->json([
                'info' => 'user exists.'
            ], 200);
        }
        else
        {   // user id 错误。返回http 400
            return response()->json([
                'info' => 'user id does not exist.'
            ], 400);
        }
    }
}
