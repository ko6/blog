<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteInfo */

$this->title = 'Update Site Info: ' . $model->site_name;
$this->params['breadcrumbs'][] = ['label' => 'Site Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->site_name, 'url' => ['view', 'id' => $model->site_name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="site-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
