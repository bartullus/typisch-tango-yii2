<?php

namespace app\migrations;

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m181129_204149_auth 
	extends Migration
{
	public function safeUp()
	{
		$authManager = $this->getAuthManager();
		$this->db = $authManager->db;

		
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

		/*******************************************************************/
		/*** {{%auth_rule}}                                              ***/
		/*******************************************************************/

		$this->createTable($authManager->ruleTable, [
			'name' => $this->string(64)->notNull(),
			'data' => $this->binary(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'PRIMARY KEY ([[name]])',
		], $tableOptions);

		/*******************************************************************/
		/*** {{%auth_item}}                                              ***/
		/*******************************************************************/

		$this->createTable($authManager->itemTable, [
			'name' => $this->string(64)->notNull(),
			'type' => $this->smallInteger()->notNull(),
			'description' => $this->text(),
			'rule_name' => $this->string(64),
			'data' => $this->binary(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'PRIMARY KEY ([[name]])',
			'FOREIGN KEY ([[rule_name]]) REFERENCES ' . $authManager->ruleTable . ' ([[name]])'.
				$this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE')
		], $tableOptions);
    
		$this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

		/*******************************************************************/
		/*** {{%auth_item_child}}                                        ***/
		/*******************************************************************/

		$this->createTable($authManager->itemChildTable, [
			'parent' => $this->string(64)->notNull(),
			'child' => $this->string(64)->notNull(),
			'PRIMARY KEY ([[parent]], [[child]])',
			'FOREIGN KEY ([[parent]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])'.
				$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
			'FOREIGN KEY ([[child]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])'.
				$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
			], $tableOptions);
		
		/*******************************************************************/
		/*** {{%auth_assignment}}                                        ***/
		/*******************************************************************/

		$this->createTable($authManager->assignmentTable, [
			'item_name' => $this->string(64)->notNull(),
			'user_id' => $this->string(64)->notNull(),
			'created_at' => $this->integer(),
			'PRIMARY KEY ([[item_name]], [[user_id]])',
			'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
				$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
		], $tableOptions);

		/*******************************************************************/

		return true;
	}

	public function safeDown()
	{
		$authManager = $this->getAuthManager();
		$this->db = $authManager->db;

		$this->dropTable($authManager->assignmentTable);
		$this->dropTable($authManager->itemChildTable);
		$this->dropTable($authManager->itemTable);
		$this->dropTable($authManager->ruleTable);

		return true;
	}

	/**
	 * @throws yii\base\InvalidConfigException
	 * @return DbManager
	 */
	protected function getAuthManager()
	{
		$authManager = \Yii::$app->getAuthManager();
		if (!$authManager instanceof DbManager) 
		{
			throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
		}
		return $authManager;
	}

  /**
   * @return string
   */
	protected function buildFkClause($delete = '', $update = '')
	{
		if ($this->isMSSQL()) {
			return '';
		}

		if ($this->isOracle()) {
			return ' ' . $delete;
		}

		return implode(' ', ['', $delete, $update]);
	}

  /**
   * @return bool
   */
	protected function isMSSQL()
	{
		return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
	}

  /**
   * @return bool
   */
	protected function isOracle()
	{
		return $this->db->driverName === 'oci';
	}

}
