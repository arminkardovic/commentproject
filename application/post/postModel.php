<?php 
    require_once(CLASS_FOLDER . 'post.class.php');
    require_once(CLASS_FOLDER . 'comment.class.php');

	class postModel extends baseModel{
		
        public function getPostByID($id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $post = new Post($db->lnk);
            return $post->getPostByID($id);
        }
        
        function getComments($post_id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->getAllComments($post_id);
        }
        
        public function countComment($post_id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->getCommentNum($post_id);
        }
        
        public function addComment($name, $text, $post_id, $parrent_id = false)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->createComment($name, $text, $post_id, $parrent_id);
        }
        
        public function like_button($is_like,$comment_id)
        {
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->updateLike($is_like,$comment_id);
        }
        
        public function updateReportCommnet($comm_id){
            $registry = Registry::getInstance();
		    $config = $registry->config;
            $db = new Database($config['db']['db1']);
            $db-> db_connect();
            
            $comm = new Comment($db->lnk);
            return $comm->updateReport($comm_id);
        }
	}


?>