<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\PostCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'created_at')->textInput() ?>


    <?= $form->field($model, 'post_title')->textInput() ?>

    <?= $form->field($model, 'post_category')->dropdownlist(PostCategory::get_post_category()) ?>

    <?= $form->field($model, 'post_excerpt')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'post_status')->dropdownlist([1=>'发布',2=>'草稿',0=>'审核']) ?>

    <?= $form->field($model, 'post_url_name')->textInput() ?>

    <?= $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_hits')->textInput() ?>

    <?= $form->field($model, 'post_pic')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
