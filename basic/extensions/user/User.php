<?php
namespace app\extensions\user;

use Yii;

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
		return Yii::$app->user->identity->username;
	}

	/*public function getName()
	{
		return Yii::$app->user->identity->name;
	}*/

	public function getLastLoginTime()
	{
		return Yii::$app->user->identity->last_login_time;
	}

	public function getLastLoginTimeFormat()
	{
		$login_time = $this->getLastLoginTime();
		if (isset($login_time)) {
			return null;
		}
		
		$login_time_num = strtotime($login_time);
		return strftime('%d.%m.%Y %H:%M:%S', $login_time_num);
	}
	
	function getRights() {

		Yii::info('+ User::getRights()');
		$identity = Yii::$app->user->identity;
		
		$rightsList = array();
		$rights = $identity->getRights()->all();
		Yii::info('Rights: '.var_export($rights, true));
		foreach($rights as $right) {
			$rightsList[] = $right->item_name;
		}
		$rightsStr = implode(', ', $rightsList);
		Yii::info('- User::getRights() rightsStr: '.$rightsStr);
		return $rightsStr;		
	}

}
