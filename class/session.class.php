<?php 

// turn session on 
session_start(); 
 
class Session{
	
	
	public function __construct(){
		isset($_SESSION['id']) ? $_SESSION['id'] : null;
		isset($_SESSION['user']) ? $_SESSION['user'] : null;
		isset($_SESSION['lang']) ? $_SESSION['lang'] :  null;
	}
	
	
	public function destroy(){
		session_destroy();
	}
}

?>