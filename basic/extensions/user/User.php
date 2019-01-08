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
	private $_checkAccess=array();	
	
	public function getId()
	{
		$identity = Yii::$app->user->identity;
		if (!isset($identity)) {
			return null;
		}
		return $identity->getId();
	}

	public function getUsername()
	{
		$identity = Yii::$app->user->identity;
		if (!isset($identity)) {
			return "";
		}
		return $identity->getUsername();
	}

	public function getLastLoginTime()
	{
		$identity = Yii::$app->user->identity;
		if (!isset($identity)) {
			return null;
		}
		return $identity->getLastLoginTime();
	}

	public function getLastLoginTimeFormat()
	{
		$login_time = $this->getLastLoginTime();
		if (isset($login_time)) {
			return "";
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

	function checkAccess($operation, $params = array(), $allowCaching = true)
	{
		if($allowCaching && 
			 $params === array() && 
			 isset($this->_checkAccess[$operation]))
		{
			return $this->_checkAccess[$operation];
		}
		
		$id = $this->getId();
		Yii::info('+ User::checkAccess(id: '.$id.', op: '.$operation.')');
		$authManager = Yii::$app->getAuthManager();
		$access = $authManager->checkAccess($id, $operation, $params);
		if($allowCaching && 
			 $params === array())
		{
			$this->_checkAccess[$operation]=$access;
		}
		
		Yii::info('- User::checkAccess() access: '.$access);
		return $access;
	}
}
