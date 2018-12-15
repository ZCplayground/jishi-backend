<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Restaurant;

class MapController extends Controller
{
    public function mapRequest()
    {


    	$restaurants=Restaurant::select('id','name','longitude','latitude')->get();
    	// $restaurants = trim($restaurants, "\xEF\xBB\xBF");
    	
    	//返回所有商家的 {id,name,longitude,latitude},http 202

    	return response()->json(
    		$restaurants
            , 202);

    }
}
