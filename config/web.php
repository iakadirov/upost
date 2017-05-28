<?php

$params = require(__DIR__ . '/params.php');

$config = [
  'id' => 'basic',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'language' => 'ru-RU',
  'defaultRoute' => 'site/index',
  'modules' => [
    'aplledore' => [
      'class' => 'app\modules\aplledore\Module',
      'layout'=>'aplledore',
    ],
  ],
  'components' => [
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
    'request' => [
      'cookieValidationKey' => 'Vm3iaj6MBLDVyyFCJu8oLx5VLyUh7dWx',
      'baseUrl' => '',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'i18n' => [
      'translations' => [
        'app*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@app/messages',
          'fileMap' => [
            'app' => 'app.php',
          ],
        ],
        'idev*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@app/messages',
          'fileMap' => [
            'idev' => 'idev.php',
          ],
        ],
        // '*' => [
        //   'class' => 'yii\i18n\PhpMessageSource',
        //   'basePath' => '@common/messages',
        //   'fileMap' => [
        //       'app' => 'app.php',
        //   ],
        // ],
      ],
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
    'db' => require(__DIR__ . '/db.php'),
    
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        'login'=>'/site/login',
        'logout'=>'/site/logout',
        '/aplledore/news/page/<page:\d+>'=>'/aplledore/news/index',
        '/aplledore/news/edit/<id:\d+>'=>'/aplledore/news/edit',
        '/aplledore/news/delete/<id:\d+>'=>'/aplledore/news/delete',
        '/aplledore/news/authors/<id:\d+>'=>'/aplledore/news/authors',
        '/aplledore/news/authors/delete/<id:\d+>'=>'/aplledore/news/delete-author',
        '/aplledore/category/delete/<id:\d+>'=>'/aplledore/category/delete',
        '/aplledore/category/<id:\d+>'=>'/aplledore/category/index',
        '/aplledore/thema/delete/<id:\d+>'=>'/aplledore/thema/delete',
        '/aplledore/thema/<id:\d+>'=>'/aplledore/thema/index',
      ],
    ],
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];
}

return $config;
