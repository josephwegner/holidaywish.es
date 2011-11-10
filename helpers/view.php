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
                        <img class="gridThumbnail" src="<?php echo $gift->thumbnail; ?>" />
                </div>
                <div class="gridRight">
                        <span class="gridTitle"><?php echo $gift->name; ?></span><br>
                        <span class="gridDesc"><?php echo $gift->description; ?></span><br>
                        Buy it on <img class="amazonLogo" src="http://library.corporate-ir.net/library/17/176/176060/mediaitems/93/a.com_logo_RGB.jpg" /> for <span class="price">$<?php echo $gift->price; ?></span>
                </div>
                <div class="clear"></div>
        </div>
	<?
	}	

}
?>
