<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            // 表名：records，存放推荐记录
                                                    // 属性名   |简单描述           |数据类型或描述   |额外信息
            $table->increments('id');               // id      |推荐记录的id        |从1递增的正整数  |主码
            $table->integer('user_id')->unsigned(); // user_id |用户id             |unsigned int    |外码，引用users表的id字段
            $table->string('question_id_list');     // question_id_list |问题列表  |string          |用逗号隔开的问题id字符串，形如:"3,20,30"
            $table->string('answer_list');          // answer_list      |答案列表  |stirng          |用逗号隔开的用户答案，y代表打勾，n代表打叉，例如:"y,n,y"
            $table->string('dish_id_list');         // dish_id_list     |推荐记录  |stirng          |用逗号隔开的推荐的菜点id，形如:"5,123,234"
            $table->integer('finalchoice')->unsigned()->nullable();
                                                    // finalchoice      |最后用户选择了那道菜|unsigned int|用户按下“带我去”这个按钮时选择的是哪道菜，最后对此进行好评或差评。是dish id的外码。
            $table->integer('rest_id')->unsigned()->nullable();
                                                    // rest_id          |finalchoice对应的店铺id|unsigned int|
            $table->boolean('judge')->nullable();   // judge            |好评或差评 |bool           |好评true，差评false
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
