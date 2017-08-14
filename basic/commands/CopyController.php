<?php
namespace app\commands;
/**
 * Copies data from old application with Yii 1 to new Yii 2 app
 *
 *
 * @author Herbert
 * @since 2.0
 */

use yii\console\Controller;

class CopyController 
	extends Controller
{
	var $db_old;
	var $dsn = 'mysql:host=localhost;dbname=typisch_tango_yii';
	var $username = 'root';
	var $password = 'asdfcv';
	var $charset = 'utf8';
	
	/**
	 * copies all objects
   */
  public function actionIndex()
	{
		$this->db_old = $this->openConnection();
		$this->copyTables();
		$this->db_old->close ();
  }
	
	/**
	 * open connection to old database
   */
	private function openConnection() {
					
		$db = new \yii\db\Connection([
			'dsn' => $this->dsn,
			'username' => $this->username,
			'password' => $this->password,
			'charset' => $this->charset,
		]);
		$db->open();		
		return $db;
	}
	
	/**
	 * copies the menus
   */
	protected function copyTables() 
	{

		$this->copyTable(
			'tt_user_group', '\app\models\BaseUserGroup',
			[
				'id', 'name', 'description',
			]
		);

		$this->copyTable(
			'tt_user', '\app\models\BaseUser',
			[
				'id', 'active', 'email', 
				'username', 'password', 'last_login_time',
			]
		);

		$this->copyTable(
			'tt_menu', '\app\models\BaseMenu',
			[
				'id', 'name', 'restricted', 'description',
			]
		);
		
		$this->copyTable(
			'tt_menu_item', '\app\models\BaseMenuItem',
			[
				'id', 'name', 'menu_id', 'parent_id',
				'icon', 'description', 'website', 'params',
				'subitems_controller', 'css_class', 'order', 'restricted',
				'visible', 'change_freq', 'in_sitemap'
			]
		);
	
	}
		
		
	private function copyTable($oldTableName, $newClassName, $fieldNames)
	{
		echo "Start Copy $oldTableName\r\n";
		
		$command = $this->db_old->createCommand("SELECT * FROM $oldTableName");
		$oldRecords = $command->queryAll();
		
		echo "\tCopy: ".count($oldRecords)."\r\n";
		//echo print_r($oldMenus, true);
		
		$newClass = new \ReflectionClass($newClassName);
		$deleteAllMethod = $newClass->getMethod('deleteAll');
		$deleteAllMethod->invoke(null);		
		
		foreach($oldRecords as $oldRec) {
			
			$newRec = $newClass->newInstance();
			$this->copyFields($newRec, $oldRec, $fieldNames);
		}
		
		$findMethod = $newClass->getMethod('find');
		$cnt = $findMethod->invoke(null)->count();
		echo "\tCopied: ".$cnt."\r\n";
		
		echo "End Copy $oldTableName\r\n";
	}
	
	private function copyFields($newRec, $oldRec, $fieldNames) {
		
		foreach ($fieldNames as $name)  {
			$newRec->$name = $oldRec[$name];
		}
		
		$newRecT = $this->copyTimestamp($newRec, $oldRec);
		$newRecT->save(false);
	}
	
	private function copyTimestamp($newRec, $oldRec) {
		
		$newRec->create_time    = $oldRec['create_time'];
		$newRec->create_user_id = $oldRec['create_user_id'];
		$newRec->update_time    = $oldRec['update_time'];
		$newRec->update_user_id = $oldRec['update_user_id'];
		return $newRec;
		
	}
}
