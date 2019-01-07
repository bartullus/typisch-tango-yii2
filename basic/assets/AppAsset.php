<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Assets for the complete application
 * @author herbert
 * @since 2.0
 */

class AppAsset 
	extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		['css/default.css', 'media' => 'screen'],
		['css/print.css', 'media' => 'print'],
	];

	public $js = [
		'js/base64.js',
		'js/linkaction_base64.js',			
	];

	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
