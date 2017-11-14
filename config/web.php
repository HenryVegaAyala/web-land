<?php
use yii\helpers\Url;
use \yii\web\Request;
use himiklab\sitemap\behaviors\SitemapBehavior;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'assetsAutoCompress'],
    'sourceLanguage' => 'es',
    'language' => 'es',
    'timeZone' => 'America/Lima',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
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
            'bundles' => false,
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
        'request' => [
            'baseUrl' => str_replace('/frontend/web', '', (new Request)->getBaseUrl()),
            'cookieValidationKey' => 'c2asR6ZZmOYm5NgjEp-cyxP6cfN0vVTV',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'site/index',
                ['pattern' => 'robots', 'route' => 'robotsTxt/web/index', 'suffix' => '.txt'],
                ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
            ],
        ],
    ],
    'modules' => [
        'robotsTxt' => [
            'class' => 'execut\robotsTxt\Module',
            'components' => [
                'generator' => [
                    'class' => \execut\robotsTxt\Generator::class,
                    'host' => 'localhost',
                    'sitemap' => 'sitemap.xml',
                    'sitemap' => [
                        'sitemapModule/sitemapController/sitemapAction',
                    ],
                    'userAgent' => [
                        '*' => [
                            'Disallow' => [
                                'noIndexedHtmlFile.html',
                                [
                                    'notIndexedModule/noIndexedController/noIndexedAction',
                                    'noIndexedActionParam' => 'noIndexedActionParamValue',
                                ],
                            ],
                            'Allow' => [
                                //..
                            ],
                        ],
                        'BingBot' => [
                            'Sitemap' => '/sitemapSpecialForBing.xml',
                            'Disallow' => [
                                //..
                            ],
                            'Allow' => [
                                //..
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                'app\modules\news\models\News',
                [
                    'class' => 'app\modules\news\models\News',
                    'behaviors' => [
                        'sitemap' => [
                            'class' => SitemapBehavior::className(),
                            'scope' => function ($model) {
                                $model->select(['url', 'lastmod']);
                                $model->andWhere(['is_deleted' => 0]);
                            },
                            'dataClosure' => function ($model) {
                                return [
                                    'loc' => Url::to($model->url, true),
                                    'lastmod' => strtotime($model->lastmod),
                                    'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                                    'priority' => 0.8,
                                ];
                            },
                        ],
                    ],
                ],
            ],
            'urls' => [
                [
                    'loc' => '/news/index',
                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8,
                    'news' => [
                        'publication' => [
                            'name' => 'Eqatu',
                            'language' => 'en',
                        ],
                        'access' => 'Landing',
                        'genres' => 'EQATU integra diferentes MYPES',
                        'publication_date' => 'YYYY-MM-DDThh:mm:ssTZD',
                        'title' => 'Eqatu',
                        'keywords' => 'compra online, comprar en peru, venta por internet, comprar por internet, compra online en lima, compra por internet',
                        'stock_tickers' => 'NASDAQ:A, NASDAQ:B',
                    ],
                    'images' => [
                        [
                            'loc' => 'http://example.com/image.jpg',
                            'caption' => 'EQATU integra diferentes MYPES en una plataforma virtual, creando una nueva experiencia de compra fácil,segura y rápida',
                            'geo_location' => 'Limaa, Lima, Perú',
                            'title' => 'EQATU compra fácil,segura y rápida',
                            'license' => 'http://example.com/license',
                        ],
                    ],
                ],
            ],
            'enableGzip' => true,
            'cacheExpire' => 1,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
