<?php
require_once(CLASS_FOLDER . 'logs.class.php');
class Otp extends Log {
	
     var $user;  // variable for user id   
     var $db; 	

   public  function __construct($user,$dbase) {
        $this->user = $user;
		$this->db = $dbase;
    }

   public function encreaseAttempt(){ 
	    $q =  $this->db->db_query("SELECT attempt FROM users WHERE id=".$this->user);
		$var = mysql_fetch_object($q);		
		$var = $var->attempt + 1;
		if(ATTEPT_ERROR >= $var){
			$var2 =  $this->db->db_query("UPDATE users SET attempt=" . $var . " WHERE id=".$this->user);	
			if($var2){
				return true;
			}else{
				return false;
			}
		}
		return false;
   }
   
   
   public function resetAttempt(){
	   $var = $this->db->db_query("UPDATE users SET attempt=0 WHERE id=".$this->user);
	   if($var){
		   return true;
	   }else{
		   return false;
	   }
   }
   
   
   /* ukoliko je kod veci od predvidjenog vrati true
    *  Vraca true ako je preskocio 
	*/
   
   public function ckeckAttempt(){
	   $q = $this->db->db_query("SELECT attempt FROM users WHERE id=".$this->user);
	   $var = mysql_fetch_object($q);
	   if(ATTEPT_ERROR <= $var->attempt){
		   return true;
	   }else{
	   	   return false;
	   }
   }
   
   /* vraca broj koji je ostao od pokusaja 
   */
   public function getAttept(){
	   $q = $this->db->db_query("SELECT * FROM users WHERE id=".$this->user);
	   $var = mysql_fetch_array($q);
	   return (ATTEPT_ERROR - $var['attempt']);
   }
   
   
   /* ovaj dio koda vraca array sa kljucem 
    * ukoliko ima error uzima se error
	*/ 
   public function getKey(){
	   $data = $this->db; 
	   $query = $data ->db_query("SELECT * FROM a_otp WHERE id_user=" .
							$this->user . " AND activate=1  ORDER BY RAND() LIMIT 1");		
		$count = mysql_num_rows($query);
		if ($count == 1) {
			$var = mysql_fetch_array($query);
		    return array("id"=>$var['0'],"key"=>$var['2'],
						"expire_date"=>$var['4'], "error"=>false);
		}else{
			return array("error"=>true);
		}		
   }
   
   
   public function checkBlockTime($args = false){
			$query = $this->db->db_query("SELECT block_time FROM users WHERE id=".$this->user);
			$var = mysql_fetch_object($query);
			$todays_date = date("Y-m-d H:i:s"); 
	        $today = strtotime($todays_date); 
	        $expiration_date = strtotime($var->block_time); 
			
			// return in minute value of block time 
		    if($args){
				return $ti = round(abs($expiration_date - $today) / 60,0);
			}
			
			if($expiration_date >$today){
				return true;
		   	}else{
				return false;
			}

	}
	
	public function setBlockTime(){
		$data = $this->db;
		$date =  date('Y-m-d H:i:s', strtotime('+10 minutes'));
		$var = $data ->db_query("UPDATE users SET block_time='"
							.$date."' WHERE id=".$this->user);
		if($var){
		    $this->banIncrease();
			Log::write(0,"Set ban to user");// message on english
			return true;
		}else{
			return false;
		}
		
	 }
	 
	 private function banIncrease(){
	    $data = $this->db;
		$var = $data ->db_query("UPDATE users SET block = block + 1 WHERE id=".$this->user);
		if($var){
			return true;
		}else{
			return false;
		}
	 }
	 
	 public function checkBan(){
		$data = $this->db;
			$query = $data ->db_query("SELECT block FROM users WHERE id=".$this->user); 
			$var2 = mysql_fetch_object($query);
		if($var2->block >1){
			return true;
		}else{
			return false;
		}
	    
	 }
	
	
   /* vraca true ili false u zavisnosti od datuma koda koji je unijet
   */
   public function isKeyPeriod(){
	   $data = $this->db;
	   $query = $data ->db_query("SELECT * FROM a_otp WHERE id_user=" .
							$this->user . " AND  activate=1  ORDER BY RAND() LIMIT 1");		
		$count = mysql_num_rows($query);
		if ($count == 1) {
			$row = mysql_fetch_array($query);
			 $todays_date = date("Y-m-d"); 
	         $today = strtotime($todays_date); 
	         $expiration_date = strtotime($row['expire_date']); 
			 if($expiration_date > $today){
				return true;
		   	}else{
				return false;
			}
		}
	   return false;
   }
   
   public function getExpireDate(){
	    $data = $this->db;
	    $query = $data ->db_query("SELECT expire_date FROM a_otp WHERE id_user=" .
							$this->user . " AND activate=1  ORDER BY RAND() LIMIT 1");	
	    $count = mysql_num_rows($query);
		if ($count == 1) {
			$q = mysql_fetch_array($query);
			return $q[0];
		}else{
			return "No date";
		}
	   
   }
   
   /* chekira kod ukoliko je sve u redu vraca true 
    *  ukoliko nesto ne valja vraca false
	*/

