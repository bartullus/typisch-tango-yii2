<?php

namespace app\migrations;

use yii\db\Migration;

class m181127_201113_gallery extends Migration
{
	public function safeUp()
	{
		echo "migrate m181127_201113_gallery\n";
		
		/*******************************************************************/
		/*** gallery_album_category                                      ***/
		/*******************************************************************/
		
		$this->createTable('{{%gallery_album_category}}', // tt_gallery_album_category
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	
				'description'    => $this->text(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-gallery_album_category-name', '{{%gallery_album_category}}', 'name');
		
		/*******************************************************************/
		/*** gallery_album                                               ***/
		/*******************************************************************/
		
		$this->createTable('{{%gallery_album}}', // tt_gallery_album
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	
				'url'            => $this->string(),	
				'description'    => $this->text(),

				'album_category_id' => $this->integer()->notNull()->defaultValue(1),	
				'public'         => $this->boolean()->notNull()->defaultValue(true),
				'in_gallery'     => $this->boolean()->notNull()->defaultValue(true),
				'thumbnail_id' => $this->integer(),	

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-gallery_album-name', '{{%gallery_album}}', 'name');
		
		$this->addForeignKey('fk-gallery_album-album_category_id',
			'{{%gallery_album}}', 'album_category_id',
			'{{%gallery_album_category}}', 'id',
			'CASCADE'
		);

		// clear all entries from events table before insert the index
		$this->truncateTable('{{%cal_event_offer}}');
		$events = new \app\modules\cal\models\CalendarEvent;
		$events->deleteAll();
		
		$this->addForeignKey('fk-cal_event-album_id',
			'{{%cal_event}}', 'album_id',
			'{{%gallery_album}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** gallery_picture                                             ***/
		/*******************************************************************/
		
		$this->createTable('{{%gallery_picture}}', // tt_gallery_picture
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	
				'description'    => $this->text(),

				'album_id'       => $this->integer()->notNull(),	
				'format'         => $this->string()->notNull()->defaultValue("jpg"),	
				'url'            => $this->string(),	

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-gallery_picture-name', '{{%gallery_picture}}', 'name');
		
		$this->addForeignKey('fk-gallery_picture-album_id',
			'{{%gallery_picture}}', 'album_id',
			'{{%gallery_album}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** gallery_picture_views                                       ***/
		/*******************************************************************/
		
		$this->createTable('{{%gallery_picture_views}}', // tt_gallery_picture_views
			[
				'picture_id' => $this->integer()->notNull(),
				'views'      => $this->integer()->notNull()->defaultValue(0),	
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-gallery_picture_views-picture_id', '{{%gallery_picture_views}}', 'picture_id');
		
		$this->addForeignKey('fk-gallery_picture_views-picture_id',
			'{{%gallery_picture_views}}', 'picture_id',
			'{{%gallery_picture}}', 'id',
			'CASCADE'
		);

		echo "migrated m181127_201113_gallery\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m181127_201113_gallery\n";

		$this->dropTable('{{%gallery_picture_views}}');
		$this->dropTable('{{%gallery_picture}}');
		$this->dropTable('{{%gallery_album}}');
		$this->dropTable('{{%gallery_album_category}}');

		echo "reverted m181127_201113_gallery\n";
		return true;
	}
}
