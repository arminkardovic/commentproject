<?php 

class Dispacher {
	
 public static function dispach(Request $request){
	        $controller_name =  $request->getController();
			$controller = $controller_name.'Controller';
			$method = $request->getMethod();
			$args = $request->getArgs();

			$controllerFile = SITE_PATH . 'application/' . $controller_name . '/' . $controller.'.php';
            	
			 
			 if(is_readable($controllerFile)){
				require_once $controllerFile;
				
				$controller = new $controller;
				$method = (is_callable(array($controller,$method))) ? $method : 'index';	
				
				if(!empty($args)){
					 $registry = Registry::getInstance();
                     $registry->args = $args;
					call_user_func_array(array($controller,$method),$args);
				}else{	
					call_user_func(array($controller,$method));
				}	
				return;
			}

			throw new Exception('404 - '.$request->getController().' not found');
	 
 }	
	
}

?>