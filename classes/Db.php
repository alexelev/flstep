<?php
class Db {
	static public function connect ($host, $login, $password, $database){
		if(mysql_connect($host, $login, $password) != false){
			echo ('connection is open!');
		}
		//mysql_connect($host, $login, $password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
	}

	static public function query($query){
		return mysql_query($query);
	}

	static public function getValue($query){
		$result = mysql_query($query);
		return current(mysql_fetch_array($result));
	}

	static public function getRow($query){
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}

	static public function getTable($query, $index = null){
		$result = mysql_query($query);
		$array = array();
		while($row = mysql_fetch_assoc($result)){
			if($index){
				$array[$row[$index]] = $row;
			}else{ $array[] = $row; }
		}
		return $array;
	}

	static public function getInsertId(){
		return mysql_insert_id();
	}
}

class DbFieldType {
    const INT = 1;
    const FLOAT = 2;
    const VARCHAR = 3;
    const TEXT = 4;
    const DATE = 5;
    const TIME = 6;
    const DATETIME = 7;
}

class DbLinkType {
    const PRIMARY_KEY = 1;
    const FOREIGN_KEY = 2;
    const TABLE = 3;
}