<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tips */

$this->title = 'Update Tips: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tips-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
