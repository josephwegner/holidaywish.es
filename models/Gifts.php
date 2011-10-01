<?php

$classBuilder['Gifts'] = new GiftsModel();

class GiftsModel {

	/*
	 * Purpose: Get all the details for a user's gifts
	 *
	 * @param int user's id
	 *
	 * @return bool false=didn't work
	 * @return array of gift object literals
	*/
	public function getMyGiftDetails($id) {
		if(!is_numeric($id)) return false;

		$sql = "SELECT gifts.name, gifts.thumbnail, gifts.description, gifts.notes, gifts.price, gifts.link, gifts.purchased, gifts.go_in_on, users.username".
			" FROM gifts, users".
			" WHERE gifts.user_id = users.id AND gifts.deleted = 0 AND gifts.user_id=".$id;

		$data = mysql_query($sql);

		$allGifts = array();

		while($gift = mysql_fetch_object($data)) {
			array_push($allGifts, $gift);
		}

		return $allGifts;
	}

}

?>
