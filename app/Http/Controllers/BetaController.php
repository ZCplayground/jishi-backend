<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Question;
use App\Models\Restaurant;
use App\Models\Record;
use App\Models\Menu;
use App\Models\User;

class BetaController extends Controller
{
    public function dishRank(){

        
        $rankData = DB::select('select max(restaurants.canteen) as canteenName, max(restaurants.name) as restName, max(dishes.name) as dishName, count(finalchoice) as count from restaurants,records, menus,dishes where records.finalchoice = menus.dish_id AND menus.rest_id = restaurants.id AND records.finalChoice = dishes.id group by finalchoice order by count(finalchoice) desc');

        $num = count($rankData);
        
        if ($num <= 5){
            return $rankData;
        }
        else{
            return array_slice($rankData,0,5);   
        }
    }
    
    public function history(Request $request)
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $ret = checktoken($data['id'], $data['token']);
        if($ret === 'iderror')
        {
            // user id 错误。
            return response()->json([
                'info' => 'user id does not exist.'
            ], 400);
        }
        else if($ret === 'tokenerror')
        {
            // token 有误。有可能是伪造的post包
            return response()->json([
                'info' => 'token error.'
            ], 401);
        }
        else if($ret === 'timeout')
        {
            // token 超时。
            return response()->json([
                'info' => 'token time out.'
            ], 402);
        }
        else if($ret === 'success')
        {
            // token验证成功
            
            $records = Record::where('user_id', $data['id'])->get(); // 到数据库中查到这个用户所有的推荐记录
            $num = count($records); // 推荐记录的总数

            $history = [];
            $history['recordNum'] = $num;

            for($i = 0; $i<$num; $i++) // 处理每一条record
            {
                $record = [];
                $record['recordid'] = $records[$i]->id; // 存放record的主码

                $question_id_list = $records[$i]->question_id_list;
                trim($question_id_list,"[]");

                $question_id_list =explode(",",$question_id_list); // 把问题字符串处理成数组，存放问题id
                $size = count($question_id_list); // 问题id数组长度（现在是3）

                for($ii = 0; $ii < $size; $ii++) // 从0~2
                // 对每一个问题到表里查问题的题面，存放进json
                {
                    $question = Question::where('id', $question_id_list[$ii])->first();
                    $content = $question['content'];
                    $record['qustion'.$ii] = $content;
                }

                $record['answer_list'] = $records[$i]->answer_list;  // 把answer_list和dish_id_list的字符串都存入json
                $record['dish_id_list'] = $records[$i]->dish_id_list;

                $dish_id_list = $records[$i]->dish_id_list; // 对于dish要详细信息，因此要进行和question一样的处理
                trim($dish_id_list, "[]");
                $dish_id_list = explode(",", $dish_id_list);
                $size = count($dish_id_list);
                // 例如189,481,254,80,314 处理成 189 481 254 80 314
                for($ii = 0; $ii < $size; $ii++) // 从0~4
                {
                    $one_dish = [];

                    $dish = Dish::where('id', $dish_id_list[$ii])->first();
                    $dish_name = $dish->name;
                    $menu_entry = Menu::where('dish_id', $dish_id_list[$ii])->first();
                    $rest_id = $menu_entry->rest_id;
                    $rest = Restaurant::where('id', $rest_id)->first();
                    $rest_name = $rest->name;
                    $rest_canteen = $rest->canteen;

                    $one_dish['dishid'] = $dish_id_list[$ii];
                    $one_dish['dishname'] = $dish_name;
                    $one_dish['restname'] = $rest_name;
                    $one_dish['canteen'] = $rest_canteen;

                    $record['dish'.$ii] = $one_dish;
                }
                // 最终选择“带我走”的是那一个菜
                $finalchoice = $records[$i]->finalchoice;
                if(is_null($finalchoice)) // ($finalchoice == null)
                {
                    $finalchoice = "empty";
                }
                else 
                {
                    $dish_id = $finalchoice;
                    $dish = Dish::where('id', $dish_id)->first();
                    $finalchoice = $dish->name;
                }
                $record['finalchoice'] = $finalchoice;

                // 好评或差评
                $judge = $records[$i]->judge;
                if(is_null($judge))   //($judge == null)
                {
                    $judge = "empty";
                }
                $record['judge'] = $judge;



                $history['record'.$i] = $record;
            }
            return $history;
        }
    }
    
    public function statistic(Request $request)
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $records = Record::where('user_id', $data['id'])->get(); // 到数据库中查到这个用户所有的推荐记录
        $num = count($records); // 推荐记录的总数

        return $num;
    }

    
    public function randRecommend(Request $request)
    {  
        function saveRecords($data)
        {
            
            
            $usrId=$data['idUser'];
            $queId=$data['idQuestions'];
            $ans=$data['ans'];
            $dishId=$data['idDishes'];
            
            
            $record=Record::create([ // 存入数据库
                'user_id' => $usrId,
                'question_id_list' => $queId,
                'answer_list' => $ans,
                'dish_id_list' => $dishId,
            ]);
    
            return $record->id;    
        }
        

        $data = $request->getContent();
        $data = json_decode($data, true);
    
        $ret = checktoken($data['id'], $data['token']);
        if($ret === 'iderror')
        {
            // user id 错误。返回http 400
            return response()->json([
                'info' => 'user id does not exist.'
            ], 400);
        }
        else if($ret === 'tokenerror')
        {
            // token 有误。
            return response()->json([
                'info' => 'token error.'
            ], 401);
        }
        else if($ret === 'timeout')
        {
            // token 超时。
            return response()->json([
                'info' => 'token time out.'
            ], 402);
        }
        else if($ret === 'success')
        {
    
            $dishes =  DB::table('dishes')
            ->inRandomOrder()->take(5)->get();
    
            
            $recommends =[];
            $dishesNum = count($dishes);
            $recommends['dishNum'] = $dishesNum;
            $idDishes = "";
            for ($ii=0;$ii<$dishesNum;$ii++)
            {
                $recommend = [];
                $idDish = $dishes[$ii]->id;
                $dishName = $dishes[$ii]->name;
                $idRest = Menu::where('dish_id', $idDish)->first();
                $idRest = $idRest->rest_id;
                $resturant = Restaurant::where('id',$idRest)->first();
                $canteen = $resturant->canteen;
                $restName = $resturant->name;
    
                $recommend['idDish'] = $idDish;
                $recommend['idRest'] = $idRest;
                $recommend['restName'] = $restName;
                $recommend['dishName'] = $dishName;
                $recommend['canteen'] = $canteen;
    
                $recommends['dish'.$ii] = $recommend;
                
                if ($ii != $dishesNum - 1)
                {
                    $idDishes = $idDishes . $idDish.',';
                }
                else
                {
                    $idDishes = $idDishes . $idDish;
                }
            }
    
            
            $saveData = [];
            $saveData['idUser'] = $data['id'];
            $saveData['idQuestions'] = "";
            $saveData['ans'] = "";
            $saveData['idDishes'] = $idDishes;

            // except for $finalChoice
            $idRecord = saveRecords($saveData);
            $recommends['idRecord'] = $idRecord;

            return $recommends; 
        }
    }

}