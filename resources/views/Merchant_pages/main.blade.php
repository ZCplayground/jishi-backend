<!DOCTYPE html>
<html>
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商家主页</title>

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
                    <script>
                            var MerchantData=[];
                            function IntoJson(){
                            return JSON.stringify({ "restId":1 });
                            };
                            console.log(IntoJson());
                            $.ajax({
                            async:false,
                            url:"/?",  
                            processData: false, 
                            type:'post',
                            dataType:"json",
                            data:IntoJson(),
                            success:function(data) {
                        }
                        });
                    </script>
                    
                    <div class="span9">
                        <div class="content">
                          <div class="module">
                    				<div class="jieshao" style="padding:30px;">

                              <h3><img src="images/user.png" class="nav-avatar"  /> 您好！小米米老板</h3>
                    				<p>
                    					店铺老板 | 福州大学玫瑰园餐厅二楼 | 即食App VIP商铺
                    				</p>
                            </div>
                    			</div>
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class=" icon-user"></i><b>22，333</b>
                                        <p class="text-muted">
                                            历史食客</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-user"></i><b>96</b>
                                        <p class="text-muted">
                                            今日食客</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-money"></i><b>8/50</b>
                                        <p class="text-muted">
                                            福大食堂店铺排名</p>
                                    </a>
                                </div>
                                <div class="btn-box-row row-fluid">




                                </div>
                            </div>

                            <!--/#btn-controls-->
                            <div class="module">
                                <div class="module-head">
                                    <h3>
                                        店铺五芒星</h3>
                                </div>
                                <div class="module-body">
                                  <div class="chart pie donut">
                                    <div id="main" style="width: 900px;height:600px;"></div>
                                        <script type="text/javascript">
                                            // 基于准备好的dom，初始化echarts实例
                                            var myChart = echarts.init(document.getElementById('main'));

                                            // 指定图表的配置项和数据
                                            var option = {
                                              title: {

                                                 },
                                                 tooltip: {},
                                                 legend: {
                                                     data: ['早餐','午餐','晚餐']
                                                 },
                                                 radar: {
                                                     // shape: 'circle',
                                                     name: {
                                                         textStyle: {
                                                             color: '#fff',
                                                             backgroundColor: '#999',
                                                             borderRadius: 3,
                                                             padding: [3, 5]
                                                        }
                                                     },
                                                     indicator: [
                                                        { name: '口碑', max: 6500},
                                                        { name: '销售额', max: 16000},
                                                        { name: '上菜速度', max: 30000},
                                                        { name: '服务态度', max: 38000},
                                                        { name: '价格', max: 52000},

                                                     ]
                                                 },
                                                 series: [{
                                                     name: '',
                                                     type: 'radar',
                                                     // areaStyle: {normal: {}},
                                                     data : [
                                                         {
                                                             value : [4300, 10000, 28000, 35000, 50000, 19000],
                                                             name : '早餐'
                                                         },
                                                          {
                                                             value : [5000, 14000, 24000, 31000, 42000, 21000],
                                                             name : '午餐'
                                                         },
                                                          {
                                                             value : [4000, 12000, 28000, 32000, 45000, 20000],
                                                             name : '晚餐'
                                                         }
                                                     ]
                                                 }]
                                            };

	                                             myChart.setOption(option)


                                        </script>
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
            <div class="container">
                <p class="copyright" >&copy; 爸爸饿了战队 </p>
            </div>
        </div>




        </script>

    </body>
