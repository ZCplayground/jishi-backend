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
        $json ='{
            "dishNum": "2",
            "dish1": {
                "idDish": "1",
                "idRest": "1",
                "RestName": "兰州拉面",
                "dishName": "炒面",
                "canteen": "玫瑰一楼"
            }, 
            "dish2": {
                "idDish": "2",
                "idRest": "1",
                "RestName": "兰州拉面",
                "dishName": "炒饭",
                "canteen": "玫瑰一楼"
            }
        }';
        return $json; 
    }
}
