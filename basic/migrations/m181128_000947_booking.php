<?php

namespace app\migrations;

use yii\db\Migration;

class m181128_000947_booking extends Migration
{
	public function safeUp()
	{
		echo "migrate m181128_000947_booking\n";

		/*******************************************************************/
		/*** booking_userbooking_role                                    ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_userbooking_role}}', // tt_booking_userbooking_role
			[
				'id'             => $this->primaryKey(),
				'short'          => $this->string()->notNull(),	
				'name'           => $this->string()->notNull(),	
				'description'    => $this->text(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-booking_userbooking_role-short', '{{%booking_userbooking_role}}', 'short');
		$this->createIndex('idx-booking_userbooking_role-name', '{{%booking_userbooking_role}}', 'name');

		/*******************************************************************/
		/*** booking_userbooking_item_type                               ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_userbooking_item_type}}', // tt_booking_userbooking_item_type
			[
				'id'                => $this->integer()->notNull(),
				'short'             => $this->string()->notNull(),	
				'name'              => $this->string()->notNull(),	
				'description'       => $this->text(),

				'offer_category_id' => $this->integer()->notNull(),	

				'create_time'       => $this->datetime(),
				'create_user_id'    => $this->integer(),
				'update_time'       => $this->datetime(),
				'update_user_id'    => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-booking_userbooking_item_type-id', '{{%booking_userbooking_item_type}}', 'id');
		$this->createIndex('idx-booking_userbooking_item_type-short', '{{%booking_userbooking_item_type}}', 'short');
		$this->createIndex('idx-booking_userbooking_item_type-name', '{{%booking_userbooking_item_type}}', 'name');

		/*******************************************************************/
		/*** booking_bookable                                               ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_bookable}}', // tt_booking_bookable
			[
				'id'              => $this->primaryKey(),
				'event_id'        => $this->integer()->notNull(),	
				'booking_start'   => $this->date()->notNull(),
				'booking_end'     => $this->date()->notNull(),
					
				'ask_role_always'             => $this->boolean()->notNull(),
				'payment_due_days'            => $this->integer()->notNull(),
				'pricelevel_discount'         => $this->float(),
				'percent_pricelevel_discount' => $this->decimal(10,2),
				'date_earlybird'              => $this->datetime(),
				'percent_earlybird_discount'  => $this->decimal(10,2),
				'remark'                      => $this->text(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->addForeignKey('fk-booking_bookable-event_id',
			'{{%booking_bookable}}', 'event_id',
			'{{%cal_event}}', 'id',
			'CASCADE'
		);
		
		/*******************************************************************/
		/*** booking_package                                             ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_package}}', // tt_booking_package
			[
				'id'             => $this->primaryKey(),
				'bookable_id'    => $this->integer()->notNull(),	
				'name'           => $this->string()->notNull(),	
				'amount'         => $this->float()->notNull(),
				'discounted_id'  => $this->integer()->notNull(),	
				'default_booked' => $this->boolean()->notNull()->defaultValue(true),					
				'description'    => $this->text(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-booking_package-name', '{{%booking_package}}', 'name');

		$this->addForeignKey('fk-booking_package-bookable_id',
			'{{%booking_package}}', 'bookable_id',
			'{{%booking_bookable}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-booking_package-discounted_id',
			'{{%booking_package}}', 'discounted_id',
			'{{%cal_event_offer_discounted}}', 'id',
			'CASCADE'
		);
		
		/*******************************************************************/
		/*** booking_package_event_offer_rel                             ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_package_event_offer_rel}}', // booking_package_event_offer_rel
			[
				'package_id'     => $this->integer()->notNull(),
				'event_offer_id' => $this->integer()->notNull(),	
			],
			'ENGINE=InnoDB'
		);

		$this->addForeignKey('fk-booking_package_event_offer_rel-package_id',
			'{{%booking_package_event_offer_rel}}', 'package_id',
			'{{%booking_package}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-booking_package_event_offer_rel-event_offer_id',
			'{{%booking_package_event_offer_rel}}', 'package_id',
			'{{%cal_event_offer}}', 'id',
			'CASCADE'
		);

		/*******************************************************************/
		/*** booking_userbooking                                         ***/
		/*******************************************************************/
		
		$this->createTable('{{%booking_userbooking}}', // tt_booking_userbooking
			[
				'id'             => $this->primaryKey(),
				'bookable_id'    => $this->integer()->notNull(),	
				'user_id'        => $this->integer(),	
				'role_id'        => $this->integer()->notNull()->defaultValue(3),	
				'discounted_id'  => $this->integer()->notNull(),	

				'code'             => $this->string()->notNull(),	
				'name'             => $this->string()->notNull(),	
				'email'            => $this->string()->notNull(),	
				'sum_price'        => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'discount_price'   => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'booking_date'     => $this->date()->notNull(),
				'booking_due_date' => $this->date()->notNull(),
					
				'earlybird_price'  => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'special_rebate'   => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'sum_final'        => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'sum_payment'      => $this->decimal(10,2)->notNull()->defaultValue(0.00),
				'difference'       => $this->decimal(10,2)->notNull()->defaultValue(0.00),

				'remark'           => $this->text(),
				'confirmed'        => $this->boolean()->notNull()->defaultValue(false),
				'acknowledged'     => $this->boolean()->notNull()->defaultValue(false),
			
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-booking_userbooking-code', '{{%booking_userbooking}}', 'code');
		$this->createIndex('idx-booking_userbooking-name', '{{%booking_userbooking}}', 'name');

		$this->addForeignKey('fk-booking_userbooking-bookable_id',
			'{{%booking_userbooking}}', 'bookable_id',
			'{{%booking_bookable}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-booking_userbooking-role_id',
			'{{%booking_userbooking}}', 'role_id',
			'{{%booking_userbooking_role}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-booking_userbooking-discounted_id',
			'{{%booking_userbooking}}', 'discounted_id',
			'{{%cal_event_offer_discounted}}', 'id',
			'CASCADE'
		);
		

		echo "migrated m181128_000947_booking\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m181128_000947_booking\n";

		$this->dropTable('{{%booking_userbooking}}');
		$this->dropTable('{{%booking_package_event_offer_rel}}');
		$this->dropTable('{{%booking_package}}');
		$this->dropTable('{{%booking_bookable}}');
		$this->dropTable('{{%booking_userbooking_item_type}}');
		$this->dropTable('{{%booking_userbooking_role}}');

		echo "reverted m181128_000947_booking\n";
		return true;
	}

}
