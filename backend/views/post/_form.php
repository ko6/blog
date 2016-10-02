<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\PostCategory;
use ijackua\lepture\Markdowneditor;
use ijackua\lepture\MarkdowneditorAssets;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
'fieldConfig'=>['labelOptions'=>['style'=>'float:left;padding:7px;'],'inputOptions'=>['style'=>'width:80%','class'=>'form-control']]
    ]); ?>
    <!-- 'inputOptions'=>['class'=>'form-control col-md-4','style'=>'width:auto;'] -->

    <?= $form->field($model, 'post_category',['options'=>['class'=>'col-md-3']])->dropdownlist(PostCategory::get_post_category()) ?>

    <?= $form->field($model, 'post_status',['options'=>['class'=>'col-md-3']])->dropdownlist([1=>'发布',2=>'草稿',0=>'审核'])->label("状态") ?>

    <?= $form->field($model, 'created_at',['options'=>['class'=>'col-md-3']])->textInput(["value"=> date('Y-m-d H:i:s',isset($model['created_at'])?$model['created_at']:time())])->label("时间 ") ?>

    <?= $form->field($model, 'post_hits',['options'=>['class'=>'col-md-3'],'inputOptions'=>['style'=>'width:80%','class'=>'form-control']])->textInput()->label("访问 ") ?>
    <?= $form->field($model, 'post_title')->textInput()->label("页面标题") ?>
    <?= $form->field($model, 'post_url_name')->textInput()->label("网址标题") ?>





    <?= $form->field($model, 'post_excerpt')->textarea(['rows' => 2])->label("文章简介") ?>



   <?= Markdowneditor::widget(['model' => $model, 'attribute' => 'post_content']) ?>



    <?= $form->field($model, 'post_pic')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
