<?php

$classBuilder['View'] = new ViewHelper();

class ViewHelper {

	/*
	 * Purpose: Echo out a frontend giftToken
	 *
	 * @param object gift = A gift object
	*/
	public function giftToken($gift) {
		?>
		<div id="gift<?php echo $gift->id; ?>" class="giftToken">
                	<div class="thumbnailHolder gridLeft">
                        <?php if(!empty($gift->thumbnail)) {?><img class="gridThumbnail" src="<?php echo $gift->thumbnail; ?>" /><?php } ?>
                	</div>
			<div class="gridRight">
				<span class="gridTitle"><?php echo $gift->name; ?></span><br>
				<span class="gridDesc"><?php echo $gift->description; ?></span><br>
				Buy it <?php if(!empty($gift->link)) { ?><a href="<?php echo $gift->link; ?>">online</a> <?php } ?>for <span class="price">$<?php echo $gift->price; ?></span>
			</div>
			<div class="clear"></div>
        	</div>
	<?
	}

	/*
	 * Purpose: Echo out a standard header for all pages
	*/
	public function header() {
		?>
		<script type="text/javascript">
		  var uvOptions = {};
		  (function() {
		    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
		    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/J3RVwRlrmRQLdoRJn4yCQ.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
		  })();
		</script>
		<?php
	}	

}
?>
