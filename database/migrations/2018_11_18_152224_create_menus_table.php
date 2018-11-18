<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            // 表名：menus，restaurant和dish的一对多关系的中间表
                                                    // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->integer('rest_id')->unsigned(); // rest_id |店铺id      |unsigned int    |外码，引用restaurants表的id字段
            $table->integer('dish_id')->unsigned(); // dish_id |菜品id      |unsigned int    |外码，引用dishes表的id字段

            $table->foreign('rest_id')->references('id')->on('restaurants');
            $table->foreign('dish_id')->references('id')->on('dishes');
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
        Schema::dropIfExists('menus');
    }
}
