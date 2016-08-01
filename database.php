<?php
class database{
	protected $dbCon, $dbConds;
	function __construct($host, $port, $user, $pass, $database, $charset = 'utf8mb4'){
		return $this->connect($host, $port, $user, $pass, $database, $charset);
	}
	function connect($host, $port, $user, $pass, $database, $charset = 'utf8mb4'){
		$this->dbCon = @mysqli_connect($host, $user, $pass, $database, $port);
		if(!$this->dbCon || !@mysqli_select_db($this->dbCon, $database)){
			return false;
		}
		mysqli_set_charset($this->dbCon, $charset);
		return true;
	}
	function error(){
		return Array(
			'errno' => @mysqli_errno($this->dbCon),
			'error' => @mysqli_error($this->dbCon),
		);
	}
	function addCond($fields, $fieldsValues,$condSignal = "=", $concat = 'AND', $escape = true){
		if(!is_array($fields)){
			$fields = Array($fields);
		}
		if(!is_array($fieldsValues)){
			$fieldsValues = Array($fieldsValues);
		}
		foreach ($fields as $key => $value) {
			if(!isset($fieldsValues[$key])){break;}
			$this->dbConds[] = Array(
				'table' => $value,
				'tablevalue' => $fieldsValues[$key],
				'signal' => $condSignal,
				'concat' => $concat,
				'escape' => $escape
			);
		}
    }
}
