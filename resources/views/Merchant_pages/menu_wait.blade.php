<!DOCTYPE html>
<html>
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>菜品管理界面</title>

        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <script src="js/echarts.min.js"type="text/javascript"></script>
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/global.js"type="text/javascript"></script>


    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="main.html">即食商家端 </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        <form class="navbar-search pull-left input-append" action="#">
                        <input type="text" class="span3">
                        <button class="btn" type="button">
                            <i class="icon-search"></i>
                        </button>
                        </form>
                        <ul class="nav pull-right">
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">消息
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">3</li>
                                    <li><a href="#">4</a></li>
                                </ul>
                            </li>
                            <li><a href="#">您好，小米米商铺</a></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/user.png" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">个人信息</a></li>
                                    <li><a href="#">修改资料</a></li>
                                    <li><a href="#">设置</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ URL::route('Merchant_index')}}">退出登录</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                          <ul class="widget widget-menu unstyled">
                              <li class="main.html"><a href="{{ URL::route('Merchant_main')}}"><i class="menu-icon icon-dashboard"></i>商铺信息
                              </a></li>
                              <li><a href="{{ URL::route('Merchant_menu')}}"><i class="menu-icon icon-bullhorn"></i>菜品管理</a>
                              </li>
                              <li><a href="{{ URL::route('Merchant_comment')}}"><i class="menu-icon icon-inbox"></i>用户评论 <b class="label green pull-right">
                                  </b> </a></li>
                              <li><a href="{{ URL::route('Merchant_form')}}"><i class="menu-icon icon-tasks"></i>用户分析报告 </a></li>
                          </ul>
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->

                    <div class="span9">
                        <div class="content">
                          <div class="module">

                          <nav class="navbar navbar-default" role="navigation">
                                <div class="container-fluid" >
                                <div>
                                    <ul class="nav navbar-nav" >
                                        <li style="font-size:16px"><a href="{{ URL::route('Merchant_menulist')}}">菜品查看</a></li>
                                        <li style="border-bottom:1px solid #000000;font-size:16px"><a href="{{ URL::route('Merchant_menu')}}">新菜品提交</a></li>
                                    </ul>
                                </div>
                                </div>
                            </nav>
                          <!--
              							<div class="module-head">
              								<h3>新菜品提交</h3>
              							</div>
                            -->
                            <div style="margin-top:100px;margin-bottom:200px">
                            <div style="text-align: center;vertical-align: middle;">
                            <img src="img/wait.gif" alt="" />
                            <br/><br/>
                            <span style="font-size:20px">已提交后台审核</span>
                            </div>
                            </div>
                            </div>
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer" align="center">
            <div class="container" >
                <p class="copyright" >&copy; 爸爸饿了战队 </p>
            </div>
        </div>

        </script>
    </body>
