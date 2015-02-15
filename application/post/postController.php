<?php
require_once(CLASS_FOLDER . 'database.class.php');

class postController extends baseController{
	
	
		public function __construct(){
			parent::__construct();
		}
    
        public function index($args = false){
           header("Location: /");
           die();
	    }
    
        public function article($args = false){
                $registry = Registry::getInstance();	
                $model = $this->load->model('post');
                $post = $model->getPostByID($args[0]);

                $input =  $registry->head; 
                $file = $registry->files;

                $files =  array($input->appendStylesheet($file['css']['comments']),
                             $input->appendStylesheet($file['css']['core']),
                             $input->appendJS($file['js']['jquery'])
                );
                $vars['title'] = 'Home';
                $vars['files'] = $files;
                $vars['post'] = $post;
                $vars['numComments'] = $model->countComment($args[0]);
                $vars['comments'] = $model->getComments($args[0]);
                $this->load->view('post',$vars);
        }
    
    
    public function updatelkdsl($args = false)
    {
        $registry = Registry::getInstance();	
        $model = $this->load->model('post');
        $args = $registry->args;
        
        $comment_id =  isset($args['comment_id']) ? $args['comment_id'] : FALSE;
        $is_like = isset($args['islike']) ? $args['islike'] : FALSE;
        
        if(!$comment_id) {
            echo json_encode(array("req"=>FALSE));
            die();
        }
        
        $arr = isset($_COOKIE['comments']) ? $_COOKIE['comments'] : "";
        $arr = json_decode($arr);
        $arr[] = $args['comment_id'];
        setcookie("comments", json_encode($arr));
        
        echo json_encode ( $model->like_button($is_like, $comment_id));
    }
    
    public function report_comment($args = false)
    {
        $registry = Registry::getInstance();	
        $model = $this->load->model('post');
        $args = $registry->args;
        
        $comment_id =  isset($args['comment_id']) ? $args['comment_id'] : FALSE;
        $res = $model->updateReportCommnet($comment_id);
        
        if($res == true){
            
            $arr = isset($_COOKIE['report_comm']) ? $_COOKIE['report_comm'] : "";
            $arr = json_decode($arr);
            $arr[] = $args['comment_id'];
            setcookie("report_comm", json_encode($arr));
            
            echo json_encode(array("type_r"=>true));
        } else {
            echo json_encode(array("type_r"=>false));
        }
    }
    
    public function comment($args = false){
                $registry = Registry::getInstance();	
                $model = $this->load->model('post');
                $post = $model->getPostByID($args[0]);
                
                $args = $registry->args;
                $input =  $registry->head; 
                $file = $registry->files;

                
                $files =  array(
                             $input->appendStylesheet($file['css']['comments']),
                             $input->appendStylesheet($file['css']['core']),
                             $input->appendJS($file['js']['jquery']),
                             $input->appendJS($file['js']['bootstrap_js']),
                             $input->appendJS($file['js']['mustache']),
                             $input->appendJS($file['js']['comments'])
                );
                $vars['title'] = 'Dodaj komentar';
                $vars['files'] = $files;
                $vars['post'] = $post;
        
                $numa = rand ( 0 ,10 );
                $numb = rand ( 0 ,10 );
        
                $robot  = $numa + $numb;
                if(isset($args[0]) && isset($args['name']))
                {
                    
                    /* DODAVANJE KOMENTARA    */
                    if($_SESSION["robot"] == $args['human']) 
                    {
                        $parrent = isset($args['comm_repl_id']) ? $args['comm_repl_id'] : FALSE;
                        $comm = $model->addComment($args['name'], $args['message'], $args[0], $parrent);
                        if( $comm == TRUE)
                        {
                             $vars['message']['type'] = "success";
                             $vars['message']['text'] = "Vas komentar je postavljen i ceka odobrenje";
                        } else {
                             $vars['message']['type'] = "danger";
                             $vars['message']['text'] = "Nije postavljen komentar";
                        }
                        
                    } else {
                         $vars['message']['type'] = "danger";
                         $vars['message']['text'] = "Potvrdite da ste covjek :D";
                    } // IF IS ROBOT
                    /* KRAJ DODAVANJA KOMENTARA */
                    
                }
        
                $_SESSION["robot"] = $robot;
                $vars['numComments'] = $model->countComment($args[0]);
                $vars['comments'] = $model->getComments($args[0]);
                $vars['robots'] = "{$numa} + {$numb}";
               
                $arr = isset($_COOKIE['comments']) ? $_COOKIE['comments'] : "";
                $arr = json_decode($arr);
                $arr = isset($arr[0]) ? $arr : array();
        
                $rep = isset($_COOKIE['report_comm']) ? $_COOKIE['report_comm'] : "";
                $rep = json_decode($rep);
                $rep = isset($rep[0]) ? $rep : array();
        
                $vars['disabled_likes'] = $arr;
                $vars['disabled_report'] = $rep;
                $this->load->viewSimple('post', 'addCommet',$vars);
        }
    
    
        public function getNumber($var)
        {
            $num = array('nula', 'jedan', 'dva', 'tri', 'cetiri', 'pet', 'sest');
        
        } 
    
