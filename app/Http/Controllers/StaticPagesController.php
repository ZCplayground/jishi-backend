<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\Menu;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        return '主页';
    }
    public function help()
    {
        return '帮助页';
    }
    public function about()
    {
        return '关注页';
    }

    public function importQuestions() // 导入问题
    {
        $file = fopen("questions.csv","r"); // 放在 public 文件夹

        while(!feof($file))
        {
            $data = (fgetcsv($file));
            $question = Question::create([
                'content' => $data[0],
                'choice' => $data[1],
                'attr' => $data[2],
            ]);
        }
        // 注意.csv文件不要有空行。
        fclose($file);
        return 'import Questions success. ';
    }
    
    public function importRestaurants() // 导入餐厅数据
    {
        $file = fopen("restaurants.csv","r");

        while(!feof($file))
        {
            $data = (fgetcsv($file));
            $restaurant = Restaurant::create([
                'name' => $data[0],
                'canteen' => $data[1],
                'longitude' => $data[3],
                'latitude' => $data[4],
                'vip' => false,
            ]);
        }
        fclose($file);
        return 'import Restaurants success. ';
    }

    public function importDishes() // 导入菜品信息 未完成的函数
    {
        $canteens = ['丁香园一楼', '丁香园二楼', '京元食堂', '玫瑰园一楼', '玫瑰园二楼', '朝阳餐厅']; // 每一个食堂有一个对应的.csv后缀的文件。
        
        // csv文件名："玫瑰园二楼.csv"
        // 列：店铺名	菜名	辣不辣	膳食均衡搭配	重油	包含海鲜	米饭	面	粉
        //例子：爱米渔	招牌鱼粉	1	1	0	1	0	0	1
        foreach($canteens as $canteen) // 对每个餐厅的文件
        {
            $filename = $canteen.".csv";
            $file = fopen($filename, "r"); // 打开这个文件

            while(!feof($file))
            {
                $data = (fgetcsv($file));
                
                $dish = Dish::create([
                    'name' => $data[1],
                    'spicy' => $data[2],
                    'balance' => $data[3],
                    'oil' => $data[4],
                    'seafood' => $data[5],
                    'rice' => $data[6],
                    'noodles' => $data[7],
                    'mifen' => $data[8],
                ]);

                $restaurant = Restaurant::where('name', $data[0])->first();

                $menu = Menu::create([
                    'rest_id' => $restaurant->id,
                    'dish_id' => $dish->id,
                ]);
            }
            fclose($file);
        }
        return 'import Dishes success. ';
    }

    /*public function importdata()
    {
        $ret1 = importQuestions();
        $ret2 = importRestaurants();
        $ret3 = importDishes();

        return $ret1.$ret2.$ret3;
    }*/
	

}
