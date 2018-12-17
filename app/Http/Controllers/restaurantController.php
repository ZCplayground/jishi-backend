<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Restaurantaccount;
use App\Models\Restaurant;

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
    { // 前端发送 json 'id'=> restaurantid
        $data = $request->getContent();
        $data = json_decode($data, true);

        $restaurant = Restaurantaccount::where('id', $data['id'])->first();
        if($restaurant)
        {
            $restaurant->time_out = time(); // token超时时间设定为当下时间，之后token验证必定超时，实现登出。
            $restaurant->save();
             // 成功登出返回http 200
            return response()->json([
                'info' => 'logout success.'
            ], 200);
        }
        else
        {
            //出错情况：restaurantid 错误，返回http 400
            return response()->json([
                'info' => 'restaurant id does not exist.'
            ], 400);
        }
    }

    // 检测restaurant账户的token是否正确
    protected function checkRestaurantToken(Request $request)
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];
        $restaurant = Restaurantaccount::where('id', $id)->first();
        $tokenResult = null;
        if($request)
        {
            if($restaurant->token === $data['token'])
            {
                if((time() - $restaurant->time_out) > 0)
                {
                    $tokenResult = 'timeout'; // 长时间未操作，token超时，要重新登陆
                }
                $new_time_out = time() + 7200000; // 更新token时间，7200秒是两小时
                $restaurant->time_out = $new_time_out; 
                $restaurant->save();
                $tokenResult = 'success'; // token验证成功并刷新时间，可以继续获得接口信息。
            }
            else 
                $tokenResult  = 'tokenerror'; // token有误
        }
        else 
            $tokenResult = 'iderror'; // restaurant id 有误
        return $tokenResult;
    }

    public function analyseReport(Request $request)
    {

        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];

        $tokenResult = RestaurantController::checkRestaurantToken($request);
        if ($tokenResult == 'success')
        {
            $history = DB::select('select records.created_at as time  from restaurants,records, menus,dishes, restaurantaccounts where records.finalchoice = menus.dish_id AND menus.rest_id = restaurants.id AND restaurantaccounts.id ='.$id.' AND restaurants.id = restaurantaccounts.rest_id AND records.finalChoice = dishes.id');

            $historyCount = count($history);
            $todayCount = 0;

            for ($ii=0; $ii<$historyCount; $ii++){
                $timeRecord = strtotime($history[$ii]->time);
                $timeToday = strtotime("today");
                $timeTomorrow = strtotime("tomorrow");

                if (($timeRecord>= $timeToday) && ($timeRecord <= $timeTomorrow))
                {
                    $todayCount +=1;
                }
            }

            $globalHistory = DB::select('select max(restaurants.id) as restId,count(restaurants.id) as count from restaurants,records, menus,dishes where records.finalchoice = menus.dish_id AND menus.rest_id = restaurants.id AND records.finalChoice = dishes.id group by restaurants.id order by count(restaurants.id) desc');

            // var_dump($globalHistory);

            $restaurant = Restaurantaccount::where('id', $id)->first();
            $rest_id = $restaurant->rest_id;
            $restaurantRank = count($globalHistory) + 1;
            
            for ($ii=0;$ii<count($globalHistory); $ii++){
                if ($globalHistory[$ii]->restId == $rest_id)
                    $restaurantRank = $ii+1;
            }

            $restaurantCount = DB::table('restaurants')->count();

            return ['historyCount' => $historyCount,
                    'todayCount' => $todayCount,
                    'rank' => $restaurantRank,
                    'totalRestaurantCount' => $restaurantCount];
        }
        else{
            return response()->json([
                'info' => 'RestaurantId or token error.'
            ], 400);
        }

    }



}
