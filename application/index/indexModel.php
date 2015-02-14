<?php 
    require_once(CLASS_FOLDER . 'post.class.php');

	class indexModel extends baseModel{
		
        public function getPosts()
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $post = new Post($db->lnk);
            return $post->getPosts();
        }
	}


?>