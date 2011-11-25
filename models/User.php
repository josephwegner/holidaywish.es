<?php

$classBuilder['User'] = new UserModel();

class UserModel {

	/*
	 * Purpose: Register a user
	 * 
	 * @param int user's id (because the user is already created
	 * @param string username
	 * @param string password
	 *
	 * @return boolean true=worked
	 * @return string error
	*/
	public function register($id, $user, $pass) {
		if(!is_numeric($id)) return "Error Registering.  Try again later.";

		$user = mysql_escape_string($user);
		$pass = mysql_escape_string($pass);

		$sql = "SELECT `id` FROM users WHERE `username`='".$user."'";
		$check = mysql_query($sql);

		if(mysql_num_rows($check) > 0) return "Username already in use";

		$salt = $this->makeSalt();
		
		$password = $this->encodePassword($user, $pass, $salt);

		$sql = "UPDATE users SET username='".$user."', password='".$password."', salt='".$salt."' WHERE id=".$id;
		mysql_query($sql);
	
		return true;
	}

	/*
	 * Purpose: Attempt to log a user in
	 *
	 * @param string username
	 * @param string password
	 * 
	 * @return boolean false = failed login
	 * @return int user id
	 *
	 * @note FUNCTION MAY RETURN FALSY VALUE.  BE SURE TO CHECK ABSOLUTE FALSE AND NOT (0)
	*/
	public function login($user, $pass) {
		if(isset($_SESSION['user'])) return false; 
		
		$user = mysql_escape_string($user);
		$pass = mysql_escape_string($pass);
		
		$sql = "SELECT `password`, `salt`, `id`, `is_admin` FROM users WHERE `username`='".$user."'";
		$userDat = mysql_query($sql);
	
		if(mysql_num_rows($userDat) != 1) return false;
		
		$data = mysql_fetch_object($userDat);
		
		if($this->encodePassword($user, $pass, $data->salt) == $data->password) {//It worked
			$ret = new StdClass();
			$ret->id = $data->id;
			$ret->admin = $data->is_admin;
			return $ret;
		} else {//Bad Login
			return false;
		}

		
	}
	/*
	 * Purpose: Return the username by the user's ID
	 * 
	 * @param int id of user
	 *
	 * @return bool false=didn't work
	 * @return string username	
	*/
	public function getUsername($id) {
		if(!is_numeric($id)) return false;

		$sql = "SELECT `username` FROM users WHERE `id`=".$id;
		
		$data = mysql_query($sql);
		$arr = mysql_fetch_array($data);
		
		return $arr['username'];
	}

	/*
	 * Purpose: Get a list of all the usernames, except for the specified user
	 *
	 * @param int (opt) The user's id.  Default is the current user
	 *
	 * @return bool false=didn't work
	 * @return array of usernames
	*/
	public function getAllUsernames($id = false) {
		if($id === false) {
			$id = $_SESSION['user'];
		}
	
		if(!is_numeric($id)) return false;

		$sql = "SELECT `username` FROM users WHERE id != ".$id;
		$data = mysql_query($sql);

		$users = array();
		
		while($user = mysql_fetch_object($data)) {
			array_push($users, $user->username);
		}
	
		return $users;
	}

	/*
	* Purpose: Get the secret santa recipient of a certain user.
	*
	* @param int (opt) The user's id.  Default is the current user
	* @param bool (opt) If the secret santa recipient is new.  Only flag this if the recipient has ALREADY BEEN SET.
	*
	* @return bool false=didn't work
	* @return StdClass with user data
	*/	
	public function getSSRecipient($id = false, $newSecretSanta = false) {
		if($id === false) {
			$id = $_SESSION['user'];
		}

		if(!is_numeric($id)) return false;

		$sql = "SELECT secretsanta.recipient, users.username FROM secretsanta, users WHERE secretsanta.santa=".$id." AND users.id=secretsanta.recipient";
		$data = mysql_query($sql);
		
		if(mysql_num_rows($data) != 1) {
			
			if($this->hasSecretSantaRecipient($id)) {
				return false;
			} else {
				$this->setSecretSantaRecipient($id);
				return $this->getSSRecipient($id, true);
			} 
		} else {
			$userData = mysql_fetch_object($data);
			$user = new StdClass();
			$user->id = $userData->recipient;
			$user->username = $userData->username;
			$user->isNew = $newSecretSanta;
			
			return $user;		
		}
		
	}


	/*
	 * Begin Private Functions
	*/

	/*
	 * Purpose: Check if a user has a secret santa recipient chosen
	 *
	 * @param int The user's id
	 *
	 * @return bool false=no Recipient || true=has recipient
	*/
	private function hasSecretSantaRecipient($id) {
		if(!is_numeric($id)) return false;
		$sql = "SELECT `id` FROM secretsanta WHERE `santa`=".$id;
		$check = mysql_query($sql);
		
		return (mysql_num_rows($check) == 1);
	}

	/*
	 * Purpose: Set the SS recipient for the user
	 * 
	 * @param int id = The user's id
	 *
	 * @return bool false=failed true=worked
	*/
	private function setSecretSantaRecipient($id) {
		if(!is_numeric($id)) return false;

		$sql = "SELECT `id` FROM users WHERE group_id=(SELECT group_id FROM users WHERE `id`=".$id.") AND ss_picked=0 AND NOT id=".$id;
		$userData = mysql_query($sql);

		$users =  array();
		while($user = mysql_fetch_object($userData)) {
			array_push($users, $user);
		}	

		$key = array_rand($users);

		$sql = "INSERT INTO secretsanta (`santa`, `recipient`) VALUES (".$id.", ".$users[$key]->id.")";
		mysql_query($sql);

		$sql = "UPDATE users SET ss_picked=1 WHERE id=".$users[$key]->id;
		mysql_query($sql);

		return true;
	}

	/*
	 * Purpose: Encode a password with salt, and user-specific hashing
	 *
	 * @param string username
	 * @param string password
	 * @param string salt
	 *
	 * @return string encoded password
	*/
	private function encodePassword($user, $pass, $salt) {
		$h_user = sha1($user);
		$h_pass = md5($pass);  //Mix in an md5, so if our DB ever gets cracked, it's not painfully obvious how we did hashed things.
		$h_salt = sha1($salt);

		return sha1($h_user.$h_pass.$h_salt);
	}
	
	/*
	 * Purpose: Make some salt
	 *
	 * @param int length of salt.  Default is 8
	 *
	 * @return string salt
	*/
	private function makeSalt($len = 8) {
		if(!is_numeric($len)) $len = 8;

		$chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$string = "";
		for($i=0; $i<$len; $i++) {
				$string .= $chars[mt_rand(0, strlen($chars))];
		}

		return $string;
	}
}
?>
