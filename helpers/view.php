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
		<div class="giftToken">
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

}
?>
