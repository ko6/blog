<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tips */

$this->title = 'Create Tips';
$this->params['breadcrumbs'][] = ['label' => 'Tips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tips-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
