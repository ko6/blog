<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap'    => ['assetsAutoCompress'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
          'a/<id:.*>' => 'site/a',
          't/<id:.*>' => 'site/t',
          'c/<id:.*>' => 'site/c',
          // '/<id:.*>' => 'site',
            ]
        ],




    ],

];
