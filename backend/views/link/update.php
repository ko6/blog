<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Link */

$this->title = 'Update Link: ' . $model->link_id;
$this->params['breadcrumbs'][] = ['label' => 'Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->link_id, 'url' => ['view', 'id' => $model->link_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
