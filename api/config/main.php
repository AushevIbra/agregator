<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id'                  => 'app-api',
	'basePath'            => dirname(__DIR__),
	'bootstrap'           => ['log'],
	'controllerNamespace' => 'api\controllers',
	'aliases'             => [
		'@storageRoot' => $params['storagePath'],
		'@storage'     => $params['storageHostInfo'],
	],
	'components'          => [
		'user' => [
			'identityClass'   => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie'  => ['name' => '_identity-api', 'httpOnly' => true],
		],

		'request' => [
			'cookieValidationKey' => 'h0WOyZ4S1t5tz25Co-kahK0BofbSQ983',
			'parsers'             => [
				'application/json' => 'yii\web\JsonParser',
			],
		],

		'errorHandler' => [
			'errorAction' => 'site/error',
		],

		'urlManager' => [

			'enablePrettyUrl' => true,
			'showScriptName'  => false,
			'rules'           => [
				'restaurants' => 'v1/restaurants/view',
			],
		],


		'authManager' => [
			'class' => \yii\rbac\DbManager::class,
		],


	],
	'modules'             => [
		'v1' => [
			'class' => 'app\modules\v1\Module',
		],
	],
	'params'              => $params,
];
