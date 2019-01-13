<?php
namespace app\extensions\table;

/**
 * Description of AssetTable
 *
 * @author herbert
 */

class AssetTable 
	extends \yii\web\AssetBundle
{
	public $sourcePath = '@app/extensions/table/assets'; 

	public $css = [ 
		'css/ModelTableWidget.css',
	]; 
}
