<?php 
class Request {
		private $_controller;
		private $_method;
		private $_args = array();

		public function __construct(){
		    $request_url = $_SERVER['REQUEST_URI'];
			$str = "";
			
			if(isset($_GET) or isset($_POST)){
				$str =  str_replace('?'.$_SERVER['QUERY_STRING'],"",$request_url);
			}

		    $str =  str_replace(SUB_FOLDER,"",$str);
			$parts = explode('/', $str);
			$parts = array_filter($parts);

			$this->_controller = ($c = array_shift($parts))? $c: 'index';
			$this->_method = ($c = array_shift($parts))? $c: 'index';
			
			if(!empty($_GET) or !empty($_POST)){
				// array_keys method change this !!!!
				if(!empty($_GET)){
                     $this->_args = array_merge($this->_args, $_GET);
				}else{
					 $this->_args = array_merge($this->_args, $_POST);
				}
			}
            
            $arr = isset($parts[0]) ? $parts : array();
            $this->_args = array_merge($arr, $this->_args);
		}

		public function getController(){
			return $this->_controller;
		}
		public function getMethod(){
			return $this->_method;
		}
		public function getArgs(){
			return $this->_args;
		}
		
		public function setController($controller){
			 $this->_controller = $controller;
		}
		
		public function setMethod($method){
			$this->_method = $method;
		}
	
}


?>