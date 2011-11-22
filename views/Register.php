<?php

$classBuilder['Register'] = new RegisterView();

class RegisterView {

public function show($args) { 
/* Content Starts Here */
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/css/umbrella.css" />
<title>Wishit Registration</title>
</head>
<body>
<center>
	<h1>Wishit Registration</h1>
	<br>
	<h2>Welcome to Wishit, <?php echo $args['user']->name; ?></h2>
	<br>
	<p style="width: 400px; text-align: justify;">Wishit is a great place to manage all your wish list needs.  We're currently in the very early stages of development, so we only support a few types of wish lists, but we intend to quickly add more.
	<br><br>
	We're going to need just a tiny bit of information from you to get started.</p>
	<form id="registerForm" action="#" method="POST">
		<label for="username">Username</label><br>
		<input type="text" name="username" id="username" placeholder="Username" /><br>
		<label for="password">Password</label><br>
		<input type="password" name="password" id="password" placeholder="Password" /><br><br>
		<input type="submit" value="Register" />
		<input type="hidden" name="user_id" value="<?php echo $args['user']->id; ?>" />
	</form>
</center>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
