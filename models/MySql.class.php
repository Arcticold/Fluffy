<?php
class MySql {
	
	private $connection;
	
	private static $instance;
	
	
	
	public static function c() {
		if (self::$instance == NULL) {
			self::$instance = new MySql();
		}
		return self::$instance;
	}
	
	public function connect($host, $username, $password, $database) {
		$this->connection = mysqli_connect($host, $username, $password, $database);
		return $this;
	}
	
	public function query($query) {
		mysqli_query($this->connection, $query);
	}
	
	public function selectQuery($query) {
		$rawResult = mysqli_query($this->connection, $query);
		$result = array();
		while ($row = mysqli_fetch_array($rawResult)) {
			$result[] = $row;
		}
		return $result;
	}
	
	public function close() {
		mysqli_close($this->connection);
	}
	
}