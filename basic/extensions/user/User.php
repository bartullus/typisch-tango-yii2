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
		$identity = Yii::$app->user->identity;
		if (!isset($identity)) {
			return "";
		}
		return $identity->username;
	}

	/*public function getName()
	{
		return Yii::$app->user->identity->name;
	}*/

	public function getLastLoginTime()
	{
		$identity = Yii::$app->user->identity;
		if (!isset($identity)) {
			return "";
		}
		return $identity->last_login_time;
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
		if (!isset($identity)) {
			return "";
		}
		
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

	function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		// TODO: check if user has access to this route
		return true;
	}
}
