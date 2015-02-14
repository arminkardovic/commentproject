
<br/>
<?php   
 foreach($vars['posts'] as $post)
 {
?>

            <div id="postlist">
			<div class="panel">
                <div class="panel-heading">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-9">
                                <h3 class="pull-left">
                                  <a href="/post/article/<?php echo $post->id; ?>"> <?php echo $post->title; ?> </a>
                                </h3>
                            </div>
                            <div class="col-sm-3">
                                <h4 class="pull-right">
                                    <small>
                                        <em><?php echo str_replace(" ", "<br>", $post->datetime);?> </em>
                                    </small>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                
            <div class="panel-body">
                <?php echo $post->short_text; ?> 
                <a href="/post/article/<?php echo $post->id; ?>" class="btn btn-primary pull-right">Procitaj vise</a>
            </div>
            
            <div class="panel-footer">
                <?php 
                    $ara = explode(',', $post->tags);
                    foreach($ara as $a){
                        echo "<span class='label label-default'>{$a}</span> ";
                    }
                ?>
            </div>
        </div>
 </div>


<?php
 }
?>
