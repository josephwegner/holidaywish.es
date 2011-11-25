<?php


$classBuilder['Login'] = new LoginController();

class LoginController {

	public function index() {
		if(isset($_SESSION['user'])) {
			header("location: index.php");
			die();
		}
		$args = array();		

		if(isset($_POST['username']) && isset($_POST['password'])) {	
			$login;
			
			if($login = GLBL::$models->User->login($_POST['username'], $_POST['password'])) {
				$_SESSION['user'] = $login->id;
				$_SESSION['admin'] = ($login->admin);
				header("Location: index.php");
				die();	
			} else {
				$args['failed'] = true;
			}
		}

		GLBL::$views->Login->show($args);	
	}

	public function register() {
		if(!isset($_GET['reg_code'])) {
			$this->index();
			die();
		}	
		
		$args = array();

		if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
			$sql = "SELECT `id` FROM invitations WHERE user_id=".$_POST['user_id']." AND hash='".mysql_escape_string($_GET['reg_code'])."'";
			$check = mysql_query($sql);

			if(mysql_num_rows($check) == 1) {
				$register = GLBL::$models->User->register($_POST['user_id'], $_POST['username'], $_POST['password']);
				if($register === true) {
					$sql = "DELETE FROM invitations WHERE hash='".mysql_escape_string($_GET['reg_code'])."'";
					mysql_query($sql);

					if($login = GLBL::$models->User->login($_POST['username'], $_POST['password'])) {
						$_SESSION['user'] = $login->id;
						header("Location: index.php");
						die();
					}
				} else {
					$args['reg_error'] = $register;
				}
				
			}
		}

		$code = mysql_escape_string($_GET['reg_code']);

		$sql = "SELECT users.id, users.name FROM users, invitations WHERE users.id=invitations.user_id AND invitations.hash='".$code."'";
		$data = mysql_query($sql);
		
		if(mysql_num_rows($data) != 1) {
			$this->index();
			die();
		}

		$args['user'] = mysql_fetch_object($data);

		GLBL::$views->Register->show($args);
	}
		
}
?>
