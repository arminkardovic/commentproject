<?php 
require_once(CLASS_FOLDER . 'login.class.php');
require_once(CLASS_FOLDER . 'database.class.php');
require_once(CLASS_FOLDER . 'otp.class.php');

	class loginModel extends baseModel{
		
		public function pageVariable(){
			$return = array();
			$return['title'] = ' MVC login ';
			$return[1] = array('title'=>'Rozaje');
			return $return;
		}
		
		public function loginUser($username , $password ){
		    $registry = Registry::getInstance();
		    $config = $registry->config;
			
			$db = new Database($config['db']['db1']);
			if(!isset($username) || !isset($password)){
				return array("error"=> true);
			}else{
				$log = new Login($username, $password,$db);
				$us = $log->getID($username, $password);
				if($us == false){
					return array("error"=> true);
				}
				$otp = new Otp($us,$db);
				
				if($otp->checkBan()){
					return array("error"=> true,"ban"=>true);
				}
				
				if($log->loginUser()){
					$_SESSION['id'] = $log->user;
					return array("error"=> false);
			      }
		    }
			return array("error"=> true);
		}
		
		
		public function generateOTP(){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			
			$db = new Database($config['db']['db1']);
			$otp = new Otp($_SESSION['id'],$db);
			
			if($otp->checkBlockTime()){
				return array("error"=>true,"text"=>"You must wait :". 
											$otp->checkBlockTime(true). " minut");
			}else{
				if($otp->compareIp()){
                    
			    }else{
					$otp->setIpAdress();
					$otp->resetAttempt();					
				}
			}
		
			// CKECK CODE IS EXPITIED
			
			
			if(!$otp->isKeyPeriod()){
				return array("error"=>true,"text"=>"The keys was expired");
			}
			
			// METHOD ACOUNT IS BLOCKED
			
			return $otp->getKey();
		}
		
		
		public function checkCode($key, $key2){
			
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
			$otp = new Otp($_SESSION['id'],$db);
			
			if($otp->checkBlockTime()){
				return array("error"=>true,"text"=>"You must wait :". 
											$otp->checkBlockTime(true),"login_otp"=> false);
			}else if($otp->ckeckAttempt()){
				$otp->setBlockTime();
				return array("error"=>true,"text"=>"You must wait :". 
							        	$otp->checkBlockTime(true),"login_otp"=> false);
			}else if(!$otp->isKeyPeriod()){
				return array("error"=>true,"text"=> "Key period expire contact admin",
									"login_otp"=> false);
			}else{
				$var = $otp->ckeckCode($key, $key2);
				if($var){
					return array("login_otp"=> true);
				}else{
					$otp->encreaseAttempt();
					return array("error"=>true,"text"=> "Key was incorect, attempt:". $otp->getAttept(),
									"login_otp"=> false);
				}
				
				
			}//else
			
			return array("error"=>true,"text"=> "Unexpected error:","login_otp"=> false);

		}// method
		
	}


?>