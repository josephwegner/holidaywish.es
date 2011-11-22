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
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
<script type="text/javascript">
function popupDialog() {
	$("#popupDialog").children("input").val("");

	$("#popupDialog").fadeIn(400);
}
function createGift() {
	$(".errorBar").remove();

	var data = $("#popupDialog").children("input").serialize();

	$.ajax({
		type: "POST",
		url: "ajax/addGift.php",
		data: data,
		success: function(msg) {
			if(msg.indexOf('errorBar') < 0) {
				$("#popupDialog").fadeOut(400);
				$(".giftGrid").html(msg);
			} else {
				$("#popupDialog").prepend(msg);
			}
		}
	});
}
</script>
<title>Wishit Index</title>
</head>
<body>
<center><h1><?php echo $args['username']; ?>'s  Dashboard</h1></center>
<br>
<button onClick="popupDialog();" class="prettyButton addGift">Add Gift</button>
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
<div id="popupDialog">
	<h3>Add a Gift</h3>
	<br>
	<label for="name">Gift</label><br>
	<input type="text" name="name" id="name" placeholder="Gift" /><br>
	<label for="thumbnail">Image URL</label><br>
	<input type="text" name="thumbnail" id="thumbnail" placeholder="Image URL" /><br>
	<label for="description">Description</label><br>
	<input type="text" name="description" id="description" /><br>
	<label for="notes">Notes</label><br>
	<textarea name="notes" name="notes" id="notes"></textarea><br>
	<label for="price">Price</label><br>
	<input type="number" name="price" id="price" /><br>
	<label for="link">Purchase Link</label><br>
	<input type="text" name="link" id="link" /><br><br>
	<button class="prettyButton" onClick="createGift();">Add Gift</button>
</div>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
