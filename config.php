<?php 
	
	/*
	*  Define  some variable of system
	*/
   define('SUB_FOLDER', "");
   
   define('CLASS_FOLDER', "class/");
   define('ATTEPT_ERROR', 4);
   
   $sysLang = array('sr-RS', 'en-US');
   
   	$config = array(
	"db" => array(
		"db1" => array(
			"dbname" => "blic",
			"username" => "root",
			"password" => "",
			"host" => "localhost"
		),
		"db2" => array(
			"dbname" => "database2",
			"username" => "dbUser",
			"password" => "pa$$",
			"host" => "localhost"
		)
	));
	
	$includeFile = array(
	"css" => array(
			"core" => '/'.SUB_FOLDER ."lib/css/bootstrap.css",
			"comments" => '/'.SUB_FOLDER ."lib/css/comments.css",
			"user" => '/'.SUB_FOLDER ."lib/css/user.css"
		),

	"js"=> array(
			"jquery" => "http://code.jquery.com/jquery-1.9.1.js",
            "bootstrap_js" => '/'.SUB_FOLDER . "lib/js/bootstrap.js",
			"comments" => '/'.SUB_FOLDER ."lib/js/comments.js",
			"script" => '/'.SUB_FOLDER ."lib/js/script.js",
			"user" => '/'.SUB_FOLDER ."lib/js/user.js"
		)
	 );
 
	 class HeadFile  {
		 public function __construct(){
		 }
		 public function appendJS($loc){
			//if(endsWith($loc, '.js')){
				return "<script type='text/javascript' src='".$loc."'></script>";
		//	}else{
				return false;
			//}	
		 }
		 public function appendStylesheet($loc){
			return "<link type='text/css' href='".$loc."' rel='stylesheet' />";	
		 }
		 
		 
	 }
     $inport = new HeadFile();
     $registry = Registry::getInstance();  // make variable for all pages
     $registry->config = $config;          // set config variable 
	 $registry->head = $inport; 
	 $registry->files = $includeFile;  
	 $registry->lang = $sysLang;  

?>