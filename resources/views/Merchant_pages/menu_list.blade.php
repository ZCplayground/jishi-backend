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
        <script src="js/global.js"type="text/javascript"></script>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="{{ URL::route('Merchant_main')}}">即食商家端 </a>
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
                                        <li style="border-bottom:1px solid #000000;font-size:16px"><a href="#">菜品查看</a></li>
                                        <li style="font-size:16px"><a href="{{ URL::route('Merchant_menu')}}">新菜品提交</a></li>
                                    </ul>
                                </div>
                                </div>
                            </nav>
                          <!--
              							<div class="module-head">
              								<h3>新菜品提交</h3>
              							</div>
                            -->
                            <div style="margin:20px">
                            <table class="table table-striped" id="dish-table">
                                <thead>
                                <tr>
                                    <th>菜品ID</th>
                                    <th>菜品名称</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <!--
                                <tr>
                                    <td>001</td>
                                    <td>可乐鸡饭</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>手撕鸡饭</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td>鱼香肉丝饭</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>004</td>
                                    <td>还有什么饭呀</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>005</td>
                                    <td>……</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>006</td>
                                    <td>……</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>007</td>
                                    <td>……</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                                <tr>
                                    <td>008</td>
                                    <td>……</td>
                                    <td><button class="btn">修改</button></td>
                                    <td><button class="btn">删除</button></td>
                                </tr>
                            -->
                                </tbody>
                            </table>
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
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="scripts/common.js" type="text/javascript"></script>
        <script>
            var MerchantData=[];
            function IntoJson(){
            return JSON.stringify({ "id":localStorage.getItem("id"),"token":localStorage.getItem("restoken")});
            };
            console.log(IntoJson());
             //显示菜单
            $.ajax({
                async:false,
                url:"/dish_info",  
                processData: false, 
                type:'post',
                dataType:"json",
                data:IntoJson(),
                success:function(data) {
                    MerchantData=data;
                    console.log(MerchantData);
                }
            });
            for(var i=0;i<MerchantData.dishNum;i++){
                var str="<tr><td style=\"display:none\">"+MerchantData.dishes['dish'+i].dishId+"</td><td>"+(i+1)+"</td><td>"+MerchantData.dishes['dish'+i].dishName+"</td><td><button class=\"btn\" onclick=\"altdish(this)\">修改</button></td><td><button class=\"btn\" onclick=\"deldish(this)\">删除</button></td></tr>";
                $("#dish-table tbody").append(str);
            }
            //修改
            function altdish(obj){
                var node=obj.parentNode.parentNode;
                var id=node.cells[0].innerHTML;
                var name=prompt("请输入修改后的名称：");
                $.ajax({
                    async:false,
                    url:"/dish_alter",  
                    processData: false, 
                    type:'post',
                    dataType:"json",
                    data:JSON.stringify({ "id":localStorage.getItem("id"),"token":localStorage.getItem("restoken"),"dishId":id,"name":name}),
                    success:function(data) {
                    alert("修改成功！")
                    console.log(data);
                    location.reload(true);   
                    }
                }); 
            }
            //删除
            function deldish(obj){
                var node=obj.parentNode.parentNode;
                var id=node.cells[0].innerHTML;
                console.log(id);
                $.ajax({
                    async:false,
                    url:"/dish_remove",  
                    processData: false, 
                    type:'post',
                    dataType:"json",
                    data:JSON.stringify({ "id":localStorage.getItem("id"),"token":localStorage.getItem("restoken"),"dishId":id}),
                    success:function(data) {
                    alert("删除成功！")
                    console.log(data);
                    location.reload(true);
                    }
                }); 
            }
        </script>


        </script>

    </body>
