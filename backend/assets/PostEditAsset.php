<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PostEditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'css/editor.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];

}
