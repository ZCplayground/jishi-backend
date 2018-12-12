<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
          
          
         
         
          
       
          
     // 商家登陆界面
           public function index()
          {
     	return view('Merchant_pages/index');
     }
     // 用户评论界面
     public function comment()
     {
     	return view('Merchant_pages/comment');
     }

     // 商家忘记密码界面
     public function forget()
     {
     	return view('Merchant_pages/forget');
     }

     // 用户分析报告界面
     public function form()
     {
     	return view('Merchant_pages/form');
     }

     // 商家首页
     public function main()
     {
     	return view('Merchant_pages/main');
     }

     // 菜品提交界面
     public function menu()
     {
     	return view('Merchant_pages/menu');
     }

     // 商家注册界面
     public function register()
     {
     	return view('Merchant_pages/register');
     }

}