        public function ajaxGetComments($args=false)
        {
            $registry = Registry::getInstance();	
            $model = $this->load->model('post');
            $args = $registry->args;
            
            $comm = $model->getComments($args[0]);
        
            
            $arr = isset($_COOKIE['comments']) ? $_COOKIE['comments'] : "";
            $arr = json_decode($arr);
            
            $arr = isset($arr[0]) ? $arr : array();
        
            $rep = isset($_COOKIE['report_comm']) ? $_COOKIE['report_comm'] : "";
            $rep = json_decode($rep);
            $rep = isset($rep[0]) ? $rep : array();
            
            $com = array();
            $num = 0;
            
            foreach($comm as $c => $k) {
                $newComm = array();
                $newComm["comment_id"] = $k->comment_id;
                $newComm["subject"] = $k->subject;
                $newComm["parrent_comment_id"] = $k->parrent_comment_id;
                $newComm["comm_text"] = $k->comm_text;
                $newComm["comm_author_name"]= $k->comm_author_name;
                $newComm["like"] = $k->like;
                $newComm["dlike"] = $k->dlike;
                $newComm["dtime"] = $k->dtime;
                $newComm["depth"] = $k->depth;
                
                $newComm["depth_sty"] = "";
                
                $x = isset($k->depth) ? $k->depth : 0;
                if($x > 0)
                {
                    $y = $x-1;
                    $newComm["depth_sty"] = " col-md-offset-{$x} col-sm-offset-{$y} ";
                }
                
                $tmp = (10-$x); 
                $newComm["depth_sty_in"] = " col-md-{$tmp} col-sm-{$tmp} ";
                
                $newComm["dis_rep"] = "";
                
                if (in_array($k->comment_id, $rep)){
                    $newComm["dis_rep"] = "disabled";
                }
                
                $newComm["dis_like"] = "";
                
                if (in_array($k->comment_id, $arr)){
                    $newComm["dis_like"] = "disabled";
                }
                
                $com[$num] = $newComm;
                $num++;
                 
            }
            echo json_encode($com);
        } 
    
        public function ajaxGetHronoComments($args = false)
        {
            $registry = Registry::getInstance();	
            $model = $this->load->model('post');
            $args = $registry->args;
            
            $ar = isset($args[1]) ? $args[1] : TRUE;
            $ar = ($ar == "true") ? TRUE : FALSE;
            $comm = $model->getHronoComments($args[0], $ar);
        
            
            $arr = isset($_COOKIE['comments']) ? $_COOKIE['comments'] : "";
            $arr = json_decode($arr);
            
            $arr = isset($arr[0]) ? $arr : array();
        
            $rep = isset($_COOKIE['report_comm']) ? $_COOKIE['report_comm'] : "";
            $rep = json_decode($rep);
            $rep = isset($rep[0]) ? $rep : array();
            
            $com = array();
            $num = 0;
            
            foreach($comm as $k) {
                $newComm = array();
                $newComm = $k;
                $newComm["depth_sty"] = "";
                
                $newComm["like"] = $k['com_like'];
                $newComm["dlike"] = $k['dislike'];
                
                $x = isset($k['depth']) ? $k['depth'] : 0;
                if($x > 0)
                {
                    $y = $x-1;
                    $newComm["depth_sty"] = " col-md-offset-{$x} col-sm-offset-{$y} ";
                }
                
                $tmp = (10-$x); 
                $newComm["depth_sty_in"] = " col-md-{$tmp} col-sm-{$tmp} ";
                
                $newComm["dis_rep"] = "";
                
                if (in_array($k['comment_id'], $rep)){
                    $newComm["dis_rep"] = "disabled";
                }
                
                $newComm["dis_like"] = "";
                
                if (in_array($k['comment_id'], $arr)){
                    $newComm["dis_like"] = "disabled";
                }
                
                $com[$num] = $newComm;
                $num++;
                 
            }
            echo json_encode($com);
        }
}



?>