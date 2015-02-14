<?php 
require_once(CLASS_FOLDER . 'database.class.php');
require_once(CLASS_FOLDER . 'user.class.php');
require_once(CLASS_FOLDER . 'otp.class.php');

class settingsModel extends baseModel{
		
		public function name(){
			$return = array();
			$return[0] = array('title'=>'Settings panel');
			$return[1] = array('title'=>'Settings');

			return $return;
		}
		
		public function files(){
			    $registry = Registry::getInstance();	
				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array($input->appendStylesheet($file['css']['ui']),
				         $input->appendStylesheet($file['css']['core']),
						  $input->appendStylesheet($file['css']['user']),
						 $input->appendJS($file['js']['jquery']),
						 $input->appendJS($file['js']['jquery-ui']),
						 $input->appendJS($file['js']['script']),
						 $input->appendJS($file['js']['user'])
				  );

			return $files;
		}
		
		public function getOtpInfo(){
			 $registry = Registry::getInstance();	
			  $config = $registry->config;
			  $db = new Database($config['db']['db1']);
			  $otp = new Otp($_SESSION['id'],$db);
			  $a = $otp->getKey();
			  $vars = array('number_key'=>$otp->numOfKey(),
			  				'expire_date'=>$otp->getExpireDate(),
							'key'=>$a['key']);
			  return $vars;
		}
		
		public function changeUsername($username){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    $user = new User($_SESSION['id'],$db);
			return  $user->setRealname($username);
		}
		
		public function changeEmail($email){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    $user = new User($_SESSION['id'],$db);
			return  $user->setEmail($email);
		}
		
		public function changePassword($old, $new){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    $user = new User($_SESSION['id'],$db);
			return  $user->setPassword($old,$new);
		}
		
		public function getDefined(){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    //$user = new User($_SESSION['id'],$db);
            /*$user = new User();
			$var = array();
			$var['email'] = $user->getEmail();
			$var['name'] = $user->getRealname();
            */
            $var['email'] = "armin@gmail.com";
			$var['name'] = "Armin";
			return $var;
			
		}
		
		public function generateOtp($key, $code){
			
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    $otp = new Otp($_SESSION['id'],$db);
			$res = $otp->ckeckCode($key, $code);
			if($res){
				$var = $otp->generateCode();
				$tm = $otp->insertCode($var);
				if($tm){
					unset($var['date']);
					return $var;
				}else{
					return false;	
				}
				
			}	
		}
		
		public function getLanguage(){
			$registry = Registry::getInstance();
		    $config = $registry->lang;
			return $config;	
		}
		
		public function activateOtp($key, $code){
			$registry = Registry::getInstance();
		    $config = $registry->config;
			$db = new Database($config['db']['db1']);
		    $otp = new Otp($_SESSION['id'],$db);
			$res = $otp->activateOtp($key, $code);

			return $res;	
		}
		
		
	}


?>