<?php
/**
 * Created by koko
 * Email: kokostudio@qq.com
 * Date: 2017/3/5
 * Time: 16:40
 */

namespace frontend\views\site;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Comment;

class Comments extends \yii\widgets\ActiveForm
{

    public $id=null;
    public $template= <<<template
<div id='comment'>
        <div id=title><h3>评论</h3></div>

        <ul id="comment-list" class="comment-list">
        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h4 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h4>
                <div class="comment-meta"><a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000">志文轩i</a> created at 22小时前, Last updated at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
</li>        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h4 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h4>
                <div class="comment-meta"><a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000">志文轩i</a> created at 22小时前, Last updated at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
</li>        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default" style="float:right;" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li>        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default" style="float:right;" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li>        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default" style="float:right;" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li>        <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
         <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>

</li> <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default"  href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li> <li>
        <div class="comment">
            <div class="comment-header" style="margin-bottom:0">
                <a target="_blank" href="/user/0014886236196198e78351161d4494b8aefa52ca77190c2000"><img class="comment-avatar border-circle x-avatar" src="http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg" alt="" height="50" width="50"></a>
                <h5 class="comment-title"><a target="_blank" href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000">道理还是不错的</a></h5>
                <div class="comment-meta">created at 22小时前</div>
            </div>
            <div class="comment-body x-auto-content">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>
        <ul>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default"  href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li>
        <li>
            <div class="x-comment-info">
                <hr>
                <a target="_blank" class="btn  btn-sm btn-default"  href="/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply"><i class="fa fa-reply"></i> 回复此评论</a>
            </div>
        </li>
    </ul>
</li>
</ul>
<!--        .ssss -->
    .</div>
template;
    public $comment_head="<div id=title><h3>评论</h3></div>
                            <ul id=\"comment-list\" class=\"comment-list\">";
    public $comment_content="        <div class=\"comment\">
            <div class=\"comment-header\" style=\"margin-bottom:0\">
                <a target=\"_blank\" href=\"/user/0014886236196198e78351161d4494b8aefa52ca77190c2000\"><img class=\"comment-avatar border-circle x-avatar\" src=\"http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg\" alt=\"\" height=\"50\" width=\"50\"></a>
                <h5 class=\"comment-title\"><a target=\"_blank\" href=\"/discuss/00142954259723555cb71c29536401390a587b71a218900000/001488623514293a5b917f51802408191c48687a730cba7000\">道理还是不错的</a></h5>
                <div class=\"comment-meta\">created at 22小时前</div>
            </div>
            <div class=\"comment-body x-auto-content\">
                <p>满满的套路，想不到廖老师是这么风趣的人。。。</p>

            </div>
        </div>";
    public $comment_li="";
    public $comment_reply="            <div class=\"x-comment-info\">
                <hr>
                <a target=\"_blank\" class=\"btn  btn-sm btn-default\"  href=\"/discuss/00142954259723555cb71c29536401390a587b71a218900000/00147787749749162ccf4579342403c967186d4141c80c1000#reply\"><i class=\"fa fa-reply\"></i> 回复此评论</a>
                <button type=\"button\" class=\"list-group-item\" data-toggle=\"modal\" data-target=\"#exampleModal\"
                            data-whatever=\"张三\">张三
                    </button>
            </div>";
    public $comment_foot="</ul></div>";

