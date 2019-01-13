<?php
namespace app\extensions\ttwidget;

use Yii;
use yii\bootstrap\Alert;

/**
 * Description of Flash Display
 *
 * @author herbert
 */

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

