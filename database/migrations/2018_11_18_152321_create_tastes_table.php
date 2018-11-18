<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tastes', function (Blueprint $table) {
            // 表名：tastes，存放用户的口味的数据，用于实现KNN算法
                                                    // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->integer('user_id')->unsigned(); // user_id |用户id      |unsigned int    |外码，引用users表的id字段
            $table->double('spicy');                // spicy  |是否辣       | double |字段的意义和dishes表中的同名字段相同，但把数据类型改成double，便于聚类算法的实现。
            $table->double('nutritious');           //Nutritious|是否属于营养均衡食品|double|无
            $table->double('oil');                  // oil    |是否属于油脂过高食品|double|无
            $table->double('seafood');              // seafood|是否包含海鲜类食品|double|无
            $table->double('rice');                 // rice  |是否为米饭    |double| 
            $table->double('noodles');              // noodles |是否为面条 |double|
            $table->double('mifen');                // mifen  |是否为米粉   |double| 
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tastes');
    }
}
