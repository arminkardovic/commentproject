<?php 
class settingsController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false){
			    $model = $this->load->model('settings');
				$vars['title'] = $args;
				$vars['files'] = $model->files();
				$vars['langs'] =  $model->getLanguage();
				$vars['defined'] =  $model->getDefined();
				$this->load->view('settings',$vars);	
	    }
		
		//change username of user 
		public function chuser($new){
			$model = $this->load->model('settings');
			$q = $model->changeUsername($new);
			if($q){
				echo json_encode(array("error"=> false ,"text"=>T_("Sucessifully changed your name")));
			}else{
				echo json_encode(array("error"=> true ,"text"=>T_("Ops something is wrong")));
			}
			
		}
		//change email of user 
		public function chemail($new){
			$model = $this->load->model('settings');
			$q = $model->changeEmail($new);
			if($q){
				echo json_encode(array("error"=> false ,"text"=>T_("Sucessifully email changed")));
			}else{
				echo json_encode(array("error"=> true ,"text"=>T_("Ops something is wrong")));
			}
			
		}
		
		public function chpass($old=false, $new=false){
			$model = $this->load->model('settings');
			$q = $model->changePassword($old, $new);
			
			if($q){
				echo json_encode(array("error"=> false ,"text"=>T_("Sucessifully password changed")));
			}else{
				echo json_encode(array("error"=> true ,"text"=>T_("Ops something is wrong")));
			}

			
		}
		
		public function otp(){
			    $model = $this->load->model('settings');
				$vars['files'] = $model->files();
				$vars['title'] = "OTP";
				$var = $model->getOtpInfo();
				$vars['expire_date'] = $var['expire_date'];
				$vars['number_key'] = $var['number_key'];
				$vars['key'] = $var['key'];
				if($var['number_key'] < 5 ){
					$vars['row'] = "<tr><td colspan='3' align='center'>
				    ".T_("You mast generate new code becouse you have") . "
					".$var['number_key']." </td></tr>";
				}else{
					$vars['row'] ="";
				}
				$this->load->viewDiff('otp','settings',$vars);	 
		}
		
		public function genotp($key=false, $code=false){
			 $model = $this->load->model('settings');
			 $m =  $model->generateOtp($key, $code);
			 if($m != false){
				 echo json_encode($m);
			 }else{
				 echo json_encode(array("error"=> true ,"text"=>T_("Ops something is wrong, type again code"))); 
			 }
		}
		
		 public function activate($args = false, $args2 = false){
			 	if($args != false  &&  $args2 == false){
					 echo json_encode(array("error"=> true ,"text"=>T_("Password field is empty"))); 
					 return;
			    }
				 $model = $this->load->model('settings');
				 $m =  $model->activateOtp($args, $args2);
				 if($m){
					 echo json_encode(array("error"=> false ,"text"=>T_("Otp was activated"))); 
				 }else{
					 echo json_encode(array("error"=> true ,"text"=>T_("Ops something is wrong with code"))); 
					 }
				
	     }
		
}

?>