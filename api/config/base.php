<?php

return [
	'id'         => 'api',
	'basePath'   => dirname(__DIR__),
	'components' => [
		'urlManager' => require(__DIR__ . '/urlManager.php'),
		'request'    => [
			'baseUrl' => '/api/web',
		],
	],
];
