<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Dish;

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
	
	public function clickOnRedPoint(Request $request)
	{
		// 发送 id => 店铺id
		// 返回到店铺名字，所属食堂名字和一个随机的招牌菜

		$data = $request->getContent();
		$data = json_decode($data, true);
		
		$rest = Restaurant::where('id', $data['id'])->first();
		
		$ret = [];
		$ret['name'] = $rest->name;
		$ret['canteen'] = $rest->canteen;

		$zhaopaicai = Menu::where('rest_id', $data['id'])->first();
		$zhaopaicai_id = $zhaopaicai->dish_id;
		$dish = Dish::where('id', $zhaopaicai_id)->first();

		$ret['zhaopaicai'] = $dish->name;

		return $ret;
	}
}
