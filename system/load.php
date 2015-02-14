<?php
	class Load{
		
		public function view($name,array $vars = null){
			$file = SITE_PATH.'application/'.$name.'/'.$name.'View.php';

			if(is_readable($file)){

				if(isset($vars)){
					extract($vars);
				}
				$this->getDefaultView($file, $vars);
				return true;
			}
			throw new Exception('View issues');
		}
        
        public function viewSimple($appname, $view,array $vars = null){
			$file = SITE_PATH.'application/'.$appname.'/'.$view.'View.php';

			if(is_readable($file)){

				if(isset($vars)){
					extract($vars);
				}
				$this->getDefaultView($file, $vars);
				return true;
			}
			throw new Exception('View issues');
		}
        
        public function getDefaultView($view,$vars)
        {
            if(isset($vars)){
				extract($vars);
            }
            $file = SITE_PATH.'application/defaultView/defaultView.php';
            $view_page = $view;
            require($file);
        }
		
		public function module($name){
			$model = $name.'Modul';
			$modelPath = SITE_PATH.'application/'. $name . '/'.$model.'.php';
			if(is_readable($modelPath)){
				require_once($modelPath);
				if(class_exists($model)){
					return new $model;
				}
			}
	    }
		
		
		public function model($name){
			$model = $name.'Model';
			$modelPath = SITE_PATH.'application/'. $name . '/'.$model.'.php';
			if(is_readable($modelPath)){
				require_once($modelPath);

				if(class_exists($model)){
					 return  new $model; 
				}
			}
			throw new Exception('Model issues.');	
		}	
	}
