<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
	'id' => 'basic',
	'name' => 'Tango Argentino e.V. Erfurt',
	'homeUrl' => array('/start'),
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],

	'modules' => [
		'blog' => [
			'class' => 'app\modules\blog\Module',
			'class' => 'app\modules\map\Module',
		],
	],     

	'components' => [
			
		'db' => $db,
		
		'request' => [
			'cookieValidationKey' => 'AQDeuxmBosIeh9iG5p-CW9-6gdk147r1',
    ],
     
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'db' => 'db',
			'cache' => 'cache',
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
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
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
        
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
				
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\DbMessageSource',
				],
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
