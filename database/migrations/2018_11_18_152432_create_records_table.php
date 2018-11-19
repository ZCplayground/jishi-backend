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
            $table->increments('id'); // 推荐记录编号，主码
            $table->integer('user_id')->unsigned(); //用户id，外码
            $table->string('question_id_list');
            $table->string('answer_list');
            $table->string('dish_id_list');
            $table->integer('finalchoice')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('finalchoice')->references('id')->on('dishes');
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
