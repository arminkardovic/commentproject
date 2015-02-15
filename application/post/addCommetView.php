<style>
.form_replay {
    display:none; /* hide for JS enabled browsers */
}
#temporary_form {
    display:none; /* hide for JS enabled browsers */
}
#comment_template {
    display:none;
}

</style>

<br>
<br>
<div class="row">
<div class="col-md-10">
     <?php 
            if(isset($message)){
                echo "<div class='alert alert-{$message['type']}' role='alert'>{$message['text']}</div>";
            }
     ?>
     <h1><a href="<?php echo "/post/article/{$post->id}"?>"><?php echo $post->title; ?></a></h1>
     
     <p class="lead">
         <i class="fa fa-user"></i> pise <a href=""><?php echo $post->author; ?></a>
     </p>
     <hr>
     <p>
         <i class="fa fa-calendar"></i> Postavljeno <?php echo $post->datetime; ?>
     </p>
     <p>
         <i class="fa fa-tags"></i> Tagovi: 
         <?php 
                    $ara = explode(',', $post->tags);
                    foreach($ara as $a){
                        echo "<a href=''><span class='badge badge-info'>{$a}</span></a> ";
                    }
         ?>
             
     </p>
					
    <hr>
    
    <article class="just">
        <?php echo $post->short_text; ?>
    </article>
</div>
</div>


<div class="row">
<div class="col-md-10">
<hr>
</div>
</div>

<div class="row">
<div class="col-md-10">
<h1>Ostavite komentar</h1>
<form class="form-horizontal" role="form" method="post" action="/post/comment/<?php echo $post->id; ?>">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Ime:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" placeholder="Ime i prezime" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Komentar:</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="message"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="human" class="col-sm-2 control-label"><?php echo $robots; ?> = ?</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
        </div>
    </div>
</form>
</div>
</div>

<div class="row">
    <h2 id="komentari" class="page-header">Comments</h2>

            <h4 class="page-header">Komentara: <?php echo $numComments;?></h4>
       
            <button class="load_comments btn btn-primary">Standardno</button>
            <button id="hrono" class="btn btn-primary">Hronoloski</button>
            <button class="load_comments btn btn-success">
                <span class="glyphicon glyphicon-plus" aria-hidden="true" style="line-height: inherit;"></span>
            </button>
            <button class="load_comments btn btn-danger">
                <span class="glyphicon glyphicon-minus" aria-hidden="true" style="line-height: inherit;"></span>
            </button>
            <input type="hidden" value="<?php echo $post->id; ?>" id="post_id_hidd" />
    </div>
    
    <br>
    <div class="col-md-10 list-comment">
<?php 

    if(!isset($comments) || $comments == FALSE)
    {
         echo "<div class='alert alert-info' role='alert'>Nema komentara, komentarisite prvi</div>";
    } else {
    ?>
        <section class="comment-list">
            <!-- First Comment -->
    <?php foreach ($comments as $comment){ $x = isset($comment->depth) ? $comment->depth : 0; ?>
            
            <!-- col-md-offset-1 col-sm-offset-0 -->
          <article class="row">
            <div class="col-md-2 col-sm-2 <?php
                         if($x > 0){
                            $y = $x-1;
                            echo "col-md-offset-{$x} col-sm-offset-{$y}";
                         }
                        ?> hidden-xs">
              <figure class="thumbnail">
                <img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg">
                <figcaption class="text-center"><?php echo $comment->comm_author_name ;?></figcaption>
              </figure>
            </div>
              <!-- col-md-9 col-sm-9 -->
            <div class="<?php $tmp = (10-$x) ; echo "col-md-{$tmp} col-sm-{$tmp}"?>">
              <div class="panel panel-default arrow left">
                <div class="panel-body">
                  <header class="text-left">
                    <div class="comment-user">
                        <i class="fa fa-user"></i> 
                        <?php echo $comment->comm_author_name ;?>
                        <p style="float:right;">
                            <button class="btn btn-danger report_b" data="<?php echo $comment->comment_id;?>"
                            data-container="body" data-toggle="popover" data-placement="top" data-content="Hvala, vas zahtjev bice razmotren." data-original-title="" title=""
                                <?php if (in_array($comment->comment_id, $disabled_report)) { echo "disabled"; }?> >
                                <i class="fa fa-warning"></i> Prijavi Komentar
                            </button>
                        </p>
                    </div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> <?php echo $comment->dtime ;?></time>
                  </header>
                  <div class="comment-post">
                    <p>
                     <?php echo $comment->comm_text ;?>
                    </p>
                  </div>
                  <div>
                       
                      
                      <div class="row">
<div id="holder_button_<?php echo $comment->comment_id;?>" >                          
  <div class="col-lg-2">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-success like_b" type="button" 
                data-container="body" data-toggle="popover" data-placement="top" data-content="Hvala sto ste glasali." data-original-title="" title=""
                  type-b="true" data="<?php echo $comment->comment_id;?>" 
                  <?php if (in_array($comment->comment_id, $disabled_likes)) { echo "disabled"; }?> >
                <span class="glyphicon glyphicon-plus" aria-hidden="true" style="line-height: inherit;"></span>  
        </button>
      </span>
      <input type="text" class="form-control" value="<?php echo $comment->like ;?>" disabled id="comm_like_<?php echo $comment->comment_id;?>">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-2">
    <div class="input-group">
      <input type="text" class="form-control" value="<?php echo $comment->dlike ;?>" disabled id="comm_disl_<?php echo $comment->comment_id;?>">
      <span class="input-group-btn">
        <button class="btn btn-danger like_b" type="button"
                 data-container="body" data-toggle="popover" data-placement="top" data-content="Hvala sto ste glasali." data-original-title="" title=""
                type-b ="false" data="<?php echo $comment->comment_id;?>" 
                <?php if (in_array($comment->comment_id, $disabled_likes)) { echo "disabled"; }?> >
            <span class="glyphicon glyphicon-minus" aria-hidden="true" style="line-height: inherit;"></span>
          </button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div> <!-- HOLDER DIV -->
                          
                          
 <p class="text-right" style="margin-right: 10px;">
     <a href="#" data="<?php echo $comment->comment_id;?>" class="btn btn-default btn-sm replay">
         <i class="fa fa-reply"></i> Odgovori
     </a>
</p>
</div><!-- /.row -->
                      
                      
                      
                      
                      
                      
                      
                      
                      
                  </div>
                    
                    
                 
                </div>
              </div>
                
                <div class="form_replay" id="comment_form_<?php echo $comment->comment_id;?>">
                
                    
                </div><!-- form replay -->
                
            </div>
          </article>   
        </section>
    <?php
    } // foreach commnets as comment
    } // else block closed
        
