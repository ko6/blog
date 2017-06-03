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
            var_dump($_COOKIE['comment_id']);
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
        $comment=Comment::find()->where($where)->asArray()->all();

        var_dump($comment);
        die();


//todo 输出评论前，使用用户数据替换指定标签

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



        <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
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
                        <?= $form->field($model, 'comment_link',['options'=>['class'=>'col-xs-12'],'labelOptions'=>['style'=>'float:left;padding:3px 0;width:12%;'],'inputOptions'=>['style'=>'width:88%']])->textInput()->label('您的站点') ?>

                        <?= $form->field($model, 'comment_content',['options'=>['class'=>'col-xs-12']])->textarea(['rows' => 3])->label('评论内容') ?>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        //todo ajax 提交评论；前端中转保存；成功后提示；清除评论框中内容；记录用户ip；同ip免审核显示；
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                        <button type="button" class="btn btn-primary" onclick="s();">Send message</button>
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
                console.log(recipient)
//                modal.find('.modal-title').text('Message To ' + recipient)
                modal.find('.modal-body .field-comment-comment_father_id input').val(recipient)
                console.log(modal.find('.modal-body .field-comment-comment_father_id input').get(0))
                var str_data=$(".modal-body input").map(function(){
                    return ($(this).attr("name")+'='+$(this).val());
                }).get().join("&") ;
                console.log(str_data)
            })

//            $.ajax({
//
//                var str_data=$("#dlg_form input").map(function(){
//                    return ($(this).attr("name")+'='+$(this).val());
//                }).get().join("&") ;
//            type: "POST",
//                url: "some.php",
//                data: str_data,
//                success: function(msg){
//                alert( "Data Saved: " + msg );
//            }
//            });
        </script>

        <script type="text/javascript">
            //ajax post comments

            function s(){

                var d=$(".modal-body input").map(function(){
                    return ($(this).attr("name")+'='+$(this).val());
                }).get().join("&") ;

//                t1.innerHTML="<span class='glyphicon glyphicon-time'></span>检测中…";
//                if(ip_t2==ip){ //如果有目标2，同步刷新
//                    $(t2).css({"background-color":"white","color":"black"});
//                    t2.innerHTML="<span class='glyphicon glyphicon-time'></span>检测中…";
//                }
                $.ajax({
                    url: "/site/comments",
                    dataType: 'json',
                    data:d,
                    type : "post",
                    success: function(html){
                    alert(html);
                        //  alert(t1.innerHTML);
//                    console.log(t1.innerHTML);
//                    console.log($(t2).css("background-color"));
//                    console.log(key);
                        if(html['ping_status']==1){
                            $(t1).css({"background-color":"green","color":"white"});
                            var out="";
                            if("ping_time" in html){out=" "+html['ping_time']}
                            if("ping_lost" in html){out=out+" lost("+html['ping_lost']+")"}
                            t1.innerHTML="<span class='glyphicon glyphicon-ok'></span>"+out;
                            if("ping_message" in html){
                                t1.title=html['ping_message']
                            }


                            if(ip_t2==ip){
                                t2.innerHTML=html['new_version']
                                t2.title="当前版本："+html['new_version']+"  更新内容："+html['new_description']+"####"
                                    +"更新前是："+html['old_version']+"  更新内容："+html['old_description']+"####"
                                    +"缓冲区是："+html['temp_version']+"  更新内容："+html['temp_description']+"####"
                                    +"更新时间："+html['update_time']
                                t2.title=t2.title.replace(/\#\#\#\#/g,'\n') //将####替换成换行符，直接输出换行符会被转义成可视字符
                                $(t2).css({"background-color":get_style(html['new_version']),"color":"white"});
                            }
                        } else {
                            $(t1).css({"background-color":"red","color":"white"});
                            var out="";
                            if("ping_time" in html){out=" "+html['ping_time']}
                            if("ping_lost" in html){out=out+" lost("+html['ping_lost']+")"}
                            t1.innerHTML="<span class='glyphicon glyphicon-remove'></span> "+out;
                            if("ping_message" in html){
                                t1.title=html['ping_message']
                            }
                            if(ip_t2==ip){
                                t2.innerHTML="　"
                                $(t2).css({"background-color":"red","color":"white"});
                            }
                        }

                    },
                    error: function (XMLHttpRequest, textStatus) {
                        // alert(textStatus);
                        t1.innerHTML="<span class='glyphicon glyphicon-exclamation-sign'></span>检测失败";
                        if(ip_t2==ip){
                            t2.innerHTML=t1.innerHTML
                        }
                    }
                });

            }



            jQuery(function(){

                var obj=$(".list-view");//确定数据范围
                var list=obj.find("div[data-key]");//需要判断状态的列表

                $.each(list,function(key,val){
                    var div=$(val).find("div#ip").get(0);//需要判断状态的目标
                    if(div!=undefined){
                        if(div.innerHTML==1){ //判断记录状态，状态为1时才ping
                            div.onclick=ping;
                            div.click();
                        } else {
                            $(div).css({"background":"#eeeeee"})
                            div.innerHTML="<span class='glyphicon glyphicon-ban-circle' style='color:red;'> 已禁用</span>";
                        }
                    }
                })

            })
        </script>
        <?php
        parent::init();
    }


}