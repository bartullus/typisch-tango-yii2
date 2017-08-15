<?php
namespace app\extensions\menus;

/**
 * Description of AssetMenu
 *
 * @author herbert
 */

class AssetMenu 
	extends \yii\web\AssetBundle
{
	public $sourcePath = '@app/extensions/menus/assets'; 

	public $css = [ 
		'css/mainmenu.css',
		'css/usermenu.css',
	];
 
}
