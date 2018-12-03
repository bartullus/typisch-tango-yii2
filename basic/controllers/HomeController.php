<?php
namespace app\controllers;
/**
 * Description of HomeController
 *
 * @author herbert
 */

use Yii;
use app\extensions\ttcontroller\TtController;

class HomeController 
	extends TtController
{

	public function actionIndex() {
		$this->redirect(array('start'), true, 301);
	}

	public function actionStart() {
		return $this->render('start', array(), true);
	}	
	
}
