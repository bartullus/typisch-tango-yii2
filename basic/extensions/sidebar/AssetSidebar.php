<?php
namespace app\extensions\sidebar;

/**
 * Description of AssetSidebar
 *
 * @author herbert
 */

class AssetSidebar 
	extends \yii\web\AssetBundle
{
	public $sourcePath = '@app/extensions/sidebar/assets'; 

	public $css = [ 
		'css/metisMenu.css',
		'css/font-awesome.css',
		'css/sb-admin-2.css',
	];
	
	public $js = [ 
		'js/metisMenu.js',
		'js/sb-admin-2.js',
	];
 
}
