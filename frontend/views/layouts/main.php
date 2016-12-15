<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use backend\models\SiteInfo;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php
/* 设置页面seo信息 */
/* 设置keywords description 前先检测是否已配置，因yii默认先处理活动页面，此模板中的seo配置会覆盖掉活动页面中的个性化seo设置 */
/* 将站点标题追加到页面标题尾部 */
$site_info = SiteInfo::get_site_info();

    !isset($this->metaTags['keywords'])&&isset($site_info['site_keywords'])?$this->registerMetaTag(['name'=>"Keywords",'content'=>$site_info['site_keywords']],'keywords'):"" ;
    !isset($this->metaTags['description'])&&isset($site_info['site_description'])?$this->registerMetaTag(['name'=>"description",'content'=>$site_info['site_description']],'description'):"" ;
    isset($site_info['site_name'])?($this->title==""?$this->title=$site_info['site_name']:$this->title.=" - ".$site_info['site_name']):'';
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>


    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>   isset($site_info['site_name'])?$site_info['site_name'] : 'koko blog',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/']],
        // ['label' => 'About', 'url' => ['/site/about']],
        // ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    // if (Yii::$app->user->isGuest) {
    //     $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    //     $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    // } else {
    //     $menuItems[] = '<li>'
    //         . Html::beginForm(['/site/logout'], 'post')
    //         . Html::submitButton(
    //             'Logout (' . Yii::$app->user->identity->username . ')',
    //             ['class' => 'btn btn-link']
    //         )
    //         . Html::endForm()
    //         . '</li>';
    // }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= isset($site_info['site_bottom'])?$site_info['site_bottom']:"" ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
