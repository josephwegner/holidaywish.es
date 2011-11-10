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
			"ssGifts" => $secretSanta->gifts,
			"ssIsNew" => $secretSanta->user->isNew
		);
	
		GLBL::$views->Index->show($sendView);
	}
		
}
?>
