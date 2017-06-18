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

    public $comment_head="<div id=title><h3>评论</h3></div>
<button type=\"button\" class=\"btn  btn-sm btn-default\" style='float: right;margin-top: -35px;' data-toggle=\"modal\" data-target=\"#commentsModal\"
                            data-whatever=\"\"><i class=\"fa fa-commenting\" style=' font-size: 16px;'></i> 发表评论
                    </button>
                            <ul id=\"comment-list\" class=\"comment-list\">";
    public $comment_content="        <div class=\"comment\">
            <div class=\"comment-header\" style=\"margin-bottom:0\">
                <a target=\"_blank\" href=\"#\"><i class=\"comment-avatar fa fa-user-secret\" alt=\"\" width=\"50\" height=\"50\" style=\"font-size: 50px; margin-left: 7px;\"></i></a>
                <h5 class=\"comment-title\"><a target=\"_blank\" href=\"#\">comment_name</a></h5>
                <div class=\"comment-meta\">comment_time</div>
            </div>
            <div class=\"comment-body x-auto-content\">
                <p>comment_content</p>

            </div>
        </div>";
    public $comment_content1="        <div class=\"comment\">
            <div class=\"comment-header\" style=\"margin-bottom:0\">
                <a target=\"_blank\" href=\"#\"><i class='fa fa-user-secret'></i><img class=\"comment-avatar border-circle x-avatar fa fa-user-secret\" src=\"http://tva4.sinaimg.cn/crop.0.0.180.180.50/6cf8df24jw1e8qgp5bmzyj2050050aa8.jpg\" alt=\"\" height=\"50\" width=\"50\"></a>
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
                <button type=\"button\" class=\"btn  btn-sm btn-default\" data-toggle=\"modal\" data-target=\"#commentsModal\"
                            data-whatever=\"comment_father_id\"><i class=\"fa fa-reply\"></i> 回复此评论
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

        //加载评论

        //设置评论查询条件 1:已审核评论 2:浏览者自己发的未审核评论

//        $where = ['comment_post_id'=>$this->id] ;
//        $where['comment_status'] = 1 ;

        if(empty($_COOKIE['comment_id'])){
//            var_dump($_COOKIE['comment_id']);
            $where = ['comment_status'=>1,'comment_post_id'=>$this->id];
        } else {
            $comment_id = $_COOKIE['comment_id'];
            //comment_id eg: {8828D96E-9868-5C55-214F-DE277D0E2791}
            if(strpos($comment_id,'-')== 9 && strlen($comment_id) == 38){ //comment_id 符合预期时才使用
                $where = [
                    'or',
                    'comment_status=1 and comment_post_id='.$this->id,
                    'comment_status=0 and comment_post_id='.$this->id.' and comment_ip=\''.$_COOKIE['comment_id'].'\''
                ];
            } else {
                $where = ['comment_status'=>1,'comment_post_id'=>$this->id];
            }
        }
        $comment=Comment::find()->where($where)->all();

//        var_dump($comment);
//        die();

        //评价排序 按评价爹id分类
//         $comment_group[] = "";
        foreach($comment as $c){
            if (!empty($c['comment_father_id'])){
                $comment_group[$c['comment_father_id']][]=$c;
            }
        }
//        echo "<br>--<br>";
//        var_dump($comment_group);
//todo 输出评论前，使用用户数据替换指定标签

        //输出评论头区部代码
        echo $this->comment_head;
//        $k=mt_rand(2,5);

//        var_dump($k,$l);
//        var_dump(array_key_exists(7,$comment_group));
        foreach($comment as $c){
            if(empty($c['comment_father_id'])){
                //先输出没有父级评论的顶级评论
//                echo '<br>comment_name='.$c['comment_name'];

                echo '<li>';
                $tmp = str_replace('comment_name',$c['comment_name'],$this->comment_content);
                $tmp = str_replace('comment_content',$c['comment_content'],$tmp);
                $tmp = str_replace('comment_time',$c['comment_time'],$tmp);
                echo $tmp;
                echo '<ul>';


                if(array_key_exists($c['comment_id'],$comment_group)){
//                  再输出该评论下的子级评论
                    foreach($comment_group[$c['comment_id']] as $d){
                        echo '<li>';
                        $tmp = str_replace('comment_name',$d['comment_name'],$this->comment_content);
                        $tmp = str_replace('comment_content',$d['comment_content'],$tmp);
                        $tmp = str_replace('comment_time',$d['comment_time'],$tmp);
                        echo $tmp;
                        echo '</li>';


                    }
                }

                echo '<li>';
                $tmp = str_replace('comment_father_id',$c['comment_id'],$this->comment_reply);
                echo $tmp;
                echo '</li></ul>';


                echo '</li>';

            }

        }
