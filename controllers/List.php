<?php


$classBuilder['List'] = new ListController();

class ListController {

	static public function index() {
		$username = GLBL::$models->User->getUsername($_SESSION['user']);

		$myGifts = GLBL::$models->Gifts->getGiftDetails($_SESSION['user']);
		
		$secretSanta = new StdClass();
		$secretSanta->user =  GLBL::$models->User->getSSRecipient($_SESSION['user']);
		$secretSanta->gifts = GLBL::$models->Gifts->getGiftDetails($secretSanta->user->id);	
		
		$sendView = array(
			"username" => $username,
			"gifts" => $myGifts,
			"ssUsername" => $secretSanta->user->username,
			"ssName" => $secretSanta->user->name,
			"ssGifts" => $secretSanta->gifts,
			"ssIsNew" => $secretSanta->user->isNew
		);
	
		GLBL::$views->Index->show($sendView);
	}

	public function addGift() {
		$inserted = GLBL::$models->Gifts->addGift($_SESSION['user'], $_POST['name'], $_POST['thumbnail'], $_POST['description'],
								$_POST['price'], $_POST['link']);

		if($inserted === true) {
			$gifts = GLBL::$models->Gifts->getGiftDetails($_SESSION['user']);
			
			for($i=0; $i < sizeof($gifts); $i++) {
				GLBL::$helpers->View->giftToken($gifts[$i]);
			}
		} else {
			echo "<div class='errorBar'>".$inserted."</div>";
		}

	}
	public function updateGift() {
		$inserted = GLBL::$models->Gifts->updateGift($_SESSION['user'], $_POST['id'], $_POST['name'], $_POST['thumbnail'], $_POST['description'],
								$_POST['price'], $_POST['link']);

		if($inserted === true) {
			$gifts = GLBL::$models->Gifts->getGiftDetails($_SESSION['user']);
			
			for($i=0; $i < sizeof($gifts); $i++) {
				GLBL::$helpers->View->giftToken($gifts[$i]);
			}
		} else {
			echo "<div class='errorBar'>".$inserted."</div>";
		}

	}
	public function deleteGift() {
		echo GLBL::$models->Gifts->deleteGift($_SESSION['user']);
	}
		
}
?>
