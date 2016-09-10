<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'site_name') ?>

    <?= $form->field($model, 'site_url') ?>

    <?= $form->field($model, 'site_keyword') ?>

    <?= $form->field($model, 'site_descript') ?>

    <?= $form->field($model, 'site_subtitle') ?>

    <?php // echo $form->field($model, 'site_bottom') ?>

    <?php // echo $form->field($model, 'site_logo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
