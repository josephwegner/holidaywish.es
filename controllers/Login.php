<?php


$classBuilder['Login'] = new LoginController();

class LoginController {

	static public function index() {
		if(isset($_SESSION['user'])) {
			header("location: index.php");
			die();
		}
		$args = array();		

		if(isset($_POST['username']) && isset($_POST['password'])) {	
			$login;
			
			if($login = GLBL::$models->User->login($_POST['username'], $_POST['password'])) {
				$_SESSION['user'] = $login;
				header("Location: index.php");
				die();	
			} else {
				$args['failed'] = true;
			}
		}

		GLBL::$views->Login->show($args);	
	}
		
}
?>
