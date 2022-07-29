<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ExamCourse */

$this->title = 'Create Exam Course';
$this->params['breadcrumbs'][] = ['label' => 'Exam Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
