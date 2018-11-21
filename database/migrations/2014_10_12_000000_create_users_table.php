<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // 表名：users，存放用户数据
                                                // 注释格式如下：                          
                                                // 属性名  |简单描述     |数据类型或描述   |额外信息
            $table->increments('id');           // id     |用户的ID     |从1递增的正整数  |主码
            $table->string('tel')->unique();    // tel    |用户的电话号码|string          |登陆用，必须是唯一的
            $table->boolean('newhere');         // newhere|新登陆的用户要回答几个问题确定基本口味|bool|alpha版本不实现
            $table->string('passwd',1024);      // passwd | 密码        |string          |原文长度6~18之间。加密后存放 
            $table->string('token')->nullable();// token  | 标记        |string          |每当成功登陆后，后端生成随机数存放到token字段，发送给前端。每次前端有新的操作时，都要发送token到后台验证。  
            $table->bigInteger('time_out');     //time_out|token过期时间|string，date形式。
                        // 由于使用datetime导致MySql不适配、使用timestamp，Laravel不支持修改。故使用BigInteger类型。
            $table->timestamps();               // laravel后端框架的用户创建时间和更新时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
