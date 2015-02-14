<style>
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
</style>
<br/>
        <div class="row">

            <div class="col-md-3">
                <p class="lead">Admin Strana</p>
                <div class="list-group">
                    <a href="/admin/index" class="list-group-item ">Novi Komentari</a>
                    <a href="/admin/report" class="list-group-item active">Zalbe</a>
                </div>
            </div>

            <div class="col-md-9">
                <?php foreach($comments as $comment) { ?>
                    <div class="well">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <?php echo $comment->comm_author_name; ?>
                                    <div class="btn-group pull-right" style="margin-left:5px;">
                                        <button type="button" class="btn btn-danger">Broj prijava: <?php echo $comment->del_num;?></button>
                                    </div>
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-success"><?php echo $comment->com_like;?></button>
                                        <button type="button" class="btn btn-danger"><?php echo $comment->dislike;?></button>
                                    </div>
                                </h4>
                                <p><?php echo $comment->comm_text;?></p>
                              <ul class="list-inline list-unstyled">
                                <li>
                                    <span><i class="glyphicon glyphicon-calendar"></i><?php echo $comment->dtime ;?></span>
                                </li>
                                <li>|</li>                                
                                <li>
                                    <a href="/admin/?deny_comm=<?php echo $comment->comment_id;?>" class="btn btn-danger"><i class="fa fa-warning"></i> Zabrani</a>
                                </li>
                              </ul>
                           </div>
                        </div>
                    </div>
                
                <?php } ?>

            </div>

        </div>

