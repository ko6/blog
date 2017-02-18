<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'comment_id') ?>

    <?= $form->field($model, 'comment_father_id') ?>

    <?= $form->field($model, 'comment_post_id') ?>

    <?= $form->field($model, 'comment_status') ?>

    <?= $form->field($model, 'comment_name') ?>

    <?php // echo $form->field($model, 'comment_link_id') ?>

    <?php // echo $form->field($model, 'comment_email') ?>

    <?php // echo $form->field($model, 'comment_content') ?>

    <?php // echo $form->field($model, 'comment_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
