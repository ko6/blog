<?php

/* @var $this yii\web\View */

$this->title = '1';
// $this->description = isset($site_info['site_name'])?$site_info['site_name']:'My Yii Application';

 $this->registerMetaTag(['name' => 'description',  'content' => 'new description'], 'description');
 $this->registerMetaTag(['name' => 'keywords',  'content' => 'new keywords'], 'keywords');
// var_dump($post);

  if (isset($post)) {
      //有相关文章信息  # code...

?>
    <div class="blog">
        <!-- start main -->
        <div class="container">
            <div class="main row">
                <h2 class="style"><?=$post['post_title'] ?></h2>
                <div class="blog_list pull-left">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-calendar-o"></i><span><?=date("Y-m-d",$post['updated_at']) ?></span></li>
                        <li><i class="fa fa-user"></i><span>koko</span></li>
                        <li><a href="#"><i class="fa fa-tags"></i><span><?=$post['post_title']?></span></a></li>
                    </ul>
                </div>
                <div class="b_left blog_list pull-right">
                    <ul class="list-unstyled">
                      <li><a href="#"><i class="fa fa-eye"></i><span><?=$post['post_hits'] ?></span></a></li>
                      <!-- <li><a href=""><i class="fa fa-heart"></i><span> 28</span></a></li> -->
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="blog details row">

                    <?=yii\helpers\Markdown::process($post['post_content'])?>

                </div>
            </div>
        </div>
    </div>
    <!-- end main -->

    <?php

  } else {
      //没找到对应的文章  # code...

 ?>
        The requested page does not exist.


        <?php

  }

 ?>
