<?php
class Post  { 

     var $post_id;  // variable for user id   
     var $db; 	
	 
	 var $title;
	 var $short_text; 	
	 var $long_text;
	 var $author; 
	 var $datetime;
     var $tags;


     public  function __construct($db = false) {
		$this->db = $db;
     }

     public  function __construct2($post_id, $title, $short_text, $long_text, $author, $datetime, $tags, $db) 
     {
         $this->post_id =  $post_id;  // variable for user id   
         $this->db = $db; 	
	     $this->title = $title;
         $this->short_text = $short_text; 	
         $this->long_text = $long_text;
	     $this->author = $author; 
	     $this->datetime = $datetime;
         $this->tags = $tags;
     }
    
     public  function __construct3($post_id, $title, $short_text, $long_text, $author, $datetime, $tags) 
     {
         $this->post_id =  $post_id;  // variable for user id   	
	     $this->title = $title;
         $this->short_text = $short_text; 	
         $this->long_text = $long_text;
	     $this->author = $author; 
	     $this->datetime = $datetime;
         $this->tags = $tags;
     }
    

    public function getPosts()
    {
        $results = array();
        try{
            $data = $this->db->query('SELECT `id`, `title`, `short_text`, `long_text`, `author`, `datetime`, `tags` FROM `post`');
            $data->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Post" );
            while($row = $data->fetch()) {
                $results[] = $row;
            }
            return $results;
        }catch (PDOException $e){
            return false;
        }
        return false;
    }
    
    public function getPostByID($id)
    {
        $results = array();
        try{
            $data = $this->db->prepare('SELECT `id`, `title`, `short_text`, `long_text`, `author`, `datetime`, `tags` FROM `post` WHERE id = ?');
            $data->bindValue(1, $id, PDO::PARAM_INT);
            $data->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Post" );
            $data->execute();
            $row = $data->fetch();
            return $row;
        }catch (PDOException $e){
            return false;
        }
        return false;
    }

}

?>