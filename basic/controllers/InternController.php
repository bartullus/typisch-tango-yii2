<?php
namespace app\controllers;
/**
 * Description of InternController
 *
 * @author herbert
 */

use Yii;
use app\extensions\ttcontroller\TtController;
use app\models\LoginForm;

class InternController 
	extends TtController
{
	
	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) 
		{
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) 
		{
			return $this->goBack();
		}
        
		return $this->render('login', [
			'model' => $model,
    ]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}
	
	function getRights() {

		/*
		$right_list = array();
		$user_id = Yii::app()->user->getId();
		$user = User::model()->findByPk($user_id);
		foreach($user->Rights as $right) {
			$right_list[] = $right->itemname;
		}
		$rights = implode(', ', $right_list);
		return $rights;
		 */
	}


}
