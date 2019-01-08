<?php
namespace app\extensions\ttapplication;

use Yii;

/**
 * Description of TtApplication
 *
 * @author herbert
 */

class TtApplication 
	extends \yii\web\Application
{
	
	static function checkAccess($controller, $action){
	
		//Yii::log("checkAccess [$controller->id/$action->id]", 'info');
		
		$accessId = $controller->getAccessId($action);

		//$user = Yii::app()->user;
		//Yii::log("TtApplication::checkAccess [$accessId] guest=[".$user->isGuest."]");
		$user = Yii::$app->user;
		
		if ($user->checkAccess($accessId)) {
			return true;
		}

		if ($user->isGuest) {
			
			//throw new CHttpException(403, "You are not authorized for this page [$accessId]"); 
			if (YII_DEBUG) {
				Yii::error("login needed for page [".$accessId."]", 'info');
			}
			$user->setFlash('error', "Für den Zugriff auf diese Seite ist ein Login erforderlich [$accessId]");
			$controller->redirect(array('/intern/login', 'redirect' => Yii::$app->request->url));
			
		} else {

			if (YII_DEBUG) {
				Yii::error("insufficiant rights for page [".$accessId."]", 'info');
			}
			$user->setFlash('error', "Für den Zugriff auf diese Seite sind deine Rechte nicht ausreichend [$accessId]");
			$controller->redirect(array('/intern/error'));			
		}
	}

}
