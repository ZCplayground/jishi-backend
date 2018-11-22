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
        return 'success';
    }
    
    public function importDishes() // 导入菜品信息 未完成的函数
    {
        $canteens = ['玫瑰园二楼', '玫瑰园一楼', '京元餐厅', '丁香园二楼', '丁香园一楼', '朝阳餐厅']; // 每一个食堂有一个对应的.csv后缀的文件。
        
        // csv文件名："玫瑰园二楼.csv"
        // 列：店铺名	菜名	辣不辣	膳食均衡搭配	重油	包含海鲜	米饭	面	粉
        //例子：爱米渔	招牌鱼粉	1	1	0	1	0	0	1
        foreach($canteens as $canteen) // 对每个餐厅
        {
            $filename = $canteen.".csv";
            $file = fopen($filename, "r"); // 打开这个文件

            while(!feof($file))
            {
                $data = (fgetcsv($file));
                
                // 每家店铺只插入到 restaurants 表一次。
                // 先查询这个店铺是否已经被写入 restaurants 表
                $restaurant = Restaurant::where('name', $data['0'])->first();
                if(!$restaurant){ 
                    $restaurant = Restaurant::create([
                        'name' => $data[0],
                        'canteen' => $canteen,
                        // 食堂电话，经纬度，vip 待定
                    ]);
                }
                // 一个店铺有多道 dish，要插入 dishes 表多次。
                $dish = Dish::create([
                    'content' => $data[0],
                    'choice' => $data[1],
                    'attr' => $data[2],
                ]);
                
                $menu = Menu::create([
                    'rest_id' => $restaurant->id,
                    'dish_id' => $dish->id,
                ]);
            }
            
        }
        return $canteen;
    }
}
