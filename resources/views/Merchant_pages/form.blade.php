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
        <script src="scripts/common.js" type="text/javascript"></script>
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



                            <!--/#btn-controls-->
                            <div class="module">
                                <div class="module-head">
                                    <h3>
                                        被推荐菜品排行</h3>
                                </div>
                                <div class="module-body">
                                  <div class="chart pie donut">
                                    <div id="main" style="width: 800px;height:300px;"></div>
                                        <script type="text/javascript">
                                        var canteen=[];
                                        $.ajax({  
                                        async:false,
                                        url:"/dishRank",  
                                        processData: false, 
                                        type:'get',
                                        success:function(data) {  
                                            canteen=data;
                                        }
                                    }); 
                                            // 基于准备好的dom，初始化echarts实例
                                            var myChart = echarts.init(document.getElementById('main'));

                                            // 指定图表的配置项和数据
                                            var option = {
                                                title: {

                                                },
                                                tooltip: {
                                                    trigger: 'axis',
                                                    axisPointer: {
                                                        type: 'shadow'
                                                    }
                                                },
                                                legend: {
                                                    data: ['被推荐次数']
                                                },
                                                toolbox: {
                                                    show : true,
                                                    feature : {
                                                        mark : {show: true},
                                                        dataView : {show: true, readOnly: false},

                                                        restore : {show: true},
                                                        saveAsImage : {show: true}
                                                    }
                                                },
                                                grid: {
                                                    left: '3%',
                                                    right: '4%',
                                                    bottom: '3%',
                                                    containLabel: true
                                                },
                                                xAxis: {
                                                    type: 'value',
                                                    boundaryGap: [0, 0.01]
                                                },
                                                yAxis: {
                                                    type: 'category',
                                                    //data: [canteen[4].restName+":"+canteen[4].dishName,canteen[3].restName+":"+canteen[3].dishName,canteen[2].restName+":"+canteen[2].dishName,canteen[1].restName+":"+canteen[1].dishName,canteen[0].restName+":"+canteen[0].dishName]
                                                    data:['预留','预留','预留',canteen[1].restName+":"+canteen[1].dishName,canteen[0].restName+":"+canteen[0].dishName]
                                                },
                                                series: [
                                                    {
                                                        name: '被推荐次数',
                                                        type: 'bar',
                                                        //data: [canteen[4].count, canteen[3].count, canteen[2].count, canteen[1].count, canteen[0].count]
                                                        data:[0,0,0,canteen[1].count, canteen[0].count]
                                                    }

                                                ]
                                            };


	                                             myChart.setOption(option)


                                        </script>
                                  </div>
                                </div>
                            </div>


                            <div class="module">
                                <div class="module-head">
                                    <h3>
                                        本店被推荐菜品次数</h3>
                                </div>
                                <div class="module-body">
                                  <div class="chart pie donut">
                                    <div id="main2" style="width: 800px;height:300px;"></div>
                                        <script type="text/javascript">
                                            // 基于准备好的dom，初始化echarts实例
                                            var myChart = echarts.init(document.getElementById('main2'));

                                            // 指定图表的配置项和数据
                                            var option = {
                                                  title : {
                                                      text: '本店被推荐菜品次数统计',
                                                      subtext: '',
                                                      x:'center'
                                                  },
                                                  tooltip : {
                                                      trigger: 'item',
                                                      formatter: "{a} <br/>{b} : {c} ({d}%)"
                                                  },
                                                  legend: {
                                                      orient : 'vertical',
                                                      x : 'left',
                                                      data:['1','2','3','4','5']
                                                  },
                                                  toolbox: {
                                                      show : true,
                                                      feature : {
                                                          mark : {show: true},
                                                          dataView : {show: true, readOnly: false},
                                                          magicType : {
                                                              show: true,
                                                              type: ['pie', 'funnel'],
                                                              option: {
                                                                  funnel: {
                                                                      x: '25%',
                                                                      width: '50%',
                                                                      funnelAlign: 'left',
                                                                      max: 1548
                                                                  }
                                                              }
                                                          },
                                                          restore : {show: true},
                                                          saveAsImage : {show: true}
                                                      }
                                                  },
                                                  calculable : true,
                                                  series : [
                                                      {
                                                          name:'次数',
                                                          type:'pie',
                                                          radius : '55%',
                                                          center: ['50%', '60%'],
                                                          data:[
                                                              {value:335, name:'1'},
                                                              {value:310, name:'2'},
                                                              {value:234, name:'3'},
                                                              {value:135, name:'4'},
                                                              {value:1548, name:'5'}
                                                          ]
                                                      }
                                                  ]
                                              };



	                                             myChart.setOption(option)


                                        </script>
                                  </div>
                                </div>
                            </div>


                            <div class="module">
                                <div class="module-head">
                                    <h3>
                                        各个问题用户回答情况</h3>
                                </div>
                                <div class="module-body">
                                  <div class="chart pie donut">
                                    <div id="main3" style="width: 800px;height:300px;"></div>
                                        <script type="text/javascript">
                                            // 基于准备好的dom，初始化echarts实例
                                            var myChart = echarts.init(document.getElementById('main3'));

                                            // 指定图表的配置项和数据
                                            var option = {
                                                tooltip : {
                                                    trigger: 'axis',
                                                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                                                    }
                                                },
                                                toolbox: {
                                                    show : true,
                                                    feature : {
                                                        mark : {show: true},
                                                        dataView : {show: true, readOnly: false},

                                                        restore : {show: true},
                                                        saveAsImage : {show: true}
                                                    }
                                                },
                                                legend: {
                                                    data:['否', '是']
                                                },
                                                grid: {
                                                    left: '3%',
                                                    right: '4%',
                                                    bottom: '3%',
                                                    containLabel: true
                                                },
                                                xAxis : [
                                                    {
                                                        type : 'value'
                                                    }
                                                ],
                                                yAxis : [
                                                    {
                                                        type : 'category',
                                                        axisTick : {show: false},
                                                        data : ['不如这顿来点面条？','问题二不如这顿来点面条？','问题三问题二不如这顿来点面条','问题四','问题五']
                                                    }
                                                ],
                                                series : [

                                                    {
                                                        name:'是',
                                                        type:'bar',
                                                        stack: '总量',
                                                        label: {
                                                            normal: {
                                                                show: true
                                                            }
                                                        },
                                                        data:[120, 102, 141, 174, 150]
                                                    },
                                                    {
                                                        name:'否',
                                                        type:'bar',
                                                        stack: '总量',
                                                        label: {
                                                            normal: {
                                                                show: true,

                                                            }
                                                        },
                                                        data:[-120, -132, -101, -134, -130]
                                                    }
                                                ]
                                            };


                                               myChart.setOption(option)


                                        </script>
                                  </div>
                                </div>
                            </div>


                            <div class="module">
                                <div class="module-head">

                                    <h3>
                                        店铺排行榜</h3>
                                </div>
                                <div class="module-body">

                                    <div class="row clearfix" >

                                		<div class="col-md-12 column" style="padding-left:50px;font-size:20px;margin:25px;">
                                			<ol >
                                				<li style="margin-bottom:10px">
                                					小米米
                                				</li>
                                				<li style="margin-bottom:10px">
                                					瓦罐世家
                                				</li>
                                				<li style="margin-bottom:10px">
                                					莆田卤面
                                				</li>
                                				<li style="margin-bottom:10px">
                                					麻辣香锅
                                				</li>
                                				<li style="margin-bottom:10px">
                                					5
                                				</li>
                                				<li style="margin-bottom:10px">
                                			   	6
                                				</li>
                                				<li style="margin-bottom:10px">
                                					7
                                				</li>
                                				<li style="margin-bottom:10px">
                                					8
                                				</li>
                                			</ol>
                                		</div>
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
                <p class="copyright">&copy; 爸爸饿了战队 </p>
            </div>
        </div>



        </script>

    </body>