?>
    </div>    
</div>


<div id="comment_template">
    {{#.}}
          <article class="row">
    <div class="col-md-2 col-sm-2 {{depth_sty}} hidden-xs">
        <figure class="thumbnail">
            <img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg">
            <figcaption class="text-center">
                {{comm_author_name}}
            </figcaption>
        </figure>
    </div>
    <div class="{{depth_sty_in}}">
        <div class="panel panel-default arrow left">
            <div class="panel-body">
                <header class="text-left">
                    <div class="comment-user">
                        <i class="fa fa-user"></i> {{comm_author_name}}
                        <p style="float:right;">
                            <button class="btn btn-danger report_b" data="{{comment_id}}" data-container="body" data-toggle="popover" data-placement="top" data-content="Hvala, vas zahtjev bice razmotren." data-original-title="" title="" {{dis_rep}} >
                                <i class="fa fa-warning"></i> Prijavi Komentar
                            </button>
                        </p>
                    </div>
                    <time class="comment-date" datetime="16-12-2014 01:05">
                        <i class="fa fa-clock-o"></i> {{dtime}}
                    </time>
                </header>
                <div class="comment-post">
                    <p>
                        {{comm_text}}
                    </p>
                </div>
                <div>


                    <div class="row">
                        <div id="holder_button_{{comment_id}}">
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        
        <button class="btn btn-success like_b" type="button" 
                data-container="body" data-toggle="popover" data-placement="top" data-content="Hvala sto ste glasali." data-original-title="" title="" {{dis_like}} type-b="true" data="{{comment_id}}" 
                   >
                <span class="glyphicon glyphicon-plus" aria-hidden="true" style="line-height: inherit;"></span>
                                    </button>
                                    </span>
                                    <input type="text" class="form-control" value="{{like}}" disabled id="comm_like_{{comment_id}}">
                                </div>
                                <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{dlike}}" disabled id="comm_disl_{{comment_id}}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-danger like_b" type="button"
                 data-container="body"  {{dis_like}} data-toggle="popover" data-placement="top" data-content="Hvala sto ste glasali." data-original-title="" title=""
                type-b ="false" data="{{comment_id}}" 
                 >
            <span class="glyphicon glyphicon-minus" aria-hidden="true" style="line-height: inherit;"></span>
                                    </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                        <!-- HOLDER DIV -->


                        <p class="text-right" style="margin-right: 10px;">
                            <a href="#" data="{{comment_id}}" class="btn btn-default btn-sm replay">
                                <i class="fa fa-reply"></i> Odgovori
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form_replay" id="comment_form_{{comment_id}}">


        </div>
    </div>
</article>        
{{/.}}         
</div>

<div id="temporary_form">
                  <form class="form-horizontal" role="form" method="post" action="/post/comment/<?php echo $post->id; ?>">
                       <input type="hidden" name="comm_repl_id" value="id_value" />
                      
                       <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Ime:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ime i prezime" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-2 control-label">Komentar:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="4" name="message"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="human" class="col-sm-2 control-label"><?php echo $robots; ?> = ?</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
                            </div>
                        </div>
                    </form>    
</div>