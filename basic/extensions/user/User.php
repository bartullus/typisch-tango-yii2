<?php
namespace app\extensions\user;
/**
 * Description of User
 *
 * @author herbert
 */

class User 
	extends \yii\web\User
{
	public function getUsername()
	{
		return \Yii::$app->user->identity->username;
	}

	public function getName()
	{
		return \Yii::$app->user->identity->name;
	}

	public function getLastLoginTime()
	{
		return \Yii::$app->user->identity->last_login_time;
	}
}
