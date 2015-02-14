<div class="row">
<div class="col-md-10">
    <!--
   <div class="page-header">
        <h1></h1>
       <small><?php echo $post->title; ?></small>
   </div>
    -->
    
     <h1><a href=""><?php echo $post->title; ?></a></h1>
     
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
        <?php echo $post->long_text; ?>
    </article>
</div>
</div>

<div class="row">
      <h2 class="page-header">Comments</h2>
    
    <div class="col-md-10">
      <a href="/post/comment/<?php echo $post->id; ?>#komentari" class="btn btn-primary">
          Svi komentari (<?php echo $numComments;?>)
      </a>
      <a href="/post/comment/<?php echo $post->id; ?>" class="btn btn-primary pull-right">
          Dodaj Komentar
      </a>
    </div>
    <br>
    <br>
    <div class="col-md-10">
<?php 

    if(!isset($comments) || $comments == FALSE)
    {
         echo "<div class='alert alert-info' role='alert'>Nema komentara, komentarisite prvi</div>";
    } else {
    ?>
        <section class="comment-list">
            <!-- First Comment -->
    <?php $int =  0; foreach ($comments as $comment){ $x = isset($comment->depth) ? $comment->depth : 0;  $int++; if($int>10) break; ?>
            
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
                    <div class="comment-user"><i class="fa fa-user"></i> <?php echo $comment->comm_author_name ;?></div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> <?php echo $comment->dtime ;?></time>
                  </header>
                  <div class="comment-post">
                    <p>
                     <?php echo $comment->comm_text ;?>
                    </p>
                  </div>

                </div>
                  
                  
              </div>
            </div>
          </article>   
        </section>
    <?php
    } // foreach commnets as comment
    } // else block closed
        
?>
    </div>    
</div>