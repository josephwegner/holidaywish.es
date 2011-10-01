<?php

$classBuilder['User'] = new UserModel();

class UserModel {

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

}
?>
