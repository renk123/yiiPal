<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/../../vendor/yiipal/yii2-cck/config.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'cck' => [
            'class' => 'yiipal\cck\Module',
		],
        'node' => [
            'class' => 'yiipal\node\Module',
        ],
        'system' => [
            'class' => 'yiipal\system\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
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
    ],
    'params' => $params,
    'aliases' => [
        '@yiipal/base' => '@vendor/yiipal/yii2-base',
        '@yiipal/cck' => '@vendor/yiipal/yii2-cck',
        '@yiipal/cck/text' => '@vendor/yiipal/yii2-cck/text',
    ]
];
