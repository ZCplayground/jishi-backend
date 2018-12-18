<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Question;
use App\Models\Restaurant;
use App\Models\Record;
use App\Models\Menu;

class RecommendController extends Controller
{
    public function recommend(Request $request)
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
            $idQuestions =$request->idQuestions;
            trim($idQuestions,"[]");
            $idQuestions =explode(",",$idQuestions);
            
            $ans = $request->ans;
            trim($ans,"[]");
            $ans = explode(",",$ans);
    
    
            $attrs = [];
            $values = [];
            $questionNum = count($idQuestions);
            $attrList = ['spicy','balance','oil','seafood','rice','noodles','mifen'];
            $attrUsed = [0,0,0,0,0,0,0];
            for ($i=0; $i<$questionNum;$i++)
            {
            // select 'attr' and 'choice' from Question where id = $idQuestion;
                $questionAttr = Question::where('id', $idQuestions[$i])->select('attr','choice')->first();
                $attrs[$i] = $questionAttr->attr;
                if ($ans[$i] == 'y')
                {
                    $attrUsed[array_search($attrs[$i], $attrList)] = 1;
                    $values[array_search($attrs[$i], $attrList)] = $questionAttr->choice;
                }
                else
                {
                    $attrUsed[array_search($attrs[$i], $attrList)] = 1;
                    $values[array_search($attrs[$i], $attrList)] = (int)!($questionAttr->choice);
                }
            }
    
    
    
            $dishes = Dish::when($attrUsed[0], function ($query) use ($values, $attrList) {
                return $query->where($attrList[0], $values[0]);
            })
            ->when($attrUsed[1], function ($query) use ($values, $attrList) {
                return $query->where($attrList[1], $values[1]);
            })
            ->when($attrUsed[2], function ($query) use ($values, $attrList) {
                return $query->where($attrList[2], $values[2]);
            })
            ->when($attrUsed[3], function ($query) use ($values, $attrList) {
                return $query->where($attrList[3], $values[3]);
            })
            ->when($attrUsed[4], function ($query) use ($values, $attrList) {
                return $query->where($attrList[4], $values[4]);
            })
            ->when($attrUsed[5], function ($query) use ($values, $attrList) {
                return $query->where($attrList[5], $values[5]);
            })
            ->when($attrUsed[6], function ($query) use ($values, $attrList) {
                return $query->where($attrList[6], $values[6]);
            })
            ->inRandomOrder()->take(5)->get();
    
            // $ch = curl_init();
            // curl_setopt($ch,CURLOPT_URL,"127.0.0.10:5000/");
            // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            // curl_setopt($ch,CURLOPT_HEADER,0);
            // $data= $request->getContent();
            // $data = json_decode($data,true);
            // $requestString = json_encode($data);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
            // curl_setopt($ch, CURLOPT_POST,true);
            // $dish = curl_exec($ch);
            // curl_close($ch);
    
            
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
                // 加个整数
                if($recommend["canteen"] == "丁香园一楼")
                {
                    $recommend["canteenid"] = '0';
                }
                elseif ($recommend["canteen"] == "丁香园二楼") {
                    $recommend["canteenid"] = '1';
                }
                elseif ($recommend["canteen"] == "京元食堂") {
                    $recommend["canteenid"] = '2';
                }
                elseif ($recommend["canteen"] == "玫瑰园一楼") {
                    $recommend["canteenid"] = '3';
                }
                elseif ($recommend["canteen"] == "玫瑰园二楼") {
                    $recommend["canteenid"] = '4';
                }
                elseif ($recommend["canteen"] == "朝阳餐厅") {
                    $recommend["canteenid"] = '5';
                }

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
            $saveData['idQuestions'] = $data['idQuestions'];
            $saveData['ans'] = $data['ans'];
            $saveData['idDishes'] = $idDishes;

            // except for $finalChoice
            $idRecord = saveRecords($saveData);
            $recommends['idRecord'] = $idRecord;

            return $recommends;
            // return response($dishes->toJson())
            //     ->header('content-type','application/json');
    
        }
    }



    public function storeRecords(Request $request){
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
            $recordid=$data['idRecord'];
            $finalChoice=$data['finalChoice'];
            $judge=$data['judge']=='true' ? 1 : 0;

            $restId = Menu::where('dish_id',$finalChoice)->value('rest_id');

            $record = Record::where('id',$recordid)
                        ->update(['finalchoice'=>$finalChoice,'judge'=>$judge,'rest_id'=>$restId]);
            
            if ($record == null){
                return response()->json(
                    ['info' => "save failed"],403
                );    
            }
            else{
                return response()->json(
                    ['info' => "save sucessfully"],200
                );   
            }
        }

    }
}
