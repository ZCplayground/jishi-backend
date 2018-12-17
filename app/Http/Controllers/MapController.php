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
    	$restaurants=Restaurant::select('id','name','canteen','longitude','latitude')->get();
        
    	
    	//返回所有商家的 {id,name,canteen,longitude,latitude},http 202
        foreach ($restaurants as $value) {
            if($value["canteen"] == "丁香园一楼")
            {
                $value["canteen"] = '0';
            }
            elseif ($value["canteen"] == "丁香园二楼") {
                $value["canteen"] = '1';
            }
            elseif ($value["canteen"] == "京元食堂") {
                $value["canteen"] = '2';
            }
            elseif ($value["canteen"] == "玫瑰园一楼") {
                $value["canteen"] = '3';
            }
            elseif ($value["canteen"] == "玫瑰园二楼") {
                $value["canteen"] = '4';
            }
            elseif ($value["canteen"] == "朝阳餐厅") {
                $value["canteen"] = '5';
            }
            
        }

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
