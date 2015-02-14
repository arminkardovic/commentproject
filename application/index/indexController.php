<?php 

require_once(CLASS_FOLDER . 'logs.class.php');
require_once(CLASS_FOLDER . 'database.class.php');

class indexController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false){
			  $registry = Registry::getInstance();	
			  $model = $this->load->model('index');
               


				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array(
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery'])
				  );
				
				$vars['title'] = 'Home';
				$vars['files'] = $files;
                $vars['posts'] = $model->getPosts();
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
				
		  $registry = Registry::getInstance();	
		
		   	$config = array(
	"db" => array(
		"db1" => array(
			"dbname" => "armin",
			"username" => "armin",
			"password" => "ak991BeRO",
			"host" => "localhost"
		),
		"db2" => array(
			"dbname" => "database2",
			"username" => "dbUser",
			"password" => "pa$$",
			"host" => "localhost"
		)
	));
		
		
		     	$db = new Database($config['db']['db1']);
				
				$l = new Log();
                $l->setDB($db);
				
				
				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array($input->appendStylesheet($file['css']['ui']),
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery']),
						 $input->appendJS($file['js']['jquery-ui']),
						 $input->appendJS($file['js']['script'])
				  );
				  
				
				$vars['files'] =  $files;

				$vars['arg'] = $l->showLog();

				$this->load->view('index',$vars);	
		}
}

?>