<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Tips;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TipsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tips';
$this->params['breadcrumbs'][] = $this->title;
Tips::set_tips(['新标签12'],["test4","test","test55"]);
echo('test2=');
print_r(Tips::find_tip('test2',false));
?>
<div class="tips-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tips', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'count',
            'status',
            'remark:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
