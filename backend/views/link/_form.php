<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Link */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'link_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'link_status')->textInput() ?>

    <?= $form->field($model, 'link_hits')->textInput() ?>

    <?= $form->field($model, 'link_remark')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
