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
		/*** {{%admin_auth_rule}}                                        ***/
		/*******************************************************************/

		$this->createTable($authManager->ruleTable, [
				
			'id'          => $this->primaryKey(),
			'name'        => $this->string(64)->notNull(),
			'data'        => $this->binary(),
			'created_at'  => $this->integer(),
			'updated_at'  => $this->integer(),

			'create_time'    => $this->datetime(),
			'create_user_id' => $this->integer(),
			'update_time'    => $this->datetime(),
			'update_user_id' => $this->integer(),
				
			//'PRIMARY KEY ([[name]])',
		], $tableOptions);

		$this->createIndex('idx-admin_auth_rule-name', 
				$authManager->ruleTable, 
				'name',
				true);

		/*******************************************************************/
		/*** {{%admin_auth_item}}                                        ***/
		/*******************************************************************/

		$this->createTable($authManager->itemTable, [
				
			'id'          => $this->primaryKey(),
			'name'        => $this->string(64)->notNull(),
			'type'        => $this->smallInteger()->notNull(),
			'description' => $this->text(),
			'rule_name'   => $this->string(64),
			'data'        => $this->binary(),
			'created_at'  => $this->integer(),
			'updated_at'  => $this->integer(),

			'create_time'    => $this->datetime(),
			'create_user_id' => $this->integer(),
			'update_time'    => $this->datetime(),
			'update_user_id' => $this->integer(),
	
			//'PRIMARY KEY ([[name]])',
			//'FOREIGN KEY ([[rule_name]]) REFERENCES ' . $authManager->ruleTable . ' ([[name]])'.
			//	$this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE')
		], $tableOptions);
    
		$this->createIndex('idx-admin_auth_item-name', 
				$authManager->itemTable, 
				'name',
				true);
		$this->createIndex('idx-admin_auth_item-type', 
				$authManager->itemTable, 
				'type');

		$this->addForeignKey('fk-admin_auth_item-rule_name',
			$authManager->itemTable, 'rule_name',
			$authManager->ruleTable, 'name',
			'SET NULL', // ON DELETE
			'CASCADE' // ON UPDATE
		);

		/*******************************************************************/
		/*** {{%admin_auth_item_child}}                                  ***/
		/*******************************************************************/

		$this->createTable($authManager->itemChildTable, [
				
			'id'             => $this->primaryKey(),
			'parent'         => $this->string(64)->notNull(),
			'child'          => $this->string(64)->notNull(),
	
			'create_time'    => $this->datetime(),
			'create_user_id' => $this->integer(),
			'update_time'    => $this->datetime(),
			'update_user_id' => $this->integer(),

			// 'PRIMARY KEY ([[parent]], [[child]])',
			//'FOREIGN KEY ([[parent]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])'.
			//	$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
			//'FOREIGN KEY ([[child]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])'.
			//	$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
			], $tableOptions);

		$this->addForeignKey('fk-admin_auth_item_child-parent',
			$authManager->itemChildTable, 'parent',
			$authManager->itemTable, 'name',
			'CASCADE', // ON DELETE
			'CASCADE' // ON UPDATE
		);

		$this->addForeignKey('fk-admin_auth_item_child-child',
			$authManager->itemChildTable, 'child',
			$authManager->itemTable, 'name',
			'CASCADE', // ON DELETE
			'CASCADE' // ON UPDATE
		);
	
		/*******************************************************************/
		/*** {{%admin_auth_assignment}}                                  ***/
		/*******************************************************************/

		$this->createTable($authManager->assignmentTable, [
				
			'id'             => $this->primaryKey(),
			'item_name'      => $this->string(64)->notNull(),
			//'user_id'        => $this->string(64)->notNull(),
			'user_id'        => $this->integer(),
			'created_at'     => $this->integer(),

			'create_time'    => $this->datetime(),
			'create_user_id' => $this->integer(),
			'update_time'    => $this->datetime(),
			'update_user_id' => $this->integer(),

			//'PRIMARY KEY ([[item_name]], [[user_id]])',
			//'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
			//	$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
		], $tableOptions);

		$this->createIndex('idx-admin_auth_assgnment-item_name-user_id', 
				$authManager->assignmentTable, 
				['item_name', 'user_id'],
				true); // unique
		
		$this->addForeignKey('fk-admin_auth_assignment-item_name',
			$authManager->assignmentTable, 'item_name',
			$authManager->itemTable, 'name',
			'CASCADE', // ON DELETE
			'CASCADE' // ON UPDATE
		);

		$this->addForeignKey('fk-admin_auth_assignment-user_id',
			$authManager->assignmentTable, 'user_id',
			'{{%base_user}}', 'id',
			'CASCADE', // ON DELETE
			'CASCADE' // ON UPDATE
		);


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
