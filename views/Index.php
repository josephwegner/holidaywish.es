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
$(document).ready(function() {
	setHooks();
});
function setHooks() {
	$("#myGifts").children("div.giftToken").hover(function() {
		$(this).css('background-color', '#566669');
	}, function() {
		$(this).css('background-color', '#00010D');
	});

	$("#myGifts").children("div.giftToken").click(function() { editPopup($(this).attr('id')); });
	$("#addGiftDialog").find("button.prettyButton").click(createGift);
}
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
				setHooks();
			} else {
				$("#addGiftDialog").prepend(msg);
			}
		}
	});
}
function updateGift() {
	$(".errorBar").remove();

	var data = $("#addGiftDialog").children("input").serialize();

	$.ajax({
		type: "POST",
		url: "ajax/updateGift.php",
		data: data,
		success: function(msg) {
			if(msg.indexOf('errorBar') < 0) {
				$("#addGiftDialog").fadeOut(400);
				$(".giftGrid").html(msg);

				$("#addGiftDialog").find("button.delete").remove();
				$("#addGiftDialog").find("button.prettyButton").unbind('click').text("Add Gift").click(createGift);

				setHooks();
			} else {
				$("#addGiftDialog").prepend(msg);
			}
		}
	});
}
function editPopup(id) {
	if($("#addGiftDialog").find("button.delete").length > 0) {
		$("#addGiftDialog").find("button.delete").remove();
		$("#addGiftDialog").find("button.prettyButton").unbind('click');
	}

	var giftHold  = $("#" + id);

	var imgSrc = $(giftHold).find('.gridThumbnail').attr('src');
	var title = $(giftHold).find('.gridTitle').text();
	var desc = $(giftHold).find('.gridDesc').text();
	var link = $(giftHold).find('a').attr('href');
	var price = $(giftHold).find('.price').text().replace('$', '');
	
	popupDialog("addGiftDialog");

	$("input#name").val(title);
	$("input#thumbnail").val(imgSrc);
	$("input#description").val(desc);
	$("input#price").val(price);
	$("input#link").val(link);
	$("#id").val(id.replace("gift", ""));

	$("#addGiftDialog").find("button.prettyButton").text("Update Gift").unbind("click").click(updateGift).before(
		"<button class='prettyButton delete' onClick='delGift(\"" + id + "\");'>Delete Gift</button>");
	
}
function delGift(id) {
	id = id.replace("gift", "");

	$.ajax({
		type: "POST",
		url: "ajax/delGift.php",
		data: "id=" + id,
		success: function(msg) {
			$("#gift" + id).remove();

			$("#addGiftDialog").find("button.delete").remove();
			$("#addGiftDialog").find("button.prettyButton").unbind('click').text("Add Gift").click(createGift);
		
			$("#addGiftDialog").fadeOut(400);
		}	
	});
}
</script>
<title>HolidayWish.es Index</title>
</head
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
		<button onClick="window.location = 'logout.php';"class="prettyButton">Logout</button>
	</div>
</div>
<hr>
<div id="myGifts" class="giftGrid">
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
	<label for="price">Price</label><br>
	<input type="number" name="price" id="price" /><br>
	<label for="link">Purchase Link</label><br>
	<input type="text" name="link" id="link" /><br><br>
	<input type="hidden" name="id" id="id" />
	<button class="prettyButton">Add Gift</button>
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
