<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>




    <?= $form->field($model, 'comment_name',['options'=>['class'=>'col-xs-4']])->textInput(['maxlength' => true])->label('你的名字') ?>

    <?= $form->field($model, 'comment_link_id',['options'=>['class'=>'col-xs-4']])->textInput()->label('你的主页') ?>

    <?= $form->field($model, 'comment_email',['options'=>['class'=>'col-xs-4']])->textInput(['maxlength' => true])->label('你的邮箱') ?>

    <?= $form->field($model, 'comment_content',['options'=>['class'=>'col-xs-12']])->textarea(['rows' => 3])->label('你的评论') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
