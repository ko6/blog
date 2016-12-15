<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\PostCategory;
use ijackua\lepture\Markdowneditor;
use ijackua\lepture\MarkdowneditorAssets;
use backend\assets\PostEditAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */

PostEditAsset::register($this);

$model->post_content_type == "" && $model->post_content_type = 1; //初始化编辑器类型，默认指定为富文本编辑器
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
'fieldConfig'=>['labelOptions'=>['style'=>'float:left;padding:7px;width:10%;'],'inputOptions'=>['style'=>'width:80%','class'=>'form-control']]
    ]); ?>

    <?= $form->field($model, 'post_category',['options'=>['class'=>'col-md-3'],'labelOptions'=>['style'=>'float:left;padding:7px;width:25%;'],'inputOptions'=>['style'=>'width:70%'] ])->dropdownlist(PostCategory::get_post_category()) ?>

    <?= $form->field($model, 'post_status',['options'=>['class'=>'col-md-3'],'labelOptions'=>['style'=>'float:left;padding:7px;width:25%;'],'inputOptions'=>['style'=>'width:70%'] ])->dropdownlist([1=>'发布',2=>'草稿',0=>'审核'])->label("状态") ?>

    <?= $form->field($model, 'created_at',['options'=>['class'=>'col-md-3'],'labelOptions'=>['style'=>'float:left;padding:7px;width:25%;'],'inputOptions'=>['style'=>'width:70%'] ])->textInput(["value"=> date('Y-m-d H:i:s',isset($model['created_at'])?$model['created_at']:time())])->label("时间 ") ?>

    <?= $form->field($model, 'post_hits',['options'=>['class'=>'col-md-3'],'labelOptions'=>['style'=>'float:left;padding:7px;width:25%;'],'inputOptions'=>['style'=>'width:70%'] ])->textInput()->label("访问 ") ?>
    <?= $form->field($model, 'post_title')->textInput()->label("页面标题") ?>
    <?= $form->field($model, 'post_url_name',['inputOptions'=>['placeholder'=>'url名称，用作个性化文章网址']])->textInput()->label("网址标题") ?>


    <?= $form->field($model, 'post_keywords',['inputOptions'=>['placeholder'=>'页面关键字,英文逗号分隔']])->textInput(['maxlength' => true])->label('seo关键字') ?>


    <?= $form->field($model, 'post_excerpt')->textarea(['rows' => 2])->label("文章简介") ?>

    <?= $form->field($model, 'post_tips',['inputOptions'=>['placeholder'=>'文章标签，用|分隔']])->textInput(['maxlength' => true])->label('文章标签') ?>

    <?= $form->field($model, 'post_content_type')->radioList(['1' => '富文本编辑器','2'=>'Markdown编辑器'])->label('选择编辑器') ?>


    <?= $form->field($model, 'post_content_1',['options'=>['class'=>'hidden']])->widget('\kucha\ueditor\UEditor',[
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '400',

        ]])?>
   <?= Markdowneditor::widget(['model' => $model, 'attribute' => 'post_content_2']) ?>

    <?= $form->field($model, 'post_pic')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
