<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('管理文章分类', ['/post-category'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'post_id',
            // 'post_author',
            // 'created_at',
            // 'updated_at',
            [
                'attribute' => 'post_title',
                'label' => '标题',
                'format' => 'raw',
                'value' => function($post){  return "<a title='发表: ".date('Y-m-d H:i:s',$post['created_at'])."  编辑：".date('Y-m-d H:i:s', $post['updated_at'])."&#13; $post[post_excerpt]'>$post[post_title]</a>";},
            ],
            'post_category',
            // 'post_excerpt:ntext',
            'post_hits',
            'post_status',
            // 'post_url_name:ntext',
            // 'post_content:ntext',
            // 'post_pic:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
