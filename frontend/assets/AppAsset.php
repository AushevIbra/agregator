<?php

namespace frontend\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl  = '@web';
	public $css      = [
		'https://fonts.googleapis.com/icon?family=Material+Icons',
		'css/materialize.min.css'
	];
	public $js       = [
//		'js/lazyload.js',
//		'js/materialize.min.js',
//		'js/main.js',
		//		'js/jquery.min.js',
		//		'js/bootstrap.min.js'


	];
	public $depends  = [
//		BootstrapAsset::class,
	];
}
