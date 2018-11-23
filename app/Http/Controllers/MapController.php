<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Restaurant;

class MapController extends Controller
{
       public function mapRequest()
    {


    	$restaurants=Restaurant::select('name','longitude','latitude')->get();
    	// $restaurants = trim($restaurants, "\xEF\xBB\xBF");
    	
    	//返回所有商家的 {name,longitude,latitude},http 201

    	return response()->json(
    		$restaurants
            , 202);

    }
}
