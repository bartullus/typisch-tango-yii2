<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
	'id' => 'basic',
	'name' => 'Tango Argentino e.V. Erfurt',
	'defaultRoute' => 'home/start',
	'homeUrl' => array('home/start'),
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
			'ruleTable' => "{{%admin_auth_rule}}",
			'itemTable' => "{{%admin_auth_item}}",
			'itemChildTable' => "{{%admin_auth_item_child}}",
			'assignmentTable' => "{{%admin_auth_assignment}}",
		],
			
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
    
		'user' => [
			'class' => 'app\extensions\user\User', // extend \yii\web\User component
			//'identityClass' => 'app\models\User',
			'identityClass' => 'app\models\BaseUser',
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
					'levels' => ['error'],
					'logFile' => '@runtime/logs/errors.log',
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['warning'],
					'logFile' => '@runtime/logs/warnings.log',
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'logFile' => '@runtime/logs/infos.log',
        ],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['trace'],
					'logFile' => '@runtime/logs/trace.log',
					'maxFileSize' => 10240,
					'maxLogFiles' => 5,
					'rotateByCopy' => true,
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
  
	'params' => array_merge($params, [
		'systemHint' => 'Testsystem lokal (YII 2.0)',		
	]),
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
