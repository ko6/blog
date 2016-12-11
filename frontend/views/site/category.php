<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

// $this->title = '1';
// $this->description = isset($site_info['site_name'])?$site_info['site_name']:'My Yii Application';

 $this->registerMetaTag ( [  'name' => "description" ,  'content'=>"new description",],"description");
 $this->registerMetaTag ( [  'name' => "keywords" ,  'content'=>"new keywords",],'keywords');
// var_dump($post);

if (isset($post)) {
    //有相关文章信息  # code...

?>
<div class="blog"><!-- start main -->
	<div class="container">
		<div class="main row">
			<div class="col-md-12 blog_left">
				<!-- <h2 class="style">koko blog</h2> -->
        <?php foreach ($post as $p ) {
    ?>


				<div class="blog_main">
          <div class="col-md-4" style="max-height:248px;overflow:hidden;">
            <a href="single-page.html"><img src=<?= $p['post_pic']!=""?$p['post_pic']:"/images/blog_pic1.jpg"?> alt="" class="blog_img img-responsive" /></a>
          </div>
          <div  class="col-md-8">
            <h4><a href="single-page.html"><?=$p['post_title']?></a></h4>
            <div class="blog_list pull-left">
              <ul class="list-unstyled">
                <li><i class="fa fa-calendar-o"></i><span><?=date("Y-m-d",$p['created_at'])?></span></li>
                <li><a href="#"><i class="fa fa-tags"></i><span><?=$p['post_hits']?></span></a></li>
              </ul>
            </div>
            <div class="b_left blog_list pull-right">
                <ul class="list-unstyled">
                  <li><i class="fa fa-eye"></i><span><?=$p['post_hits']?></span></li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <p class="para" style="max-height:70px;overflow:hidden;"><?=$p['post_excerpt']?></p>
            <div class="read_more btm">
              <?= Html::a('阅读全文', ["a/$p[post_id]/$p[post_url_name]"], ['class' => 'btn btn-success']) ?>
            </div>
          </div>
				</div>
        <div class="clearfix"></div>
        <hr>

        <?php
} ?>
			</div>

			<!-- <div class="col-md-4 blog_right">
				<ul class="ads_nav list-unstyled">
					<h4>Ads 125 x 125</h4>
						<li><a href="#"><img src="images/ads_pic.jpg" alt=""> </a></li>
						<li><a href="#"><img src="images/ads_pic.jpg" alt=""> </a></li>
						<li><a href="#"><img src="images/ads_pic.jpg" alt=""> </a></li>
						<li><a href="#"><img src="images/ads_pic.jpg" alt=""> </a></li>
					<div class="clearfix"></div>
				</ul>
				<ul class="tag_nav list-unstyled">
					<h4>tags</h4>
						<li class="active"><a href="#">art</a></li>
						<li><a href="#">awesome</a></li>
						<li><a href="#">classic</a></li>
						<li><a href="#">photo</a></li>
						<li><a href="#">wordpress</a></li>
						<li><a href="#">videos</a></li>
						<li><a href="#">standard</a></li>
						<li><a href="#">gaming</a></li>
						<li><a href="#">photo</a></li>
						<li><a href="#">music</a></li>
						<li><a href="#">data</a></li>
						<div class="clearfix"></div>
				</ul>
				<!-- start social_network_likes -->
					<!-- <div class="social_network_likes">
				      		 <ul class="list-unstyled">
				      		 	<li><a href="#" class="tweets"><div class="followers"><p><span>2k</span>Followers</p></div><div class="social_network"><i class="twitter-icon"> </i> </div></a></li>
				      			<li><a href="#" class="facebook-followers"><div class="followers"><p><span>5k</span>Followers</p></div><div class="social_network"><i class="facebook-icon"> </i> </div></a></li>
				      			<li><a href="#" class="email"><div class="followers"><p><span>7.5k</span>members</p></div><div class="social_network"><i class="email-icon"> </i></div> </a></li>
				      			<li><a href="#" class="dribble"><div class="followers"><p><span>10k</span>Followers</p></div><div class="social_network"><i class="dribble-icon"> </i></div></a></li>
				      			<div class="clear"> </div>
				    		</ul>
		          	</div>
				<div class="news_letter">
					<h4>news letter</h4>
						<form>
							<span><input type="text" placeholder="Your email address"></span>
							<span  class="pull-right fa-btn btn-1 btn-1e"><input type="submit" value="subscribe"></span>
						</form>
				</div>
			</div> -->
			<div class="clearfix"></div>
		</div>
	</div>
</div><!-- end main -->

<?php

} else {
    //没找到对应的文章  # code...



 ?>
The requested page does not exist.


<?php

}

 ?>
