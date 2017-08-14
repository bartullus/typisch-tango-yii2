<?php
namespace app\migrations;

/**
 * Description of m170813_222815_menus
 * 
 * Creates tables for menus
 *
 * @author herbert
 */
use yii\db\Migration;

class m170813_222815_menus extends Migration
{
	public function safeUp()
	{
		echo "migrate m170813_222815_menus.\n";

		$this->createTable('{{%base_user_group}}',[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull()->unique(),				
				'description'    => $this->text(),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-user_group-name', '{{%base_user_group}}', 'name');

		$this->createTable('{{%base_user}}',[
				'id'              => $this->primaryKey(),
				'active'          => $this->boolean()->defaultValue(1),
				'email'           => $this->string()->notNull()->unique(),
				
				'username'        => $this->string()->notNull(),
				'password'        => $this->string(),
				'last_login_time' => $this->datetime(),
				
				'create_time'     => $this->datetime(),
				'create_user_id'  => $this->integer(),
				'update_time'     => $this->datetime(),
				'update_user_id'  => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-user-email', '{{%base_user}}', 'email');
		$this->createIndex('idx-user-username', '{{%base_user}}', 'username');
				
		$this->createTable('{{%base_menu}}',[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull()->unique(),
				
				'restricted'     => $this->boolean()->notNull()->defaultValue(0),
				'description'    => $this->text(),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-menu-name', '{{%base_menu}}', 'name');

		$this->createTable('{{%base_menu_item}}',[
				'id'                  => $this->primaryKey(),
				'name'                => $this->string()->notNull(),
				'menu_id'             => $this->integer()->notNull(),
				'parent_id'           => $this->integer(),
				
				'icon'                => $this->string(64),
				'description'         => $this->text(),
				'website'             => $this->string(),
				'params'              => $this->string(),
				'subitems_controller' => $this->string(),
				'css_class'           => $this->string(),
				'order'               => $this->integer()->notNull()->defaultValue(1),
				'restricted'          => $this->boolean()->notNull()->defaultValue(0),
				'visible'             => $this->boolean()->notNull()->defaultValue(1),
				'change_freq'         => $this->string(16),
				'in_sitemap'          => $this->boolean()->notNull()->defaultValue(1),
				
				'create_time'         => $this->datetime(),
				'create_user_id'      => $this->integer(),
				'update_time'         => $this->datetime(),
				'update_user_id'      => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-menu_item-name', '{{%base_menu_item}}', 'name');
		$this->createIndex('idx-menu_item-menu_id', '{{%base_menu_item}}', 'menu_id');
		$this->createIndex('idx-menu_item-parent_id', '{{%base_menu_item}}', 'parent_id');
		
		$this->addForeignKey('fk-menu_item-menu_id',
			'{{%base_menu_item}}', 'menu_id',
			'{{%base_menu}}', 'id',
			'CASCADE'
		);
		
	}

	public function safeDown()
	{
		echo "revert m170813_222815_menus.\n";
	
		$this->dropTable('{{%base_menu_item}}');
		$this->dropTable('{{%base_menu}}');
		$this->dropTable('{{%base_user}}');
		$this->dropTable('{{%base_user_group}}');
				
		return true;
	}

}
