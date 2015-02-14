<?php 
class logoutController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false){
			  $registry = Registry::getInstance();	
			  $model = $this->load->model('logout');
               


				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array($input->appendStylesheet($file['css']['ui']),
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery']),
						 $input->appendJS($file['js']['jquery-ui']),
						 $input->appendJS($file['js']['script'])
				  );
				
				$vars['title'] = 'Stay with us';
				$vars['files'] =  $files;
			    $model->logoutUser();
				$this->load->view('logout',$vars);	
	    }

}

?>