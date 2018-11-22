<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            // 表名：restaurants，存放店铺的信息
                                      // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->increments('id'); // id     |店铺id       |从1递增的正整数  | 主码。处理数据时注意录入顺序
            $table->string('name');   // name   |名称         |string          | 无
            $table->string('canteen');// canteen|该店属于哪个食堂|stirng        |例：name:六号餐厅，canteen:玫瑰二楼
            $table->string('tel')->nullable();    // tel    |店家电话     |string          | 我操 这个好像没人去收集
            $table->decimal('longitude', 10, 7);
                                      //longitude|经度        |有效位10位，小数位7位|例如：119.19904
            $table->decimal('latitude', 10, 7);
                                      //latitude |纬度        |有效位10位，小数位7位|例如：22.062767
            $table->boolean('vip')->nullable();   // vip     |是否购买了会员| 布尔值        |无
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
