<?php
namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\extensions\ttcontroller\TtController;
use app\models\LoginForm;

/**
 * Description of InternController
 *
 * @author herbert
 */

class InternController 
	extends TtController
{
	public $layout='admin';
	
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

		$this->layout = 'main';
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) 
		{
			//return $this->goBack();
			return $this->goIndex();
		}
        
		return $this->render('login', [
			'model' => $model,
    ]);
	}

	public function goIndex()
	{
		$route = Url::toRoute('/intern/index');
		return Yii::$app->getResponse()->redirect($route);
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
		return $this->render('index', [
				'rights' => Yii::$app->user->getRights(),
		]);
	}
	
}
