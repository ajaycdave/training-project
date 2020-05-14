<?php
require_once __DIR__ .'/DB_Interface.php';

class database implements DB_interface {
	//public $connect;
	private $connect;
	use DatatablTrait;
	public function __construct() {

		$con = mysqli_connect(DB_HOST_NAME, DB_USERNAME, DB_PASSWORD) or die("Unable to Connect to '$dbhost'");
		mysqli_select_db($con, DB_DATABASE_NAME) or die("Could not open the db '$dbname'");

		$this->connect = $con;

	}

	public function selectAll($sql) {
		$toReturn     = array();
		$select_query = mysqli_query($this->connect, $sql);
		$num_rows     = mysqli_num_rows($select_query);

		if ($num_rows > 0) {
			while ($fetch_array = mysqli_fetch_assoc($select_query))
			$toReturn[] = $fetch_array;

		}

		return $toReturn;
	}
	public function selectOne($sql) {
		$toReturn     = array();
		$select_query = mysqli_query($this->connect, $sql);
		$num_rows     = mysqli_num_rows($select_query);
		if ($num_rows > 0) {
			$toReturn = mysqli_fetch_assoc($select_query);

		}
		return $toReturn;
	}
	public function execute($sql) {

		return $query_execute = mysqli_query($this->connect, $sql);

	}
	public function insert_id() {
		return mysqli_insert_id($this->connect);
	}

}
