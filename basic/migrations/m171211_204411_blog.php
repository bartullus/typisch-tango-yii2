<?php

namespace app\migrations;

use yii\db\Migration;

class m171211_204411_blog extends Migration
{
	public function safeUp()
	{
		echo "migrate m171211_204411_blog\n";

		$this->createTable('{{%blog_article_status}}',
			[
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
		
		$this->createTable('{{%blog_article_category}}',
			[
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
		
		$this->createTable('{{%blog_article_keyword}}',
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull()->unique(),	
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createTable('{{%blog_article}}',
			[
				'id'             => $this->primaryKey(),
				'status_id'      => $this->integer()->notNull(),
				'category_id'    => $this->integer()->notNull(),
				'pub_date'       => $this->datetime()->notNull(),

				'title'          => $this->string()->notNull(),				
				'url'            => $this->string()->notNull(),				
				'content'        => $this->text(),
				'description'    => $this->text(),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);
		
		$this->createIndex('idx-article-url', '{{%blog_article}}', 'url');
		$this->createIndex('idx-article-pub_date', '{{%blog_article}}', 'pub_date');
		
		$this->addForeignKey('fk-article-status_id',
			'{{%blog_article}}', 'status_id',
			'{{%blog_article_status}}', 'id',
			'CASCADE'
		);

		$this->addForeignKey('fk-article-category_id',
			'{{%blog_article}}', 'category_id',
			'{{%blog_article_category}}', 'id',
			'CASCADE'
		);

		$this->createTable('{{%blog_article_keyword_rel}}',
			[
				'article_id'      => $this->integer()->notNull(),
				'keyword_id'    => $this->integer()->notNull(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-article_keyword_rel', '{{%blog_article_keyword_rel}}', ['article_id', 'keyword_id' ], true);
		
		$this->addForeignKey('fk-article_keyword_rel-keyword_id',
			'{{%blog_article_keyword_rel}}', 'keyword_id',
			'{{%blog_article_keyword}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-article_keyword_rel-article_id',
			'{{%blog_article_keyword_rel}}', 'article_id',
			'{{%blog_article}}', 'id',
			'CASCADE'
		);
		
		
		$this->createTable('{{%blog_receiver}}',
			[
				'id'             => $this->primaryKey(),
				'name'           => $this->string()->notNull(),
				'prename'        => $this->string(),
				'email'          => $this->string()->notNull(),

				'info'           => $this->string(),				
				'member'         => $this->boolean()->notNull()->defaultValue(0),				
				'valid'          => $this->boolean()->notNull()->defaultValue(1),				
				'birthdate'      => $this->date(),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-receiver-email', '{{%blog_receiver}}', 'email', true);

		$this->createTable('{{%blog_receiver_article_rel}}',
			[
				'id'             => $this->primaryKey(),
				'receiver_id'    => $this->integer()->notNull(),
				'article_id'     => $this->integer()->notNull(),
				'result'         => $this->integer()->notNull()->defaultValue(0),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-receiver-article_rel', '{{%blog_receiver_article_rel}}', ['receiver_id', 'article_id' ], true);
	
		$this->addForeignKey('fk-receiver_article_rel-receiver_id',
			'{{%blog_receiver_article_rel}}', 'receiver_id',
			'{{%blog_receiver}}', 'id',
			'CASCADE'
		);
		
		$this->addForeignKey('fk-receiver_article_rel-article_id',
			'{{%blog_receiver_article_rel}}', 'article_id',
			'{{%blog_article}}', 'id',
			'CASCADE'
		);
		
		$this->createTable('{{%blog_receiver_code}}',
			[
				'id'             => $this->primaryKey(),
				'code'           => $this->string(32)->notNull(),
				'name'           => $this->string(),
				'prename'        => $this->string(),
				'email'          => $this->string()->notNull(),

				'verified'       => $this->boolean()->notNull()->defaultValue(0),				
				'ip_addr'        => $this->string(64),
				
				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createTable('{{%blog_receiver_blacklist}}',
			[
				'id'             => $this->primaryKey(),
				'email'          => $this->string()->notNull(),
				'description'    => $this->string(),

				'create_time'    => $this->datetime(),
				'create_user_id' => $this->integer(),
				'update_time'    => $this->datetime(),
				'update_user_id' => $this->integer(),
			],
			'ENGINE=InnoDB'
		);

		$this->createIndex('idx-receiver_blacklist-email', '{{%blog_receiver_blacklist}}', 'email', true);

		echo "migrated m171211_204411_blog.\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m171211_204411_blog\n";

		$this->dropTable('{{%blog_article_keyword_rel}}');
		$this->dropTable('{{%blog_article}}');
		$this->dropTable('{{%blog_article_keyword}}');
		$this->dropTable('{{%blog_article_category}}');
		$this->dropTable('{{%blog_article_status}}');
		$this->dropTable('{{%blog_receiver}}');
		$this->dropTable('{{%blog_receiver_article_rel}}');
		$this->dropTable('{{%blog_receiver_code}}');
		$this->dropTable('{{%blog_receiver_blacklist}}');

		echo "reverted m171211_204411_blog\n";
		return true;
	}
}
