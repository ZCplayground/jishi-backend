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
        // $request:
        //      idQuestions = 1,2,3
        //      ans = y,n,y
        //
        $idQuestions =$request->idQuestions;
        trim($idQuestions,"[]");
        $idQuestions =explode(",",$idQuestions);
        
        $ans = $request->ans;
        trim($ans,"[]");
        $ans = explode(",",$ans);
        $attrs = [];
        $values = [];
        $questionnum = count($idQuestions);

        $attrList = ['spicy','balance','oil','seafood','rice','noodles','mifen'];
        $attrUsed = [0,0,0,0,0,0,0];
        for ($i=0; $i<$questionnum;$i++)
        {
        // select 'attr' and 'choice' from Question where id = $idQuestion;
            $questionAttr = Question::where('id', $idQuestions[$i])->select('attr','choice')->first();
            $attrs[$i] = $questionAttr->attr;
            if ($ans[$i] == 'y')
            {
                $attrs[$i] = $questionAttr->choice;
                $attrUsed[array_search($attrs[$i], $attrList)] = 1;
            }
            else
            {
                $values[$i] = ~$questionAttr->choice;
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

        }

        $recordData = [];
        $recordData['dishes'] = $recommends;
        $recordData['hopeDishesNumber'] = 5;// to do: change the port 
        $recordData['ans'] = $request->ans;
        $recordData['idQuestions'] = $request->idQuestions;

        // except for $finalChoice
        //saveRecord(json_encode($recordData));

        return $recommends;
        // return response($dishes->toJson())
        //     ->header('content-type','application/json');
    }
}
