<?php


class User {
	
	public $entry;
	
	public $username;
	
	public $email;
	
	const LOGGED_IN_USER_SESSION_KEY = 'loggedInUserId';
	
	public static function load($id = NULL) {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE entry = '.(int)$id.' LIMIT 1');
		if (count($users) == 0) {
			return NULL;
		}
		$userData = array_shift($users);
		
		$user = new User();
		$user->entry 	= (int)$userData['entry'];
		$user->username = $userData['username'];
		$user->email 	= $userData['email'];
		
		return $user;
	}
	
	public static function logInByUsername($username = '', $password = '') {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE username = "'.addslashes($username).'"');
		if (count($users) != 1) {
			return 'No dwarves found from the Wonderland.';
		}
		if ($users[0]['password'] != md5($password)) {
			return 'Oh you naughty goblin!';
		}
		$_SESSION[self::LOGGED_IN_USER_SESSION_KEY] = $users[0]['entry'];
		return true;
	}
	
	public static function getLoggedInUser() {
		if (!isset($_SESSION[self::LOGGED_IN_USER_SESSION_KEY])) {
			return NULL;
		}
		
		return self::load($_SESSION[self::LOGGED_IN_USER_SESSION_KEY]);
	}
	
	public function logout() {
		unset($_SESSION[self::LOGGED_IN_USER_SESSION_KEY]);
	}
	
	
	
}