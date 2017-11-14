<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'assetsAutoCompress'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'assetsAutoCompress' =>
            [
                'class'                         => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
                'enabled'                       => true,
                'readFileTimeout'               => 3,
                'jsCompress'                    => true,
                'jsCompressFlaggedComments'     => true,
                'cssCompress'                   => true,
                'cssFileCompile'                => true,
                'cssFileRemouteCompile'         => false,
                'cssFileCompress'               => true,
                'cssFileBottom'                 => false,
                'cssFileBottomLoadOnJs'         => false,
                'jsFileCompile'                 => true,
                'jsFileRemouteCompile'          => false,
                'jsFileCompress'                => true,
                'jsFileCompressFlaggedComments' => true,
                'htmlCompress'                  => true,
                'noIncludeJsFilesOnPjax'        => true,
                'htmlCompressOptions'           =>
                    [
                        'extra' => false,
                        'no-comments' => true
                    ],
            ],
        'assetManager' => [
            'linkAssets' => false,
            'appendTimestamp' => true,
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'less' => ['css', 'lessc {from} {to} --no-color'],
                    'ts' => ['js', 'tsc --out {to} {from}'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,

    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
        ],
        'clean-vendors' => [
            'class' => 'mbrowniebytes\yii2cleanvendors\CleanVendorsController',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
