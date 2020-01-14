<?php

namespace backend\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	/** @var string */
	public $sourcePath = '@backend/assets/BackendAsset';

	public $css     = [
		'https://use.fontawesome.com/releases/v5.7.0/css/all.css',
		'css/site.css',
//		'css/bootstrap.min.css',
		'css/mdb.min.css',
	];
	public $js      = [
//		'js/jquery-3.3.1.min.js',
		'js/bootstrap.js',
		'js/popper.min.js',
		'js/mdb.min.js',
//		'js/yii.js',
//		'js/yii.activeForm.js',
//		'js/yii.captcha.js',
//		'js/yii.gridView.js',
//		'js/yii.validation.js',


	];
	public $depends = [
	];

	public $publishOptions = [
		'forceCopy' => true,
	];
}
