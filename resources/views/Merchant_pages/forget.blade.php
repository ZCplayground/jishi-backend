<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<title>重置密码界面</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/main.css" />
</head>
<body>
	<div class="wrap login_wrap">
		<div class="content">
			<div class="logo">即食App</div>
				<div class="login_box">

					<div class="login_form">
						<div class="login_title">
							重置密码
						</div>
						<form action="#" method="post">

							<div class="form_text_ipt">
								<input name="phonenumber" type="text" placeholder="手机号">
							</div>

              <div class="form_text_ipt_2">
								<input name="code" type="text" placeholder="验证码">
                <button type="button" onclick="#">获取验证码</button>
							</div>

							<div class="form_text_ipt">
								<input name="password" type="password" placeholder="请输入新密码">
							</div>

							<div class="form_text_ipt">
								<input name="repassword" type="password" placeholder="重复密码">
							</div>


							<div class="form_btn">
								<button type="button" onclick="javascript:window.location.href='#'">重置密码</button>
							</div>
							<div class="form_reg_btn">
								<span>想起密码？</span><a href="{{ URL::route('Merchant_index')}}">马上登录</a>
							</div>

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
