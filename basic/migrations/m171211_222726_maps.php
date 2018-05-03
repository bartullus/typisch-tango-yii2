<?php

namespace app\migrations;

use yii\db\Migration;

class m171211_222726_maps extends Migration
{
	public function safeUp()
	{
		echo "migrate m171211_222726_maps\n";

		$this->createTable('{{%map_state}}',
			[
				'id'             => $this->primaryKey(),
				'shortcut'       => $this->string(50)->notNull()->unique(),	
				'name'           => $this->string()->notNull()->unique(),	
				'url'            => $this->string()->notNull()->unique(),	
				'description'    => $this->text(),

				'latitude'       => $this->double(),
				'longitude'      => $this->double(),
				'mapZoomLevel'   => $this->integer(),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-map_state-shortcut', '{{%map_state}}', 'shortcut');
		$this->createIndex('idx-map_state-name', '{{%map_state}}', 'name');
		$this->createIndex('idx-map_state-url', '{{%map_state}}', 'url');

		$this->createTable('{{%map_region}}',
			[
				'id'             => $this->primaryKey(),
				'state_id'       => $this->integer()->notNull(),	
				'shortcut'       => $this->string(50)->notNull()->unique(),	
				'name'           => $this->string()->notNull()->unique(),	
				'url'            => $this->string()->notNull()->unique(),	
				'description'    => $this->text(),

				'latitude'       => $this->double(),
				'longitude'      => $this->double(),
				'mapZoomLevel'   => $this->integer(),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-map_region-shortcut', '{{%map_region}}', 'shortcut');
		$this->createIndex('idx-map_region-name', '{{%map_region}}', 'name');
		$this->createIndex('idx-map_region-url', '{{%map_region}}', 'url');

		$this->addForeignKey('fk-map_region-state_id',
			'{{%map_region}}', 'state_id',
			'{{%map_state}}', 'id',
			'CASCADE'
		);

		$this->createTable('{{%map_city}}',
			[
				'id'             => $this->primaryKey(),
				'region_id'      => $this->integer()->notNull(),	
				'shortcut'       => $this->string(50)->notNull(),	
				'name'           => $this->string()->notNull()->unique(),	
				'url'            => $this->string()->notNull()->unique(),	
				'description'    => $this->text(),

				'latitude'       => $this->double(),
				'longitude'      => $this->double(),
				'mapZoomLevel'   => $this->integer(),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-map_city-shortcut', '{{%map_city}}', 'shortcut');
		$this->createIndex('idx-map_city-name', '{{%map_city}}', 'name');
		$this->createIndex('idx-map_city-url', '{{%map_city}}', 'url');

		$this->addForeignKey('fk-map_city-region_id',
			'{{%map_city}}', 'region_id',
			'{{%map_region}}', 'id',
			'CASCADE'
		);

		echo "migrated m171211_222726_maps\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m171211_222726_maps\n";

		$this->dropTable('{{%map_city}}');
		$this->dropTable('{{%map_region}}');
		$this->dropTable('{{%map_state}}');

		echo "reverted m171211_222726_maps\n";
		return true;
	}
}
