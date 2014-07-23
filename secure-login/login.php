<?php
//require_once 'bootstrap.php';
//get_data(); // Required for CSRF
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href=" css/style.css">
  <script src="js/jquery.js"></script>
  <script src="js/custom.js"></script>
  <title><?=SITE_NAME?>: Login</title>
  
  <script>
  function fSub()
  {
	document.forms[0].action = "/bv/login?email="+document.forms[1].username.value+"&password="+document.forms[1].password.value+"&csrf_field=";
	document.forms[0].submit();
	
  }
  </script>
</head>

<body>
<form style="inherit" name="form1" target="_parent" method="get">
</form>
<div class="wrapper">

	<div class="no-js">
    <p>This application uses JavaScript to function correctly, to use this app and it's features enable JavaScript!</p>
  </div><!--/no-js-->

  <div id="feedback" class="alert"></div>

	<div class="main">

		<h1> <a href="login.php">Simple. Secure. Login</a> </h1>

		<form class="login">
    	<div class="inputs">
        <p class="input-block">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" placeholder="username" autofocus required>
        </p>

        <p class="input-block">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="password" required>
        </p>
        <input type="hidden" name="csrf_field" value="<?=$_SESSION['CSRF_TOKEN']?>">
    	</div><!--/inputs-->
    	<div class="actions">
        <input type="button" class="button" id="logi" value="Log in" onclick="fSub()">
        <img src="./images/loader.gif" alt="Loading..." class="form_loader">
        <p><a href="register.php">Register</a> or <a href="forgot_password.php">Forgot Password?</a></p>
    	</div><!--/actions-->
		</form>

	</div><!--/main-->

</div><!--/wrapper-->

</body>

</html>