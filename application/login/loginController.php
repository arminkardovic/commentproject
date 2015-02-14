<?php 
class loginController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false){
			    $registry = Registry::getInstance();	
			    $model = $this->load->model('login');

				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array($input->appendStylesheet($file['css']['ui']),
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery']),
						 $input->appendJS($file['js']['jquery-ui']),
						 $input->appendJS($file['js']['script'])
				  );
				$var = $model->pageVariable();
				
				$vars['title'] =  $args;
				$vars['files'] =  $files;

				$this->load->view('login',$vars);
	    }	
		
		 public function loginUser($args = false, $args2 = false){
			    $registry = Registry::getInstance();
			    $model = $this->load->model('login');
				$var = $model->loginUser($args,$args2);
				
				if(!$var['error']){
					$val = $model->generateOTP();
					if($val['error']){
						 $ret = array("login" => true ,"error"=>$val['text'], "key"=>"NO KEY");
					}else{
						 $ret = array("login" => true,"key"=>$val['key'], "error"=> "");
					}
				}else{
					if($args != "" || $args2 != ""){
						if(isset($var['ban'])){
							$ret = array("error"=> T_("This user has been blocked!") ,"login" => false);
						 }else{
							$ret = array("error"=> T_("This user does not exist!") ,"login" => false);
						 }
					}
				}
			 echo json_encode($ret);		
		 }
		 
		 
		 public function loginOtp($args = false, $args2 = false){
			    $registry = Registry::getInstance();
			    $model = $this->load->model('login');
				
			    $var =  $model->checkCode($args,$args2);
                echo json_encode($var);
				
		 }
		 
		
		
}

?>