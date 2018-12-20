<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>登录界面</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/global.js"type="text/javascript"></script>
  <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
</head>
<body>
  <div class="wrap login_wrap">
    <div class="content">
      <div class="logo">即食App</div>
      <div class="login_box">

        <div class="login_form">
          <div class="login_title">
            商家登录
          </div>

          <form  action="#" method="post">
            {{ csrf_field() }}
            <div class="form_text_ipt">
              <input type="text" name="phonenumber" placeholder="手机号" id="phone">
            </div>
            <div class="form_text_ipt">
              <input name="password" type="password" placeholder="密码" id="pas">
            </div>

            <div class="form_check_ipt">
              <div class="left check_left">
                <label><input name="" type="checkbox"> 下次自动登录</label>
              </div>

              <div class="right check_right">
                <a href="{{ URL::route('Merchant_forget')}}">忘记密码</a>
              </div>
            </div>

            <div class="form_btn">
              <button type="button" onclick="login()">登 录</button>
            </div>
            <div class="form_reg_btn">
              <span>还没有帐号？</span><a href="{{ URL::route('Merchant_register')}}">马上注册</a>
            </div>

          </form>

        </div>
      </div>
      <div class="footer">
        <p> &copy; 2018  爸爸饿了战队</p>
      </div>

    </div>

  </div>
  <script>
    function login(){
      var phone=document.getElementById("phone").value;
      var pas=document.getElementById("pas").value;
      function IntoJson(){
        return JSON.stringify({ "id":phone,"passwd":pas});
        };
        
      $.ajax({
          async:false,
          url:"/Merchant_login",  
          processData: false, 
          type:'post',
          dataType:"json",
          data:IntoJson(),
          success:function(data) {
              restaurantId=data.id;
              token=data.token;
              restaurantName=data.name;
              localStorage.setItem("id",data.id);
              localStorage.setItem("restoken",data.token);
              localStorage.setItem("name",data.name);
              console.log(data.token);
              console.log(localStorage.getItem("restoken"));
              window.location.href="/Merchant_main"; 
          },
          error:function(data){
            alert("输入错误！请重新输入");
          }
        });
    }
  </script>
</body>
</html>
