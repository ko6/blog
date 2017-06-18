<?php

use yii\helpers\Url;
use frontend\views\site\comments;
//use frontend\assets\AppAsset;
/* @var $this yii\web\View */

if (isset($post)) {
    //有相关文章信息  # code...

    //设置页面标题、描述及关键字，如果有的话
    isset($post['post_title'])&&$this->title =$post['post_title'];
    isset($post['post_excerpt'])&&$this->registerMetaTag(['name' => 'description',  'content' => $post['post_excerpt']], 'description');
    isset($post['post_keywords'])&&$this->registerMetaTag(['name' => 'keywords',  'content' => $post['post_keywords']], 'keywords');

    ?>
    <style>
        .tips {
            color:black;
        }
    </style>
    <div class="blog">
        <!-- start main -->
        <div class="container">
            <div class="main row">
                <h2 class="style"><?=$post['post_title'] ?></h2>
                <div class="blog_list pull-left">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-calendar-o"></i><span><?=date("Y-m-d",$post['created_at']) ?></span></li>
                        <li><i class="fa fa-user"></i><span>koko</span></li>
                        <li><i class="fa fa-tags"></i>

                                    <?php
                                   if(isset($post['post_tips']) && $tips = array_unique(explode("|",$post['post_tips']))){
                                       if(count($tips)>0){
                                           foreach($tips as $tip){
                                               echo "<a href=". Url::to('/t/'.$tip)." >$tip</a>";
                                               }
                                           }
                                       }

                                    ?>
                          </li>
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
                    <?php
                    //根据文章正文的类型解析文章（1:富文本，2:markdown)
                    if($post['post_content_type'] == 2) {
                        echo yii\helpers\Markdown::process($post['post_content']);
                    } else {
                        echo $post['post_content'];
                    }
                    ?>

                </div>
                <?= comments::widget(['id'=>$post['post_id']]) ?>
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
