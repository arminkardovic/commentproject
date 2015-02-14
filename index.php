<?php
	
   /*
	*  MVC framework 2012 copyright zeko.me
	*  
	*
	*
	*
	*/
	
   ini_set('display_errors',1); 
   error_reporting(E_ALL);

	define('SITE_PATH', realpath(dirname(__FILE__)).'/');
	define('DEFAULT_LOCALE', 'en_US');

    require_once(SITE_PATH.'class/session.class.php');
	
	/*Require necessary files.*/
	require_once(SITE_PATH.'system/registry.php');
	require_once(SITE_PATH.'config.php');
	require_once(SITE_PATH.'system/request.php');
	require_once(SITE_PATH.'system/load.php');
	require_once(SITE_PATH.'system/baseController.php');
	require_once(SITE_PATH.'system/baseModel.php');
	require_once(SITE_PATH.'system/load.php');
	require_once(SITE_PATH.'system/dispatcher.php');
	require_once(SITE_PATH.'system/lang.php');
	require_once(SITE_PATH. 'lang/gettext.inc');
	
	// define constants

	 $session = new Session();
     $registry = Registry::getInstance();
	 
	 // to check is
     $_SESSION['lang'] = 'sr_RS';
	 isset($_SESSION['lang']) ? $lang = new Lang($sysLang,$_SESSION['lang']) : $lang = new Lang($sysLang,DEFAULT_LOCALE);

	$supported_locales = $sysLang;
	$encoding = 'UTF-8';
   
   
	try{
       Dispacher::dispach(new Request());
    } catch ( Exception $e ){
        echo $e->getMessage();
    }
	
	