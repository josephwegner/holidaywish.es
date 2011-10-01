<?php


$classBuilder['List'] = new ListController();

class ListController {

	public function index() {
		$username = GLBL::$models->User->getUsername($_SESSION['user']);

		$myGifts = GLBL::$models->Gifts->getMyGiftDetails($_SESSION['user']);
		$users = GLBL::$models->User->getAllUsernames();
		
		$sendView = array(
			"username" => $username,
			"gifts" => $myGifts,
			"users" => $users
		);
	
		GLBL::$views->Index->show($sendView);
	}
		
}
?>
