<?php

$classBuilder['Index'] = new IndexView();

class IndexView {

public function show($args) { 
/* Content Starts Here */
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/css/umbrella.css" />
<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css" />
<title>Wishit Index</title>
</head>
<body>
<center><h1><?php echo $args['username']; ?>'s  Dashboard</h1></center>
<br>
<hr>
<div class="giftGrid">
	<h2>Your Wishlist</h2>
<?php for($i=0, $max=sizeof($args['gifts']); $i < $max; $i++) { 
	GLBL::$helpers->View->giftToken($args['gifts'][$i]);		
} ?>
</div>
<div class="userGrid">
	<h2><?php echo $args['ssUsername'];?>'s Wishlist</h2>
<?php for($i=0, $max=sizeof($args['ssGifts']); $i < $max; $i++) {
	GLBL::$helpers->View->giftToken($args['ssGifts'][$i]);
} ?>
</div>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
