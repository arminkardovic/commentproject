<?php

class Database{
	
	private $host;
	private $user;
	private $password;
	private $database;	
	public $lnk;
	public $result;	
		
		
		public function __construct($array) {
			$this -> host = $array['host'];
			$this -> user = $array['username'];
			$this -> password = $array['password'];
			$this -> database = $array['dbname'];
		}
	
		public function db_connect() {
            try {
                $link = 'mysql:host='.$this -> host.';dbname='.$this -> database;
                $otp = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_PERSISTENT => TRUE);
                $this -> lnk = new PDO($link, $this->user, $this->password, $otp);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            
		}		
		
		private function chek($object){
			$object = stripslashes($object);
			$object = mysql_real_escape_string($object);
			return $object;	
		}
		
		public function __destruct() {
			unset ($this -> user, $this -> password);
		}
		
}

?>
