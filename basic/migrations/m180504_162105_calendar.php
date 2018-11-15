<?php

namespace app\migrations;

use yii\db\Migration;

class m180504_162105_calendar extends Migration
{
	public function safeUp()
	{
		echo "migrate m180504_162105_calendar\n";

		/*******************************************************************/
		/*** cal_event_category                                          ***/
		/*******************************************************************/
		
		$this->createTable('{{%cal_event_category}}', // tt_calendar_category
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	
				'plural'         => $this->string(),	
				'shortname'      => $this->string(5),	
				'schema_type'    => $this->string(),	
				'description'    => $this->text(),

				'importance'     => $this->integer()->notNull(),						
				'is_class'       => $this->boolean()->notNull()->defaultValue(false),
				'can_be_parent'  => $this->boolean()->notNull()->defaultValue(false),
				'user_group_id'  => $this->integer()->notNull(),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-cal_event_category-name', '{{%cal_event_category}}', 'name');
		
		/*******************************************************************/
		/*** cal_location                                                ***/
		/*******************************************************************/

		$this->createTable('{{%cal_location}}', // tt_calendar_location
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	
				'loc_name'       => $this->string()->notNull(),	
				'url'            => $this->string()->notNull(),	
				'description'    => $this->text(),

				'location_valid' => $this->boolean()->notNull()->defaultValue(true),
				'is_loc'         => $this->boolean()->notNull()->defaultValue(true),
				'is_org'         => $this->boolean()->notNull()->defaultValue(true),
				'show_address'   => $this->boolean()->notNull()->defaultValue(true),

				'person'         => $this->string(),
				'email'          => $this->string(),
				'website'        => $this->string(),
				'telephone'      => $this->string(),

				'city_id'        => $this->integer(),						
				'city'           => $this->string()->notNull(),
				'district'       => $this->string(),
				'postcode'       => $this->string(),
				'address'        => $this->string(),
					
				'latitude'       => $this->double(),
				'longitude'      => $this->double(),
				'mapZoomLevel'   => $this->integer(),
					
				'album_id'       => $this->integer(),						
				'colour'         => $this->string(),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-cal_location-name', '{{%cal_location}}', 'name');
		$this->createIndex('idx-cal_location-location_valid', '{{%cal_location}}', 'location_valid');
		$this->createIndex('idx-cal_location-city_id', '{{%cal_location}}', 'city_id');
				
		/*******************************************************************/
		/*** cal_event                                                   ***/
		/*******************************************************************/

		$this->createTable('{{%cal_event}}', // tt_calendar_event
			[
				'id'             => $this->primaryKey(),
				'title'           => $this->string()->notNull(),	
				'url'            => $this->string(),	
				'description'    => $this->text(),
				'event_website'  => $this->string(),	
					
				'parent_id'      => $this->integer(),	
				'category_id'    => $this->integer()->notNull(),	
				
				'event_valid'		 => $this->boolean()->notNull()->defaultValue(true),
				'visible'    		 => $this->boolean()->notNull()->defaultValue(true),

				'start_date'     => $this->date()->notNull(),	
				'end_date'       => $this->date(),	
				'start_time'     => $this->time(),	
				'end_time'       => $this->time(),	
				'terms'          => $this->integer()->notNull()->defaultValue(0),
				'terms_details'  => $this->string(),
					
				'price'          => $this->string(),	
				'max_number'     => $this->integer(),	
					
				'location_id'      => $this->integer(),	
				'location_city'    => $this->string()->notNull(),
				'location_address' => $this->string(),
				'location_name'    => $this->string(),
					
				'organisator_id'        => $this->integer(),
				'organisator_name'      => $this->string(),
				'organisator_website'   => $this->string(),
				'organisator_email'     => $this->string(),
				'organisator_telephone' => $this->string(),
				
				'album_id'       => $this->integer(),						
				'submitter_ip'   => $this->string(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-cal_event-title', '{{%cal_event}}', 'title');
		$this->createIndex('idx-cal_event-parent_id', '{{%cal_event}}', 'parent_id');
		$this->createIndex('idx-cal_event-category_id', '{{%cal_event}}', 'category_id');
		$this->createIndex('idx-cal_event-location_id', '{{%cal_event}}', 'location_id');
		$this->createIndex('idx-cal_event-organisator_id', '{{%cal_event}}', 'organisator_id');
		$this->createIndex('idx-cal_event-visible', '{{%cal_event}}', 'visible');
		$this->createIndex('idx-cal_event-event_valid', '{{%cal_event}}', 'event_valid');
		$this->createIndex('idx-cal_event-terms', '{{%cal_event}}', 'terms');
		$this->createIndex('idx-cal_event-start_date', '{{%cal_event}}', 'start_date');
		$this->createIndex('idx-cal_event-end_date', '{{%cal_event}}', 'end_date');
		
		$this->addForeignKey('fk-cal_event-parent_id',
			'{{%cal_event}}', 'parent_id',
			'{{%cal_event}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-cal_event-category_id',
			'{{%cal_event}}', 'category_id',
			'{{%cal_event_category}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-cal_event-location_id',
			'{{%cal_event}}', 'location_id',
			'{{%cal_location}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-cal_event-organisator_id',
			'{{%cal_event}}', 'organisator_id',
			'{{%cal_location}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** cal_event_singledate                                        ***/
		/*******************************************************************/

		$this->createTable('{{%cal_event_singledate}}', // tt_calendar_event_singledates
			[
				'id'             => $this->primaryKey(),
				'event_id'			 => $this->integer()->notNull(),

				'no'             => $this->integer()->notNull(),
				'date'           => $this->date()->notNull(),
				'timestamp'      => $this->integer()->notNull(),
				'start_time'     => $this->time(),
				'end_time'       => $this->time(),
					
				'active'    		 => $this->boolean()->notNull()->defaultValue(true),
				'manual'    		 => $this->boolean()->notNull()->defaultValue(false),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-cal_event_singledate-event_id', '{{%cal_event_singledate}}', 'event_id');
		$this->createIndex('idx-cal_event_singledate-date', '{{%cal_event_singledate}}', 'date');
		$this->createIndex('idx-cal_event_singledate-active', '{{%cal_event_singledate}}', 'active');

		$this->addForeignKey('fk-cal_event_singledate-event_id',
			'{{%cal_event_singledate}}', 'event_id',
			'{{%cal_event}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** cal_event_offer_category                                    ***/
		/*******************************************************************/

		$this->createTable('{{%cal_event_offer_category}}', // tt_calendar_event_offer_category
			[
				//'id'             => $this->primaryKey(),
				'id'             => $this->integer()->notNull(), // prevent auto_increment (so primaryKey cannot be used)
				'name'           => $this->string()->notNull(),	
				'description'    => $this->text(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
				"PRIMARY KEY (`id`)",
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-cal_event_offer_category-name', '{{%cal_event_offer_category}}', 'name');
		
		/*******************************************************************/
		/*** cal_event_offer_discounted                                  ***/
		/*******************************************************************/
		
		$this->createTable('{{%cal_event_offer_discounted}}', // tt_booking_discounted
			[
				//'id'             => $this->primaryKey(),
				'id'             => $this->integer()->notNull(), // prevent auto_increment (so primaryKey cannot be used)
				'short'          => $this->string(10)->notNull(),	
				'name'           => $this->string()->notNull(),	
				'description'    => $this->text(),
					
				'foruser'        => $this->integer()->notNull(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
				"PRIMARY KEY (`id`)",
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-cal_event_offer_discounted-short', '{{%cal_event_offer_discounted}}', 'short', true);

		/*******************************************************************/
		/*** cal_event_offer                                             ***/
		/*******************************************************************/

		$this->createTable('{{%cal_event_offer}}', // tt_calendar_event_offer
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),
				'amount'         => $this->decimal(10, 2)->notNull(),
					
				'event_id'			 => $this->integer()->notNull(),
				'category_id'    => $this->integer()->notNull(),
				'discounted_id'  => $this->integer()->notNull(),
			
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-cal_event_offer-name', '{{%cal_event_offer}}', 'name');

		$this->addForeignKey('fk-cal_event_offer-category_id',
			'{{%cal_event_offer}}', 'category_id',
			'{{%cal_event_offer_category}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-cal_event_offer-event_id',
			'{{%cal_event_offer}}', 'event_id',
			'{{%cal_event}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-cal_event_offer-discounted_id',
			'{{%cal_event_offer}}', 'discounted_id',
			'{{%cal_event_offer_discounted}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** cal_specialday_type                                         ***/
		/*******************************************************************/

		$this->createTable('{{%cal_specialday_type}}', // tt_calendar_specialdays_type
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

		$this->createIndex('idx-cal_specialday_type-name', '{{%cal_specialday_type}}', 'name');

		/*******************************************************************/
		/*** cal_specialday                                              ***/
		/*******************************************************************/

		$this->createTable('{{%cal_specialday}}', // tt_calendar_specialdays
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),
				'free'    		   => $this->boolean()->notNull()->defaultValue(true),
					
				'type_id'	  		 => $this->integer()->notNull(),
				'month'          => $this->integer(),
				'day'            => $this->integer(),
				'relative'       => $this->integer(),
					
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-cal_specialday-name', '{{%cal_specialday}}', 'name');

		$this->addForeignKey('fk-cal_specialday-type_id',
			'{{%cal_specialday}}', 'type_id',
			'{{%cal_specialday_type}}', 'id',
			'CASCADE'
		);
		
		/*******************************************************************/
		/*** cal_terms                                                   ***/
		/*******************************************************************/
		
		$this->createTable('{{%cal_terms}}', // tt_calendar_terms
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),	

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		/*******************************************************************/

		echo "migrated m180504_162105_calendar\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m180504_162105_calendar\n";

		$this->dropTable('{{%cal_terms}}');
		$this->dropTable('{{%cal_specialday}}');
		$this->dropTable('{{%cal_specialday_type}}');
		$this->dropTable('{{%cal_event_offer}}');
		$this->dropTable('{{%cal_event_offer_discounted}}');
		$this->dropTable('{{%cal_event_offer_category}}');
		$this->dropTable('{{%cal_event_singledate}}');
		$this->dropTable('{{%cal_event}}');
		$this->dropTable('{{%cal_location}}');
		$this->dropTable('{{%cal_event_category}}');

		echo "reverted m180504_162105_calendar\n";
		return true;
	}

}
