<?php

$classBuilder['Index'] = new IndexView();

class IndexView {

public function show($args) { 
/* Content Starts Here */
?>
<html>
<head>
<?php GLBL::$helpers->View->header(); ?>
<link rel="stylesheet" type="text/css" href="assets/css/umbrella.css" />
<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
<script type="text/javascript">
function popupDialog(id) {
	$("#" + id).children("input").val("");

	$("#" + id).fadeIn(400);
}
function createGift() {
	$(".errorBar").remove();

	var data = $("#addGiftDialog").children("input").serialize();

	$.ajax({
		type: "POST",
		url: "ajax/addGift.php",
		data: data,
		success: function(msg) {
			if(msg.indexOf('errorBar') < 0) {
				$("#addGiftDialog").fadeOut(400);
				$(".giftGrid").html(msg);
			} else {
				$("#addGiftDialog").prepend(msg);
			}
		}
	});
}
</script>
<title>HolidayWish.es Index</title>
</head>
<body>
<center><h1><?php echo $args['username']; ?>'s  Dashboard</h1></center>
<br>
<div class="headButtons">
	<div class='fleft tleft'>
		<button onClick="popupDialog('addGiftDialog');" class="prettyButton addGift">Add Gift</button>
	</div>
	<div class='tright'>
	<?php if(isset($_SESSION['admin']) && $_SESSION['admin']) { ?>
		<button onClick="popupDialog('addUserDialog');" class="prettyButton addUser">Add User</button>
		<button onClick="popupDialog('manageRelationshipsDialog');" class="prettyButton relationships">Relationships</button>
		<button onClick="popupDialog('sendInvitesDialog');" class="prettyButton sendInvites">Send Invites</button>
	<?php } ?>
		<button onclick="window.location = 'logout.php';"class="prettyButton">Logout</button>
	</div>
</div>
<hr>
<div class="giftGrid">
	<h2>Your Wishlist</h2>
<?php for($i=0, $max=sizeof($args['gifts']); $i < $max; $i++) { 
	GLBL::$helpers->View->giftToken($args['gifts'][$i]);		
} ?>
</div>
<div class="userGrid">
	<h2><?php echo $args['ssName'];?>'s Wishlist</h2>
<?php for($i=0, $max=sizeof($args['ssGifts']); $i < $max; $i++) {
	GLBL::$helpers->View->giftToken($args['ssGifts'][$i]);
} ?>
</div>
<div id="addGiftDialog" class="popupDialog">
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
<div id="addUserDialog" class="popupDialog">

</div>
<?php if(isset($_SESSION['admin']) && $_SESSION['admin']) { ?>

<div id="manageRelationships" class="popupDialog">

</div>
<div id="sendInvitesDialog" class="popupDialog">

</div>
<?php } ?>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>
