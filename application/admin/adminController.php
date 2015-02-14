<?php 

require_once(CLASS_FOLDER . 'database.class.php');

class adminController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
		
		 public function index($args = false)
         {
			  $registry = Registry::getInstance();	
			  $model = $this->load->model('admin');
              $args = $registry->args;
              $input =  $registry->head; 
              $file = $registry->files;
				
              $files =  array(
				    $input->appendStylesheet($file['css']['core']),
				    $input->appendJS($file['js']['jquery'])
              );
              
              if(isset($args["forbidden_comm"]))
              {
                  $var = $model->forbiddenComment($args["forbidden_comm"]);
                  if($var)
                  {
                      $vars['message']['type'] = "success";
                      $vars['message']['text'] = "Uspjesno ste izvrsili akciju zabrane ovog komentara";
                  } else {
                      $vars['message']['type'] = "danger";
                      $vars['message']['text'] = "Doslo je do greske i komentar nije uklonjen";
                  }
              }
             
              if(isset($args["allow_comm"]))
              {
                  $var = $model->allowComment($args["allow_comm"]);
                  if($var)
                  {
                      $vars['message']['type'] = "success";
                      $vars['message']['text'] = "Uspjesno ste izvrsili akciju, kometar je vidljiv";
                  } else {
                      $vars['message']['type'] = "danger";
                      $vars['message']['text'] = "Doslo je do greske i komentar ne moze biti prikazan";
                  }
              }
              $vars['title'] = 'Home';
              $vars['files'] = $files;
              $vars['comments'] = $model->getNewComments();
              $this->load->view('admin',$vars);	
	    }
    
        public function report($args = false)
        {
            $registry = Registry::getInstance();	
			  $model = $this->load->model('admin');
               


				$input =  $registry->head; 
				$file = $registry->files;
				
				$files =  array(
				         $input->appendStylesheet($file['css']['core']),
						 $input->appendJS($file['js']['jquery'])
				  );
				
				$vars['title'] = 'Home';
				$vars['files'] = $files;
             
				$this->load->viewSimple('admin','reportAdmin',$vars);	
        
        }
}

?>