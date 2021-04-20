<?php

class Database{
	
	private $host;
	private $user;
	private $password;
	private $database;
	private $connection;
	private $transaction;
	private $numrows;
	
	public function __construct(){
 		$this->host = HOST_SPEC;
		$this->user = USER;
		$this->password = PWD;
		$this->database = DB;
		$this->connect();
		$this->transaction = false;
		
	}

	private  function connect(){
		$this->connection = @mysql_connect($this->host, $this->user, $this->password);
		if( !$this->connection ) {
			throw new Exception(mysql_error(), 10);
		}
		@mysql_select_db($this->database, $this->connection);
		return $this->connection;
	}

	public function execute($query){
		$result = @mysql_query($query, $this->connection);
		if (!$result) {
			if ($this->transaction) {
				@mysql_query("ROLLBACK", $this->connection);
			}
			throw new Exception("Query error! % ".$query, 5);
		}
		
		$this->numrows = @mysql_num_rows($result);
		return $result;
	}
	
	public function numRows(){
		return $this->numrows;
	}
	
	public function startTransaction(){
		$this->execute("BEGIN");
		$this->transaction = true;
	}
	public function rollbackTransaction(){
		$this->execute("ROLLBACK");
		$this->transaction = false;
	}
	public function commitTransaction(){
		$this->execute("COMMIT");
		$this->transaction = false;
	}
	
	public function getLastId() {
  		$id = mysql_insert_id($this->connection);
		return intval($id);
	}

	public function close(){
		@mysql_close($this->connection);
	}
}

?>