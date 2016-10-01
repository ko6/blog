<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SiteInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Site Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Site Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'site_info_id',
            'site_name',
            'site_url:url',
            'site_keywords',
            'site_description',
            // 'site_subtitle',
            // 'site_bottom:ntext',
            // 'site_logo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
