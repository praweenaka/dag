<?php
 
require_once("config.inc.php");

class DBConnector
{

private $server = '';
private $userName = '';
private $password = '';
private $database = '';

private $con = null;

	// Object construction with database connectivity - Default Constructor
	function __construct()
	{	
		$this->server = DB_SERVER ;
		$this->userName = DB_USER_NAME;
		$this->password = DB_PASSWORD;
		$this->database = DB_DATABSE;
	}

	/*
	 * DBConnector::OpenConnection()
	 * 
	 * Open mysql database connection
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function OpenConnection()
	{
		$this->con = mysql_connect($this->server, $this->userName, $this->password);

		if (!$this->con)
		{
		  die($password . 'Could not connect: ' . mysql_error());
		}
	}
	
	/*
	 * DBConnector::RunQuery()
	 * 
	 * Use to execute select statements
	 *
	 * @param String $SQL : The SQL statement to be executed
	 * 
	 * @access public
	 * 
	 * @return Array
	 */
	public function RunQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();		
		return $result;
	}
	
	/*
	 * DBConnector::ExecuteQuery()
	 * 
	 * Use to execute insert, update and delete statements
	 *
	 * @param String $SQL : The SQL statement to be executed
	 * 
	 * @access public
	 * 
	 * @return boolean
	 */
	public function ExecuteQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		if (mysql_error())	
			$result = false;
		$this->CloseConnection();
		return $result;
	}	
	
	/*
	 * DBConnector::CheckRecordAvailability()
	 * 
	 * Checks whtether records available or not for the given SQL statement
	 *
	 * @param String $SQL : The SQL statement to be executed
	 * 
	 * @access public
	 * 
	 * @return boolean
	 */
	public function CheckRecordAvailability($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();
		if(mysql_num_rows($result) > 0)
			return true;
  		return false;		
	}
	
	/*
	 * DBConnector::AutoIncrementExecuteQuery()
	 * 
	 * Get generated auto increment key/ID, after the execution of given SQL statement
	 *
	 * @param String $SQL : The SQL statement to be executed
	 * 
	 * @access public
	 * 
	 * @return Integer
	 */
	public function AutoIncrementExecuteQuery($SQL)
	{
		$id = -1;
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		echo mysql_error();	
		$id =  mysql_insert_id();
		$this->CloseConnection();
		return $id;
	}
	
	/*
	 * DBConnector::CloseConnection()
	 * 
	 * Close MySQL Connection
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function CloseConnection()
	{
		mysql_close($this->con);		
	}
}

?>
