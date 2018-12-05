<?php
namespace app\extensions\ttwidget;
/**
 * Description of Flash Display
 *
 * @author herbert
 */

use Yii;
//use yii\helpers\Html;
use yii\bootstrap\Alert;

class FlashDisplay 
	extends \app\extensions\ttwidget\TtWidget
{
	
	public function run() {
		
		// display flash messages
		$flashes = Yii::$app->session->getAllFlashes();
		foreach($flashes as $key => $message) {
			
			//echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			$class = 'alert alert-'.$key;
			
			//echo Html::alert($color, $message);
			return Alert::widget([
				'options' => ['class' => $class ],
				'body' => $message,
			]);
		}
		
		if (count($flashes) == 0) {
			return '<!-- no flashes -->';
		}
	}
}

