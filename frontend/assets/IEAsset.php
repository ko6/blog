<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author koko <kokostudio@qq.com>
 */
class IEAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/js';
    public $js = [
        'jquery-1.9.1.js',
    ];
    public $jsOptions = ['condition' => 'lte IE 9'];
}
