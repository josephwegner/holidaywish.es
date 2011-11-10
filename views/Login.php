<?php

$classBuilder['Login'] = new LoginView();

class LoginView {

public function show($args) { 
/* Content Starts Here */
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/css/umbrella.css" />
<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css" />
<title>Wishit Login</title>
</head>
<body>
<center>
	<h1>Wishit Login</h1>
	<form id="loginForm" action="login.php" method="POST">
		<?php if(isset($args['failed']) && $args['failed'] === true) { ?>
		<span class="errorHighlight">Failed Login.  Please try again.</span>
		<?php } ?>		
		<label for="username">Username:</label><br>
		<input type="text" name="username" id="username" placeholder="Username" />
		<br><br>
		<label for="password">Password:</label><br>
		<input type="password" name="password" id="password" placeholder="password" />
		<br><br>
		<input type="submit" class="submitButton" value="Login" />
	</form>
</center>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
