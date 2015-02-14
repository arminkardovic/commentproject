<br/>
        <div class="row">

     <?php 
            if(isset($message)){
                echo "<div class='alert alert-{$message['type']}' role='alert'>{$message['text']}</div>";
            }
     ?>
            <div class="col-md-3">
                <p class="lead">Admin Strana</p>
                <div class="list-group">
                    <a href="/admin/index" class="list-group-item active">Novi Komentari</a>
                    <a href="/admin/report" class="list-group-item">Zalbe</a>
                </div>
            </div>

            <div class="col-md-9">
                <?php foreach($comments as $comment) { ?>

                    <div class="well">
                          <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment->comm_author_name; ?></h4>
                                <p><?php echo $comment->comm_text;?></p>
                              <ul class="list-inline list-unstyled">
                                <li><span><i class="glyphicon glyphicon-calendar"></i><?php echo $comment->dtime ;?></span></li>
                                <li>|</li>                                
                                <li>
                                    <a href="/admin/?forbidden_comm=<?php echo $comment->comment_id;?>" class="btn btn-danger">Zabrani</a>
                                </li>
                                <li>|</li>
                                <li>
                                    <a href="/admin/?allow_comm=<?php echo $comment->comment_id;?>" class="btn btn-success">Odobri</a>
                                </li>
                                </ul>
                           </div>
                        </div>
                    </div>
                
                <?php } ?>

            </div>

        </div>

