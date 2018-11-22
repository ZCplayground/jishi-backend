<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
             // 表名：questions，存放问题
                                      // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->increments('id'); // id     |问题的ID     |从1递增的正整数  |主码
            $table->string('content');// content|题面         |stirng|
            $table->boolean('choice');// choice |当前端按下“打勾”按钮，这道问题对应的attr的值|bool|有例子，在下方
            $table->string('attr');   // attr   |问题对应的食品维度|string，菜的七个维度之一|
            
            /* id  content       choice   attr   
               1   今日无辣不欢？   1      spicy
               2   今天我不想吃辣。 0      spicy
               
             这两个问题对应的食品维度是spicy（辣不辣）
             所有问题都是判断题，最终用户只有打勾或打叉这两个按钮可以选择。
             id=1的这个问题，“今日不辣不欢”  choice=1 代表 当用户按下打勾按钮时，他是想吃对应的属性（也就是spicy）的食物。
             id=2的这个问题，“今天我不想吃辣”choice=0 代表 当用户按下打勾按钮时，他不想吃对应的属性（也就是spicy）的食物。
               */

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
        Schema::dropIfExists('questions');
    }
}
