<?php

require_once(CLASS_FOLDER . 'database.class.php');

class Log {
	
     var $user;  // variable for user
     var $db;
   
   
	public  function __construct() {
      	$this->user = $_SESSION['id'];
    }
	
	public  function setDB($db){
		$this->db = $db;
	}
	
	
	public function write($info,$text = false){
		$b = $this->db;
        $query = "";
		
		if($text != false){
			$query = "INSERT INTO a_logs (`id_user` ,`text` ,`date` ,`type_error`) ".
		   " VALUES(".$this->user .", '".$text."' , '" .date("Y-m-d H:i:s")."', " .$info.")";
		}else{
			$query = "INSERT INTO a_logs (`id_user` ,`date` ,`type_error`) ".
		   " VALUES(".$this->user .",  '" .date("Y-m-d H:i:s")."',".$info.")";
		}
		$b->db_query($query);
		if($b){
			return true;
		}else{
			return false;	
		}
		
	}
	
	public function showLog(){	
		$b = $this->db;
        $query = "SELECT * FROM a_logs WHERE id_user = ".$this->user . " ";

        $s =  $b->db_query($query);
		if($s){
			return mysql_fetch_array($s);
		}else{

			return false;	
		}
	}
}
?>