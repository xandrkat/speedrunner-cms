<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'backend\modules\User\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 4 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'sourcePath' => null,
//                    'basePath' => '@webroot',
//                    'baseUrl' => '@web',
//                    'js' => [
//                        'js/jquery.min.js',
//                    ]
//                ],
//                'yii\bootstrap\BootstrapPluginAsset' => [
//                    'sourcePath' => null,
//                    'basePath' => '@webroot',
//                    'baseUrl' => '@web',
//                    'js' => [
//                        'js/bootstrap.min.js',
//                    ]
//                ],
//                'yii\bootstrap\BootstrapAsset' => [
//                    'sourcePath' => null,
//                    'basePath' => '@webroot',
//                    'baseUrl' => '@web',
//                    'css' => [
//                        'css/bootstrap.min.css',
//                    ]
//                ],
            ],
        ],
    ],
    'params' => $params,
];
