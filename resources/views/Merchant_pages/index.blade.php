<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>登录界面</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/main.css">
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
              <input type="text" name="phonenumber" placeholder="手机号">
            </div>
            <div class="form_text_ipt">
              <input name="password" type="password" placeholder="密码">
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
              <button type="button" onclick="javascript:window.location.href='main.html'">登 录</button>
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
  <script type="text/javascript" src="js/main.js" ></script>
</body>
</html>
