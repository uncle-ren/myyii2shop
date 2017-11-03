<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        "authManager"=>[
            "class"=> 'yii\rbac\DbManager',
        ],
        'urlManager'=>[
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
                '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' =>'<controller>/<action>',
                '<controller:(post|comment)>/<id:\d+>' => '<controller>/read',
                '<controller:(post|comment)>s' => '<controller>/list',
            ],
        ],
    ],
];
