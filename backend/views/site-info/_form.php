<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'site_info_id')->textInput() ?>

    <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_descript')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_bottom')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'site_logo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