   public function ckeckCode($code, $key){
	   $q =  $this->db->db_query("DELETE  FROM a_otp WHERE id_user =".$this->user . " AND activate=0");
	    $data = $this->db; 
				$query = $data ->db_query(
				"SELECT * FROM a_otp WHERE id_user=" .
							$this->user . " AND public_key='".$code."' AND activate=1 LIMIT 1");								
		
	    $count = mysql_num_rows($query);
		if($count == 1){
			$var = mysql_fetch_array($query);
			if($var['private_key'] == $key){
				$this->resetAttempt();
				$_SESSION['otp'] = true;  // maybe we can change this
				Log::write(0,"User was successfully insert otp code");// message on english
				return true;
			}
		}
		return false;
   }
   
   /* sort multidimensional array put key value
    * and this method will sort data from low to hig
	*/
   function aasort(&$array, $key) {
		$sorter=array();
		$ret=array();
		reset($array);
		
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		
		asort($sorter);
		
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		
		$array=$ret;
   }


   public function generateCode(){
	   $keys = array();
	   $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	   
	  $keys['date'] = date("Y-m-d",strtotime("+ 1 month"));
	  for($x = 0 ; $x<75 ; $x++){
		   $start =  rand(0,99);
		   if($start<10){
			   $start = "0".$start;
		   }
		   $int = rand(0,51);
		   $int2 = rand(0,51);
		 
		   $rand_letter = $a_z[$int] .$a_z[$int2] ;
		   $key = $start ."-". $rand_letter;
		   $code = "";
		   for($i = 0 ; $i<4 ; $i++){
				$code = $code . rand(0,9);
		   }
		   
		  $cod = array("key"=>$key,"code"=>$code);
		  array_push($keys, $cod);
		  
	   }
	   //sorting
	   $this->aasort($keys,"key");
	  // echo "<pre>" . print_r($keys,1) . "</pre>";
	   Log::write(0,"Code was generated for user");// message on english
	   return $keys;
   }
   
   public function remouveAll($int){
	   if($int == 1){
	  $q =  $this->db->db_query("DELETE  FROM a_otp WHERE id_user =".$this->user . " AND activate=1");
	   }else{
		   $q =  $this->db->db_query("DELETE  FROM a_otp WHERE id_user =".$this->user . " AND activate=0");
	   }
	  if($q){
		   Log::write(0,"Code was remouved from database");
		  return true;
	  }else{
		  return false;
	  }
   }
   
   /* insert into mysql code 
   */
   public function insertCode($array){
		$sql = array();
		$date = $array['date'];
	    unset($array['date']);
		foreach($array as $row ) {
			$sql[] = "(".$this->user.", '".$row['key']."','".$row['code']."', '".$date."' , 0)";
		}
	
		 $val= "INSERT INTO a_otp (`id_user`, `public_key`, `private_key`, `expire_date` ,`activate` ) VALUES ";
		 $val =   $val . implode(',', $sql);
		 
		 
		   
		 $q =  $this->db->db_query($val);
			 if($q){
				 Log::write(0,"Code was created in database");
				 return true;
			 }else{
				 return false;
			 }
		  
		  return false;
   }
   
   public function activateOtp($code, $key){
	   $data = $this->db; 
				$query = $data ->db_query(
				"SELECT * FROM a_otp WHERE id_user=" .
							$this->user . " AND public_key='".$code."'  AND activate=0 LIMIT 1");								
		
	    $count = mysql_num_rows($query);
		
		if($count == 1){
			$var = mysql_fetch_array($query);
			if($var['private_key'] == $key){
			 $data = $this->db; 
			 if($this->remouveAll(1)){
				$query = $data ->db_query(
				"DELETE FROM a_otp WHERE id_user=" .
							$this->user . " AND  activate=1 LIMIT 1");
							
				$query = $data ->db_query(
				"UPDATE `a_otp` SET activate=1 WHERE id_user=" .
							$this->user . " ");	
							return true;
			}
			}
			return false;
	    }
		return false;
			
   }
   
   /* return number of active key in system 
    * if date has expiride method return 0
	*/
	
   public function numOfKey($code, $key){
	    $data = $this->db; 
				$query = $data ->db_query(
				"SELECT count(*) FROM a_otp WHERE id_user=" . 
						$this->user . " AND expire_date > NOW() AND activate=1");
		if($query){
			$row = mysql_fetch_array($query);
			return $row[0] ;
		}
		return 0;
   }
   
   
   public function setIpAdress(){
	   $data = $this->db;
	   $var = $data ->db_query("UPDATE users SET  user_ip='"
							.$this->get_client_ip()."' WHERE id=".$this->user);
		if($var){
			return true;
		}else{
			return false;
		}				
			
   }
   
   /* uporedjuje ip adresu sa adresom u bazi ukoliko su iste vrati true
   */
   public function compareIp(){
	   	$query = $this->db->db_query("SELECT user_ip FROM users WHERE id=".$this->user);
	    $var = mysql_fetch_object($query);
		
		if($var == $this->get_client_ip()){
			return true;
		}
	   return false;  
   }
   
   public function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
	 
		return $ipaddress;
	}
	
}

?>