    public $style=<<<stye
    <style>

.x-avatar {
    border: 1px solid #dddddd;
}
    .border-circle{
    border-radius: 50%;
    }
.comment-header {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: transparent none repeat scroll 0 0;
    border-color: #dddddd -moz-use-text-color -moz-use-text-color;
    border-image: none;
    border-radius: 0;
    border-style: solid none none;
    border-width: 1px medium medium;
    margin-bottom: 15px;
    padding: 10px;
}
.comment-header::before, .comment-header::after {
    content: "";
    display: table;
}
.comment-header::after {
    clear: both;
}
.comment-avatar {
    float: left;
    margin-right: 15px;
}
.comment-title {
    font-size: 14px;
    line-height: 20px;
    margin: 5px 0 0;
}
.comment-meta {
    color: #999999;
    font-size: 11px;
    line-height: 16px;
    margin: 2px 0 0;
}
.comment-body {
    padding-left: 75px;
    padding-right: 10px;
}
.comment-body > *:last-child {
    margin-bottom: 0;
}
.comment-list {
    list-style: outside none none;
    padding: 0;
}
.comment-list .comment + ul {
    list-style: outside none none;
    margin: 25px 0 0;
}
.comment-list > li:nth-child(n+2), .comment-list .comment + ul > li:nth-child(n+2) {
    margin-top: 25px;
}
@media (min-width: 768px) {
.comment-list .comment + ul {
    padding-left: 75px;
}
}
.comment-primary .comment-header {
    background-color: #ebf7fd;
    border-color: rgba(45, 112, 145, 0.3);
    color: #2d7091;
    text-shadow: 0 1px 0 #ffffff;
}
.x-comment-info {
    text-align:right;
}
</style>
stye;


    /**
     * @inheritdoc
     */
    public function init()
    {
//        echo $this->template;
//        echo $this->id;
        echo $this->style;



        //输出评论头区部代码
        echo $this->comment_head;
        $k=mt_rand(2,5);

//        var_dump($k,$l);
        for($i=0;$i<$k;$i++){

            echo '<li>';
            echo $this->comment_content;
            echo '<ul>';
            $l=mt_rand(0,3);
            for($j=0;$j<$l;$j++){
                echo '<li>';
                echo $this->comment_content;
                echo '</li>';
            }
            echo '<li>';
            echo $this->comment_reply;
            echo '</li></ul>';


            echo '</li>';
        }

        //输出评论区尾部代码
        echo $this->comment_foot;

        $model=new Comment();
        ?>



        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">发表评论</h4>
                    </div>
                    <?php $form = ActiveForm::begin(
                        ['action'=> ['backend/comment/create'],]
                    ); ?>
                    <div class="modal-body container-fluid ">


                        <?= $form->field($model, 'comment_father_id')->hiddenInput(['value'=>1])->label(false)->error(false); ?>
                        <?= $form->field($model, 'comment_post_id')->hiddenInput(['value'=>1])->label(false)->error(false); ?>
                        <?= $form->field($model, 'comment_name',['options'=>['class'=>'col-xs-5'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:32%;'],'inputOptions'=>['style'=>'width:68%'] ])->textInput(['maxlength' => true])->label('您的名字') ?>
                        <?= $form->field($model, 'comment_email',['options'=>['class'=>'col-xs-7'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:16%;'],'inputOptions'=>['style'=>'width:84%']])->textInput(['maxlength' => true])->label('邮箱') ?>
                        <?= $form->field($model, 'comment_link',['options'=>['class'=>'col-xs-12'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:12%;'],'inputOptions'=>['style'=>'width:88%']])->textInput()->label('您的站点') ?>

                        <?= $form->field($model, 'comment_content',['options'=>['class'=>'col-xs-12']])->textarea(['rows' => 3])->label('评论内容') ?>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        //todo ajax 提交评论；前端中转保存；成功后提示；清除评论框中内容；记录用户ip；同ip免审核显示；
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">好友列表</div>
            <div class="panel-body">
                <div class="list-group" role="group" aria-label="好友列表">
                    <button type="button" class="list-group-item" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="张三">张三
                    </button>
                    <button type="button" class="list-group-item" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="李四">李四
                    </button>
                    <button type="button" class="list-group-item" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="王二">王二
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // 触发事件的按钮
                var recipient = button.data('whatever') // 解析出data-whatever内容
                var modal = $(this)
                console.log(modal)
//                modal.find('.modal-title').text('Message To ' + recipient)
                modal.find('.modal-body input').val(recipient)
            })
        </script>
        <?php
        parent::init();
    }


}