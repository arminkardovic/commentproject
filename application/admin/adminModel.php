<?php 
    require_once(CLASS_FOLDER . 'comment.class.php');

	class adminModel extends baseModel{
		
        public function getNewComments()
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->getNewComments();
        }
        
        public function allowComment($comment_id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->reviewComment($comment_id,true);
        }
        
        
            
        public function revisionComments()
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->getReportedComment();
        }
        
        
        public function forbiddenComment($comment_id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->reviewComment($comment_id,false);
        }
	}


?>