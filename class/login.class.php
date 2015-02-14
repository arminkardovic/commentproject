<?php
require_once(CLASS_FOLDER . 'logs.class.php');

class Login extends Log {
     var $username;  // variable for username 
     var $password;   // variable for password
     var $db; 
	 var $user = false;	
   

    function login($username, $password,$dbase) {
        $this->username = $username;
		$this->password = $password;
		$this->db = $dbase;
    }

	
	function loginUser(){

			if($this->username != null || $this->password != null){
				$data = $this->db; 
				$pass  = md5($this->password);  // encode pass with md5 hash algo
				$query = $data ->db_query("SELECT * FROM users WHERE username='" .
									$this->username . "' AND password='" . $pass . "'");
				$count = mysql_num_rows($query);
				$row = mysql_fetch_array($query);

				if ($count == 1) {
					$_SESSION['user'] = $this->username;
					$this->user = $row['id'];
					    Log::write(0,"User is login on system");
						return true;
					} else {
						return false;
				}
			}
			return false;
			
	}
	
	public function getID($username, $password){
	   $data = $this->db; 
	   $password = md5($password);
	   $query = $data ->db_query("SELECT * FROM users WHERE username='" .
									$username. "' AND password='" . $password . "'");
				$count = mysql_num_rows($query);
				$row = mysql_fetch_array($query);
				if ($count == 1) {
					return  $row['id'];
				}else{
					return false;
				}
	   
	}
	
}
?>