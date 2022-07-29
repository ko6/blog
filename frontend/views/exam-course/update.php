<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ExamCourse */

$this->title = 'Update Exam Course: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exam Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exam-course-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
