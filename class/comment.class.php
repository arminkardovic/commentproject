<?php 

class Comment {
    
     var $db; 	
    
     public   $comment_id;
     public   $subject;
     public   $parrent_comment_id;
     public   $comm_text;
     public   $comm_author_name;
     public   $is_view;
     public   $del_num;
     public   $like;
     public   $dlike;
     public   $dtime;
     public   $post_id;
     public   $depth;
     
    
   public function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
            case 7:
                self::__construc4( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6]);
                break;
            case 8:
                self::__construct2( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7]);
                break;
            case 9:
                self::__construct3( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8] );
         }
   }
    
   public function __construct1($dbase) {
		$this->db = $dbase;
   }
    
   public function __construct2( $comment_id, $subject, $parrent_comment_id, 
                                  $comm_text, $comm_author_name, $like, $dlike, $dtime) 
   {
         $this->comment_id = $comment_id;
         $this->subject = $subject;
         $this->parrent_comment_id = $parrent_comment_id;
         $this->comm_text = $comm_text;
         $this->comm_author_name = $comm_author_name;
         $this->like = $like;
         $this->dlike = $dlike;
         $this->dtime = $dtime;
   }
    
    public function __construct4( $comment_id, $del_num, $comm_text, 
                                $comm_author_name, $like, $dlike, $dtime) 
   {
         $this->comment_id = $comment_id;
         $this->dtime = $del_num; 
         $this->comm_text = $comm_text;
         $this->comm_author_name = $comm_author_name;
         $this->like = $like;
         $this->dlike = $dlike;
         $this->dtime = $dtime;
          
   }
    
  public function __construct3( $comment_id, $subject, $parrent_comment_id, 
                                  $comm_text, $comm_author_name, $like, $dlike, $dtime, $depth) 
   {
         $this->comment_id = $comment_id;
         $this->subject = $subject;
         $this->parrent_comment_id = $parrent_comment_id;
         $this->comm_text = $comm_text;
         $this->comm_author_name = $comm_author_name;
         $this->like = $like;
         $this->dlike = $dlike;
         $this->dtime = $dtime;
         $this->depth = $depth;
   }
        
   public function getNewComments()
   {
        $results = array();
        try{
            $data = $this->db->query('SELECT `comment_id`, `subject`, `parent_comment_id`, `comm_text`, `comm_author_name`,  `com_like`, `dislike`, `dtime` FROM `comments` WHERE`is_view` = 0 ORDER BY `dtime` DESC');
            $data->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Comment" );
            while($row = $data->fetch()) {
                $results[] = $row;
            }
            return $results;
        }catch (PDOException $e){
            return false;
        }
        return false;
   }
    
    
   public function getReportedComment()
   {
        $results = array();
        try{
            $data = $this->db->query('SELECT `comment_id`, `del_num`, `comm_text`, `comm_author_name`,  `com_like`, `dislike`, `dtime` FROM `comments` WHERE`is_view` < 2 AND `del_num` > 2 ORDER BY `del_num` DESC');
            $data->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Comment" );
            while($row = $data->fetch()) {
                $results[] = $row;
            }
            return $results;
        }catch (PDOException $e){
            return false;
        }
        return false;
   }
    
   public function reviewComment($comment_id,$is_allow)
   {
         try{
            
            $cod = "SELECT * FROM `comments` WHERE `comment_id` = {$comment_id} LIMIT 1";
            $oneRow = $this->db->prepare( $cod );
            $oneRow->execute();
            $rr = $oneRow->fetch();
            
            if(!empty($rr))
            {
                $sql = "";
                
                if($is_allow == true)
                {
                    $sql = "UPDATE `comments` SET `is_view`= 1 WHERE `comment_id` = {$comment_id} LIMIT 1";
                } else {
                    $sql = "UPDATE `comments` SET `is_view`= 2 WHERE `comment_id` = {$comment_id} LIMIT 1";
                }
                
                $up = $this->db->prepare($sql);
                $up->execute();
                $count = $up->rowCount();
                
                if($count == 1) return true;
            } 
           return false;
        }catch (PDOException $e){
            return false;
        }
   }
    
   public function createComment($name, $text, $post_id, $parrent_id = false)
   {
       
        $subject  = "";
        try{
            
            // nadji subject
            if($parrent_id != FALSE)
            {
                $sql = "call comments_hier(:comm_id)";
                $c = $this->db->prepare( $sql );
                $c->execute(array("comm_id"=>intval($parrent_id)));
                $re = $c->fetchAll(PDO::FETCH_ASSOC);
                $subs = array();
                
                foreach ($re as $x)
                {
                    $subs[] = $x['subject']; 
                }
                
                if(count($subs) > 1)
                {
                    $last = $subs[count($subs) - 1];
                    $first = $subs[0];
                    $result = substr($last, 0, count($first) + 2);
                    $next = intval($result[count($result)-1]) + 1;
                    
                    $cFirst = count($first);
                    if($cFirst > 1){
                        $first = substr($first, 0,  -1);
                        $subject = $first . $next;
                    } else {
                        $subject = $subs[0] . "-" . $next;
                    }
                } else {
                   $subject = $subs[0] . "-1";
                }
            } else {
                $cod = "SELECT subject FROM comments 
                        WHERE post_id = {$post_id} AND parent_comment_id = 0 ORDER BY subject DESC LIMIT 1";
                $oneRow = $this->db->prepare( $cod );
                $oneRow->execute();
                $rr = $oneRow->fetchColumn();
                if($rr == false)
                {
                   $subject = "1";
                } else {
                    $subject = intval($rr) + 1;
                }
            }
            
            $c = false;    
            
            $sql = 
            "INSERT INTO comments 
                (subject, comm_text, comm_author_name, is_view, del_num, com_like, dislike, dtime, parent_comment_id, post_id)
            VALUES 
                (:subj, :comm_text, :com_name, 0, 0, 0, 0, NOW(), :pcid, :post_id)";
            
            $pcid = isset($parrent_id) ? $parrent_id : NULL;
            $statement = $this->db->prepare( $sql );
            $statement->execute(array(
                "comm_text" => $text,
                "com_name" => $name,
                "post_id" => $post_id,
                "subj" => $subject,
                "pcid" => $pcid
            ));
            
            return true;
        }catch (PDOException $e){
            var_dump($e);
            return false;
        }
        return false;
    }
    
    public function getCommentNum($post_id)
    {
        try{
            $sql ="SELECT count(*) AS countNum FROM comments WHERE post_id = {$post_id} AND is_view = 1";
            $statement = $this->db->prepare( $sql );
            $statement->execute();
            return $statement->fetchColumn();
        }catch (PDOException $e){
            return false;
        }
        return false;
    }
    
    
    public function updateReport($comment_id)
    {
        try{
            
            $cod = "SELECT del_num FROM `comments` WHERE `comment_id` = {$comment_id} LIMIT 1";
            $oneRow = $this->db->prepare( $cod );
            $oneRow->execute();
            $rr = $oneRow->fetch();
            
            //var_dump($is_like,$comment_id);
            if(!empty($rr))
            {
                $del_num = isset($rr['del_num']) ? intval($rr['del_num']) : 0;
                $del_num++;
                $sql = "UPDATE `comments` SET `del_num` = {$del_num}  WHERE `comment_id` ={$comment_id}";

                $up = $this->db->prepare($sql);
                $up->execute();
                $count = $up->rowCount();
                
                if($count == 1) return true;
            } 
           return false;
        }catch (PDOException $e){
            return false;
        }
    }
    
    public function updateLike($is_like,$comment_id)
    {
        try{
            
            $cod = "SELECT `dislike`,`com_like` FROM `comments` WHERE `comment_id` = {$comment_id} LIMIT 1";
            $oneRow = $this->db->prepare( $cod );
            $oneRow->execute();
            $rr = $oneRow->fetch();
            
            //var_dump($is_like,$comment_id);
            if(!empty($rr))
            {
                $disl = isset($rr['dislike']) ? intval($rr['dislike']) : 0;
                $like = isset($rr['com_like']) ? intval($rr['com_like']) : 0;
                
                $sql = "";
                if($is_like == "true"){
                    $like++;
                    $sql = "UPDATE `comments` SET `com_like`= {$like}  WHERE `comment_id` ={$comment_id}";
                } else {
                    $disl++;
                    $sql = "UPDATE `comments` SET `dislike` = {$disl}  WHERE `comment_id` ={$comment_id}";
                    
                }
                
                $up = $this->db->prepare($sql);
                $up->execute();
                $count = $up->rowCount();
                
                if($count == 1) return array('like'=>$like, 'dislike'=>$disl);
            } 
           return false;
        }catch (PDOException $e){
            return false;
        }
        return false;
    }
    
    public function getAllComments($post_id)
    {
        try{
            $allComments = "SELECT comment_id FROM comments WHERE post_id = :id AND is_view = 1 AND parent_comment_id = 0";
            $sql = "call comments_hier(:comm_id)";
            
            $all = $this->db->prepare( $allComments );
            $all->execute(array("id"=>$post_id));

            
            $res = $all->fetchAll(PDO::FETCH_ASSOC);
            
            $commout = array();
            $count = 0;
            foreach ($res as $n)
            {
                $c = $this->db->prepare( $sql );
                $c->execute(array("comm_id"=>intval($n['comment_id'])));
                $re = $c->fetchAll(PDO::FETCH_ASSOC);
                foreach ($re as $x)
                {
                    $x['parrent_comment_id'] = isset($x['parrent_comment_id']) ? $x['parrent_comment_id'] : 0;
                    $come = new Comment($x['comment_id'], $x['subject'], $x['parrent_comment_id'], 
                                        $x['comm_text'], $x['comm_author_name'], $x['com_like'], 
                                        $x['dislike'], $x['dtime'], $x['depth']);
                    $commout[$count] = $come;
                    $count ++;
                }
                $c = false;    
            }
            return $commout;
        }catch (PDOException $e){
            return false;
        }
    }
    
}

function chk($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}
?>
