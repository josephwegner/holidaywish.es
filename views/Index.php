<?php

$classBuilder['Index'] = new IndexView();

class IndexView {

public function show($args) {
/* Content Starts Here */
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css" />
<title>Wishit Index</title>
</head>
<body>
<center><h1><?php echo $args['username']; ?>'s  Dashboard</h1></center>
<br>
<hr>
<div class="giftGrid">
<?php for($i=0, $max=sizeof($args['gifts']); $i < $max; $i++) { ?>
	<div class="giftToken"><?php echo $args['gifts'][$i]->name; ?></div>
<?php } ?>
</div>
<div class="userGrid">
<?php for($i=0, $max=sizeof($args['users']); $i < $max; $i++) { ?>
	<div class="userToken"><?php echo $args['users'][$i]; ?></div>
<?php } ?>
</div>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