//        for($i=0;$i<$k;$i++){
//
//            echo '<li>';
//            echo $this->comment_content;
//            echo '<ul>';
//            $l=mt_rand(0,3);
//            for($j=0;$j<$l;$j++){
//                echo '<li>';
//                echo $this->comment_content;
//                echo '</li>';
//            }
//            echo '<li>';
//            echo $this->comment_reply;
//            echo '</li></ul>';
//
//
//            echo '</li>';
//        }

        //输出评论区尾部代码
        echo $this->comment_foot;

        $model=new Comment();
        ?>



        <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div id="alert"> </div>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="commentsModalLabel">发表评论</h4>

                    </div>
                    <?php $form = ActiveForm::begin(
                        ['action'=> ['comments'],]
                    ); ?>
                    <div class="modal-body container-fluid ">


                        <?= $form->field($model, 'comment_father_id')->hiddenInput(['value'=>null])->label(false)->error(false); ?>
                        <?= $form->field($model, 'comment_post_id')->hiddenInput(['value'=>$this->id])->label(false)->error(false); ?>
                        <?= $form->field($model, 'comment_name',['options'=>['class'=>'col-xs-5'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:32%;'],'inputOptions'=>['style'=>'width:68%'] ])->textInput(['maxlength' => true])->label('您的名字') ?>
                        <?= $form->field($model, 'comment_email',['options'=>['class'=>'col-xs-7'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:16%;'],'inputOptions'=>['style'=>'width:84%']])->textInput(['maxlength' => true])->label('邮箱') ?>
                        <?= $form->field($model, 'comment_link',['options'=>['class'=>'col-xs-12'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:12%;'],'inputOptions'=>['style'=>'width:88%']])->textInput()->label('您的网站') ?>

                        <?= $form->field($model, 'comment_content',['options'=>['class'=>'col-xs-12']])->textarea(['rows' => 3])->label('评论内容') ?>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="s();">提交</button>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>


        <script>
            $('#commentsModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // 触发事件的按钮
                var recipient = button.data('whatever') // 解析出data-whatever内容
                if(recipient == "comment_father_id"){ // 将默认值清空
                    recipient = ""
                }
                var modal = $(this)
//                console.log(recipient)
//                modal.find('.modal-title').text('Message To ' + recipient)
                modal.find('.modal-body .field-comment-comment_father_id input').val(recipient)
//                console.log(modal.find('.modal-body .field-comment-comment_father_id input').get(0))
                var str_data=$(".modal-body input").map(function(){
                    return ($(this).attr("name")+'='+$(this).val());
                }).get().join("&") ;
//                console.log(str_data)
            })

        </script>

        <script type="text/javascript">
            //ajax post comments
            function s(){
                $('#alert')[0].innerHTML= "<div class=\"alert alert-info alert-dismissable\">"
                    +"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>"
                    +"<strong>评论提交中……</strong>"
                    +"</div> ";

                var d=$(".modal-body input").map(function(){
                    return ($(this).attr("name")+'='+$(this).val());
                }).get().join("&") ;
                d=d+"&"+$(".modal-body textarea").map(function(){
                        return ($(this).attr("name")+'='+$(this).val());
                    }).get().join("&") ;

                $.ajax({
                    url: "/site/comments",
                    dataType: 'json',
                    data:d,
                    type : "post",
                    success: function(html){
                        if(html['status']==1){
                            //提示结果
                            $('#alert')[0].innerHTML= "<div class=\"alert alert-info alert-dismissable\">"
                                +"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>"
                                +"<strong>评论提交成功！</strong>"
                                +"</div> ";



                            //清除评论内容避免重复提交
                            if($('#comment-comment_content')[0]){
                                $('#comment-comment_content')[0].value=""
                            }



                            //关闭评论窗口
                            $(' .modal-header .close')[0].click()

                            //todo 将评论内容直接添加至页面 关闭页面刷新
                            location.reload();


                        } else {
                            $('#alert')[0].innerHTML= "<div class=\"alert alert-danger alert-dismissable\">"
                            +"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>"
                            +"<strong>失败!</strong>    "+html['t']
                            +"</div> ";
                        }

                    },
                    error: function (XMLHttpRequest, textStatus) {
                        $('#alert')[0].innerHTML= "<div class=\"alert alert-danger alert-dismissable\">"
                            +"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>"
                            +"<strong>sorry!评论保存失败。</strong>    "
                            +"</div> ";
//                        alert(XMLHttpRequest);
//                        alert(textStatus);
                    }
                });

            }

        </script>
        <?php
        parent::init();
    }


}