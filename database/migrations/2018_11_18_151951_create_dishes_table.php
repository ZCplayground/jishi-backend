<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            // 表名：dishes，存放每一道菜品的信息
                                     // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->increments('id');// id     |菜品id       |从1递增的正整数  |主码。处理数据时注意录入顺序
            $table->string('name');  // name   |菜名         |string|无
            $table->boolean('spicy')->nullable();// spicy  |是否辣       | bool，辣为true，不辣为false。下属bool类型属性均相似，省略 |无
            $table->boolean('balance')->nullable(); //balance|是否属于营养均衡食品|bool|无
            $table->boolean('oil')->nullable();  // oil    |是否属于油脂过高食品|bool|无
            $table->boolean('seafood')->nullable(); // seafood|是否包含海鲜类食品|bool|无
            $table->boolean('rice')->nullable();  // rice  |是否为米饭    |bool| rice, noodles, mifen 这三个bool类型属性有且只有一个为真
            $table->boolean('noodles')->nullable();// noodles |是否为面条 |bool|
            $table->boolean('mifen')->nullable(); // mifen  |是否为米粉   |bool| 我佛了，为什么要把米粉和面条分开。还有为什么没有汉堡的类别，我要吃垃圾食品！！！！
            $table->double('satisfaction')->nullable(); //satisfaction|满意度|double|推荐这道菜的record的数量，其中确定为满意的比例
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
        Schema::dropIfExists('dishes');
    }
}
