<?php
namespace app\extensions\ttwidget;

use Yii;
use yii\helpers\Html;

/**
 * Description of SystemHint
 *
 * @author herbert
 */

class SystemHint 
	extends \app\extensions\ttwidget\TtWidget
{
	
	public function run() {
		
		$hint = Yii::$app->params['systemHint'];
		if (isset($hint)) {
			
			echo Html::tag('div', $hint, array('id' => 'systemhint'));
		}
	}
}
