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
		$params = [
				'event_valid' => 1,
				'category_id' => 6,
		];
		$events = \app\modules\cal\models\CalendarEvent::find()
						->with('updater')
						->where(['event_valid' => 1])
						->andWhere(['<>', 'category_id', 6])
						->andWhere(['<>', 'category_id', 8])
						->orderBy(['update_time' => 'DESC'])
						->limit(5)
						->all();
		
		return $this->render('index', [
				'rights' => Yii::$app->user->getRights(),
				'events' => $events,
		]);
	}
	
	function getModelTableButtons($model, $options) {
		
		if (get_class($model) == "CalendarEvent") {
			
			$updateRoute = '/cal/calendar/update';
			$deleteRoute = '/cal/calender/remove';
			
		} else if (get_class($model) == "CalendarLocation") {
			
			$updateRoute = '/cal/location/update';
			$deleteRoute = '/cal/location/remove';

		} else if (get_class($model) == "Article") {
			
			$updateRoute = '/blog/article/update';
			$deleteRoute = '/blog/article/delete';
		
		} else if (get_class($model) == "StartpagePic") {
			
			$updateRoute = '/startpagePic/update';
			$deleteRoute = '/startpagePic/delete';
		}
		
		$r = new \app\extensions\buttons\LinkButton([
				'name' => 'update_'.$model->id,
				'title' => "Bearbeiten",
				'target' => array($updateRoute, 'id' => $model->id),
				'icon' => 'icon-pencil',
		]);
		
		$r.= new \app\extensions\buttons\DeleteButton([
				'name' => 'delete_'.$model->id,
				'title' => "Löschen",
				'target' => array($deleteRoute, 'id' => $model->id),
				'message' => "Id=[$model->id] Name='".$model->getName()."' <br/>Diesen Eintrag wirklich löschen?",
		]);
		
		return $r;
	}
	
	/**
	 * additional parameters for model table columns
	 */
	public function attributeParams($attrName, $model, $options) {
		
		if (get_class($model) == "CalendarEvent") {
			switch($attrName) {
				case 'title':
					return array('viewRoute' => 'cal/calendar/viewIntern');
				
				case 'location_id':
					return array('viewRoute' => 'cal/location/viewIntern');

				case 'date':
					return array(
							'viewRoute' => '/cal/calendar/day',
							'today' => $this->getToday(),
					);
			}				
		}
		
		if (get_class($model) == "CalendarLocation") {
			switch($attrName) {
				case 'name':
					return array('viewRoute' => 'cal/location/viewIntern');

				case 'city_id':
					return array('viewRoute' => 'map/mapCity/viewIntern');					
			}
		}
		
		if (get_class($model) == "Article") {
			switch($attrName) {
				case 'title':
					return array('viewRoute' => 'blog/article/viewIntern');				
			}
		}
		
		if (get_class($model) == "StartpagePic") {
			switch($attrName) {
				case 'picture_id':
					return array(
							'viewRoute' => 'startpagePic/view',
							'pictureRoute' => '/picture/draw',
							);
			}
		}
		
		return parent::attributeParams($attrName, $model, $options);
	}

}
