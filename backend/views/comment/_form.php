<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment_father_id')->textInput() ?>

    <?= $form->field($model, 'comment_post_id')->textInput() ?>

    <?= $form->field($model, 'comment_status')->textInput() ?>

    <?= $form->field($model, 'comment_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_link_id')->textInput() ?>

    <?= $form->field($model, 'comment_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comment_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
