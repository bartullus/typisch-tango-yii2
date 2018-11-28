<?php

namespace app\migrations;

use yii\db\Migration;

class m181128_000947_booking extends Migration
{
	public function safeUp()
	{
		echo "migrate m181128_000947_booking\n";

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

		
		
		echo "migrated m181128_000947_booking\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m181128_000947_booking\n";

		$this->dropTable('{{%booking_bookable}}');

		echo "reverted m181128_000947_booking\n";
		return true;
	}

}
