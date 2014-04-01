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
		return (int)mysqli_insert_id($this->connection);
	}
	
	public function selectQuery($query) {
		$rawResult = mysqli_query($this->connection, $query);
		$result = array();
		if (is_bool($rawResult)) {
			return $result;
		}
		while ($row = mysqli_fetch_array($rawResult)) {
			$result[] = $row;
		}
		return $result;
	}
	
	public function close() {
		mysqli_close($this->connection);
	}
	
}