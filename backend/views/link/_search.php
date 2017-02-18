<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LinkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="link-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'link_id') ?>

    <?= $form->field($model, 'link_url') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'link_status') ?>

    <?= $form->field($model, 'link_hits') ?>

    <?php // echo $form->field($model, 'link_remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
