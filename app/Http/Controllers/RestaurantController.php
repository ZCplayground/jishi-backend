<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Restaurantaccount;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Menu;

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
        if($restaurant)
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

    public function dishInfo(Request $request){
        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];

        $tokenResult = RestaurantController::checkRestaurantToken($request);
        if ($tokenResult == 'success')
        {
            
            $restaurant = Restaurantaccount::where('id', $id)->first();
            $rest_id = $restaurant->rest_id;
            $dishes = Menu::where('rest_id',$rest_id)
                        ->join('dishes','menus.dish_id','=','dishes.id')
                        ->get();
            $response =[];
            $response['dishNum'] = count($dishes);
            if ($dishes){
                for ($i=0;$i<count($dishes);$i++){
                    $response['dishes']['dish'.$i]['dishId'] = $dishes[$i]->dish_id;
                    $response['dishes']['dish'.$i]['dishName'] = $dishes[$i]->name;
                    // maybe need to return taste
                }
                return $response;
            }
            else{
                return ['dishNum' =>0];
            }
        }
        else{
            return response()->json([
                'info' => 'RestaurantId or token error.'
            ], 400);
        }
    }


    public function dishAdd(Request $request){
        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];

        $tokenResult = RestaurantController::checkRestaurantToken($request);
        if ($tokenResult == 'success')
        {
            /*
            increments('id');
            string('name');  
            boolean('spicy')->nullable();
            boolean('balance')->nullable();
            boolean('oil')->nullable();
            boolean('seafood')->nullable();
            boolean('rice')->nullable();
            boolean('noodles')->nullable();
            boolean('mifen')->nullable();
            double('satisfaction')->nullable();
            */
            $restaurant = Restaurantaccount::where('id', $id)->first();
            $rest_id = $restaurant->rest_id;
            $dish = Dish::create([ // 存入数据库
                    'name' => $data['name']
                    // 'spicy' => $data['spicy'],
                    // 'balance' => true,
                    // 'oil' => true,
                    // 'seafood' => true,
                    // 'rice' => true,
                    // 'noodles' => true,
                    // 'mifen' => true,
                ]);
            

            $dish_menu = Menu::create([
                'rest_id'=>$rest_id,
                'dish_id'=>$dish->id
            ]);
            return $dish;
        }
        else{
            return response()->json([
                'info' => 'RestaurantId or token error.'
            ], 400);
        }
    }


    public function dishRemove(Request $request){
        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];
        $dishId = $data['dishId'];

        $tokenResult = RestaurantController::checkRestaurantToken($request);
        if ($tokenResult == 'success')
        {
            $dish = Dish::where('id',$dishId)->get();
            if ($dish)
            {
                $restaurant = Restaurantaccount::where('id',$id)->first();
                if (!($restaurant)){
                    return response()->json([
                        'info' => 'RestaurantId error.'
                    ], 400);   
                }
                $menu = Menu::where('rest_id',$restaurant->rest_id)
                        ->where('dish_id',$dishId)->first();
                if (!($menu)){
                    return response()->json([
                        'info' => 'RestaurantId or DishId may be error.'
                    ], 400);   
                }
                
                Menu::where('rest_id',$restaurant->rest_id)
                ->where('dish_id',$dishId)->delete();
                Dish::where('id',$dishId)->delete();
                
                return ['info'=>'Delete success.','dish'=>$dish];
            }
            else 
            {
                return response()->json([
                    'info' => 'DishId error.'
                ], 400);   
            }
        }
        else{
            return response()->json([
                'info' => 'RestaurantId or token error.'
            ], 400);
        }
    }

    public function dishAlter(Request $request){
        $data = $request->getContent();
        $data = json_decode($data, true);

        $id = $data['id'];
        $dishId = $data['dishId'];

        $tokenResult = RestaurantController::checkRestaurantToken($request);
        if ($tokenResult == 'success')
        {
            $restaurant = Restaurantaccount::where('id',$id)->first();
            if (!($restaurant)){
                return response()->json([
                    'info' => 'RestaurantId error.'
                ], 400);   
            }
            $menu = Menu::where('rest_id',$restaurant->rest_id)
                    ->where('dish_id',$dishId)->first();
            if (!($menu)){
                return response()->json([
                    'info' => 'RestaurantId or DishId may be error.'
                ], 400);   
            }

            $dish = Dish::where('id',$dishId)->first();
            if ($dish == null){
                return response()->json(
                    ['info' => "Modify failed"],401
                );    
            }


            $num = Dish::where('id',$dishId)
                        ->update(['name' => ((array_key_exists('name',$data))? $data['name']:$dish->name),
                        'spicy' => ((array_key_exists('spicy',$data))? $data['spicy']: $dish->spicy),
                        'balance' => ((array_key_exists('balance',$data))? $data['balance']: $dish->balance),
                        'oil' => ((array_key_exists('oil',$data))? $data['oil']: $dish->oil),
                        'seafood' => ((array_key_exists('seafood',$data))? $data['seafood']: $dish->seafood),
                        'rice' => ((array_key_exists('rice',$data))? $data['rice']: $dish->rice),
                        'noodles' => ((array_key_exists('noodles',$data))? $data['noodles']: $dish->noodles),
                        'mifen' =>((array_key_exists('mifen',$data))? $data['mifen']: $dish->mifen),
                    ]);
            $dishNew = Dish::where('id',$dishId)->first();
            
            if ($dishNew == null){
                return response()->json(
                    ['info' => "Modify failed"],401
                );    
            }
           
            return $dishNew;
        }
        else{
            return response()->json([
                'info' => 'RestaurantId or token error.'
            ], 400);
        }
    }

}
