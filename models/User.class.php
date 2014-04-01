<?php
class User {
	
	public $entry;
	
	public $username;
	
	public $email;
	
	public $googleId;
	
	const LOGGED_IN_USER_SESSION_KEY = 'loggedInUserId';
	
	public static function handleLogin() {
		if (!isset($_POST['login'])) {
			return false;
		}
		$result = User::logInByUsername($_POST['username'], $_POST['password']);
		if (!$result === false) {
			return $result;
		}
		header('location: '.$_SERVER['HTTP_REFERER']);
	}
	
	public static function handleRegistration() {
		if (!isset($_POST['register'])) {
			return array();
		}
		return User::register( $_POST['username'], $_POST['password'], $_POST['email'] );
	}
	
	public static function handleGoogleLogin() {
		if (!isset($_REQUEST['googleId'])) {
			return false;
		}
		
		$googleId = $_REQUEST['googleId'];
		if ($user = User::loadByGoogleId($googleId)) {
			User::logInByGoogleId($googleId);
		} else {
			User::registerWithGoogle($googleId, $_REQUEST['googleDisplayName']);
		}
	}
	
	public static function load($id = NULL) {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE entry = '.(int)$id.' LIMIT 1');
		if (count($users) == 0) {
			return NULL;
		}
		return self::loadUserFromData(array_shift($users));
	}
	
	public static function loadByGoogleId($id = NULL) {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE googleId = "'.addslashes($id).'" LIMIT 1');
		if (count($users) == 0) {
			return NULL;
		}
		return self::loadUserFromData(array_shift($users));
	}
	
	private static function loadUserFromData($userData) {
		$user = new User();
		$user->entry 	= (int)$userData['entry'];
		$user->username = $userData['username'];
		$user->email 	= $userData['email'];
		
		return $user;
	}
	
	public static function register($username = '', $password = '', $email = '') {
		$registrationErrorMessages = array();
		
		$existingUsers = Mysql::c()->selectQuery('SELECT entry FROM accounts WHERE username = "'.addslashes($username).'"');
		if (count($existingUsers) != 0) {
			$registrationErrorMessages[] = 'An account with this username already esists.';
		}
		
		if (strlen($password) < 4) {
			$registrationErrorMessages[] = 'Password too short.';
		}
		
		$existingUsers = Mysql::c()->selectQuery('SELECT entry FROM accounts WHERE email = "'.addslashes($email).'"');
		if (count($existingUsers) != 0) {
			$registrationErrorMessages[] = 'An account with this e-mail already exists.';
		}
		
		if (count($registrationErrorMessages) == 0) {
			$userId = Mysql::c()->query('INSERT INTO accounts (username, password, email, registered) VALUES ("'.addslashes($username).'", MD5("'.addslashes($password).'"), "'.addslashes($email).'", NOW())');
			if (!$userId) {
				$registrationErrorMessages[] = 'For some unexplainable reason the creation of a brand new account for you was unsuccessful.';
			}
		}
		
		return $registrationErrorMessages;
	}
	
	public static function registerWithGoogle($googleId = '', $googleDisplayName = '') {
		$userId = Mysql::c()->query('INSERT INTO accounts (username, googleId, registered) VALUES ("'.addslashes($googleDisplayName).'","'.addslashes($googleId).'", NOW())');
		if (!$userId) {
			return false;
		}
		self::logInByGoogleId($googleId);
		return true;
	}
	
	public static function logInByUsername($username = '', $password = '') {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE username = "'.addslashes($username).'" LIMIT 1');
		if (count($users) != 1) {
			return 'No dwarves found from the Wonderland.';
		}
		if ($users[0]['password'] != md5($password)) {
			return 'Oh you naughty goblin!';
		}
		$_SESSION[self::LOGGED_IN_USER_SESSION_KEY] = $users[0]['entry'];
		return false;
	}
	
	public static function logInByGoogleId($googleId = '') {
		$users = Mysql::c()->selectQuery('SELECT * FROM accounts WHERE googleId = "'.addslashes($googleId).'" LIMIT 1');
		if (count($users) != 1) {
			return false;
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