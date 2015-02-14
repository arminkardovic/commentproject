<?php 

require_once(CLASS_FOLDER . 'logs.class.php');

class User extends Log {
	
     var $user;  // variable for user id   
     var $db; 	
	 
	 var $username;
	 var $email; 	
	 var $user_ip;
	 var $desc; 
	 var $realname ; 

   public  function __construct($user,$dbase) {
        $this->user = $user;
		$this->db = $dbase;
	    $q =  $this->db->db_query("SELECT * FROM `users` WHERE id=".$user. " LIMIT 1");
		$count = mysql_num_rows($q);
		if ($count == 1) {
			$row = mysql_fetch_array($q);
			$this->username = $row ['username'];
			$this->realname = $row ['realname'];
			$this->email = $row ['email'];
			$this->user_ip = $row ['user_ip'];
			$this->desc = $row ['desc'];
		}
    }
	
	public function getId(){
		return $this->user;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function getRealname(){
		return $this->realname;
	}
	
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getUserIp(){
		return $this->user_ip;
	}
	
	public function getDesc(){
		return $this->desc;
	}
	
	public function setRealname($username){
		$q = $this->db->db_query("UPDATE users SET realname = '".
									$username."' WHERE id=".$this->user);
		if($q){
			Log::write(0,"User was changed his username");
			return true;
		}else{
			return false;
		}
	}
	
	public function setEmail($email){
		$q = $this->db->db_query("UPDATE users SET email = '".
									$email."' WHERE id=".$this->user);
		if($q){
			Log::write(0,"User was changed his password");
			return true;
		}else{
			return false;
		}
	}
	
	public function setDesc($desc){
		$q = $this->db->db_query("UPDATE users SET desc = '".
									$desc."' WHERE id=".$this->user);
		if($q){
			Log::write(0,"User was changed his description");
			return true;
		}else{
			return false;
		}
	}
	
	public function setPassword($old,$new){
		$d = $this->db;
		$s = $d->db_query("SELECT password FROM users WHERE id=".$this->user);
		$res =  mysql_fetch_array($s);
		 if(md5($old) != $res[0]){
			 return false;
		 }else{
			 $q = $d->db_query("UPDATE users SET password = '".
									md5($new)."' WHERE id=".$this->user);
				if($q){
					Log::write(0,"User was changed his poassword");
					return true;
				}else{
					return false;
				}
		 }
	}
	
	public function setBlock(){
		$q = $this->db->db_query("UPDATE users SET 	block=2 WHERE id=".$this->user);
			Log::write(0,"The user was blocked");
		if($q){
			return true;
		}else{
			return false;
		}
	}
	
	public function remouveBlock(){
		$q = $this->db->db_query("UPDATE users SET 	block=0 WHERE id=".$this->user);
			Log::write(0,"The block was remouved");
		if($q){
			return true;
		}else{
			return false;
		}
	}
	
}
?>
