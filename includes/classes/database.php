<?php 

class Database
{
	public $connection;
	public $db;


	public function __construct()
	{
		$this->db = $this->openDbConnection();
		$this->query("SET NAMES utf8");
	}


	public function openDbConnection()
	{
		$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if($this->connection->connect_errno)
		{
			die("Database connection failed " . $this->connection->connect_error);
		}
		return $this->connection;
	}


	public function query($sql)
	{
		$result = $this->db->query($sql);
		$this->confirmQuery($result);
		return $result;
	}


	private function confirmQuery($result)
	{
		if(!$result)
		{
			die("Query failed " . $this->db->error);
		}
	}


	public function escapeString($string)
	{
		return $this->db->real_escape_string($string);
	}


	public function insertId()
	{
		return mysqli_insert_id($this->db);
	}
}//END Database
