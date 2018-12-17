<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurantaccount;

class RestaurantController extends Controller
{
    public function login(Request $request) // 登陆
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        
        $restaurant = Restaurantaccount::where('tel',$data['id'])->first();
        if ($restaurant)
        {
            $restaurant = Restaurantaccount::where('tel',$data['id'])->where('passwd', bin2hex(hash('sha256',$data['passwd'], true)))->first();

            if ($restaurant)// 手机号存在于数据库，密码符合邮箱，且正确
            {
                $restaurant = Restaurantaccount::where('tel', $data['id'])->first(); 

                $restaurant->token = createtoken(); 
                $time_out = strtotime("+1 year");
                $restaurant->time_out = $time_out; 
                $restaurant->save();
                return response()->json([
                    'info' => 'login success.',
                    'id' => $restaurant->id,
                    'token' => $restaurant->token,
                    "firstLogin" => 'false',
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
        else{
            $restaurant = Restaurantaccount::where('id',$data['id'])->first();
            if ($restaurant)
            {
                $restaurant = Restaurantaccount::where('id', $data['id'])
                    ->where('passwd', bin2hex(hash('sha256',$data['passwd'], true)))
                    ->first(); 
                if ($restaurant)
                {
                    $restaurant->token = createtoken(); 
                    $time_out = strtotime("+1 year");
                    $restaurant->time_out = $time_out; 
                    $restaurant->save();
                    if ($restaurant->tel!=null)//todo:?
                        $firstLogin = false;
                    else
                        $firstLogin = true;

                    
                    return response()->json([
                        'info' => 'login success.',
                        'id' => $restaurant->id,
                        'token' => $restaurant->token,
                        "firstLogin" => $firstLogin,
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
            else
            {
                return response()->json([
                    'info' => 'login failure.'
                ], 400);
            }

        }
 
    }

    public function logout(Request $request)
    { // 前端发送 json 'id'=> userid
        $data = $request->getContent();
        $data = json_decode($data, true);

        $user = User::where('id', $data['id'])->first();
        if($user)
        {
            $user->time_out = time(); // token超时时间设定为当下时间，之后token验证必定超时，实现登出。
            $user->save();
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

}
