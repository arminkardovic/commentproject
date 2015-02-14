<?php 
class indexController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false){
			  $registry = Registry::getInstance();	
			  $model = $this->load->model('index');
               


				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array($input->appendStylesheet($file['css']['ui']),
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery']),
						 $input->appendJS($file['js']['jquery-ui']),
						 $input->appendJS($file['js']['script'])
				  );
				
				$vars['title'] = 'Text of title';
				$vars['files'] =  $files;
				$this->load->view('index',$vars);	
	    }
		
		public function getArgs(){
			
		     	$model = $this->load->model('index');
				$vars['title'] = 'Armin Kardovic first MVC get Args Method !!!!';
				$vars['posts'] =  $model->name();
				$this->load->view('index',$vars);	
		}
		
		public function some($argument = false){
			    is_array($argument) ? $argument : array();
				
		     	$model = $this->load->model('index');
				$vars['title'] = 'Armin Kardovic first MVC';
				$vars['arg'] = $argument;
				$vars['posts'] =  $model->name();
				$this->load->view('index',$vars);	
		}

	
}

?>