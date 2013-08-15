<!DOCTYPE html>
<html>
	<head>
		<title>Schedule comparisonator</title>
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/login.css">
		<link rel="stylesheet" type="text/css" href="http://205.185.117.12/static/zurb.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://205.185.117.12/static/login.js"></script>
		<script src="http://205.185.117.12/static/zurb.js"></script>
	</head>
	<body>
		<h2>Schedule comparison application</h2>
		<p class="note">This web app compares your schedules with other people at Westwood that
		have published their schedules on here. It is the quickest and easiest way
		to compare schedules with other people.</p>
		<p class="note">All I ask in return is that you do not troll herein. Please make this
		tool as useful as possible for those that want to use it in a serious
		manner.</p>
		<?php if(isset($message)) { ?>
		<p class="note" style="color: green;"><b><?=$message?></b></p>
		<?php } ?>
		<form id="login" action="<?=site_url('admin')?>" method="post">
			<h3>Login</h3>
			<span class="wrap">
				<label for="login-email" class="overlay"><span>Email</span></label>
				<input id="login-email" class="input-text" name="email">
			</span><br>
			<span class="wrap">
				<label for="login-pwd" class="overlay"><span>Password</span></label>
				<input id="login-pwd" type="password" class="input-text" name="password">
			</span><br>
			<input type="submit" value="Login">
		</form>
		<form id="register" action="<?=site_url('admin/register')?>" method="post">
			<h3>Register</h3>
			<span class="wrap">
				<label for="reg-name" class="overlay"><span>Name</span></label>
				<input id="reg-name" class="input-text" name="name">
			</span><br>
			<span class="wrap">
				<label for="reg-email" class="overlay"><span>Email</span></label>
				<input id="reg-email" class="input-text" name="email">
			</span><br>
			<span class="wrap">
				<label for="reg-pwd" class="overlay"><span>Password</span></label>
				<input id="reg-pwd" type="password" class="input-text" name="password">
			</span><br>
			<span class="wrap">
				<label for="reg-confirmpwd" class="overlay"><span>Confirm password</span></label>
				<input id="reg-confirmpwd" type="password" class="input-text" name="confirm">
			</span><br>
			<p class="note">Note: For privacy reasons, <b>do not</b> enter your full
			name. In addition, <b>do not</b> use the same password that you use for
			your email (or any other account you have, for that matter). At the same
			time, choose <a href="http://xkcd.com/936/">a strong password.</a></p>
			<input type="submit" value="Register">
		</form>
	</body>
</html>
