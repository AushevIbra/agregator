<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_user_lnk_restaurants}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%ref_restaurant}}`
 */
class m191215_131215_create_junction_table_for_user_and_ref_restaurant_tables extends Migration
{
	const TABLE_NAME = 'ref_user_lnk_restaurants';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE_NAME, [
			'user_id'           => $this->integer(),
			'ref_restaurant_id' => $this->integer(),
			'PRIMARY KEY(user_id, ref_restaurant_id)',
		]);

		// creates index for column `user_id`
		$this->createIndex(
			'{{%idx-ref_user_lnk_restaurants-user_id}}',
			'{{%ref_user_lnk_restaurants}}',
			'user_id'
		);

		// add foreign key for table `{{%user}}`
		$this->addForeignKey(
			'{{%fk-ref_user_lnk_restaurants-user_id}}',
			'{{%ref_user_lnk_restaurants}}',
			'user_id',
			'{{%user}}',
			'id',
			'CASCADE'
		);

		// creates index for column `ref_restaurant_id`
		$this->createIndex(
			'{{%idx-ref_user_lnk_restaurants-ref_restaurant_id}}',
			'{{%ref_user_lnk_restaurants}}',
			'ref_restaurant_id'
		);

		// add foreign key for table `{{%ref_restaurant}}`
		$this->addForeignKey(
			'{{%fk-ref_user_lnk_restaurants-ref_restaurant_id}}',
			'{{%ref_user_lnk_restaurants}}',
			'ref_restaurant_id',
			'{{%ref_restaurant}}',
			'id',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		// drops foreign key for table `{{%user}}`
		$this->dropForeignKey(
			'{{%fk-ref_user_lnk_restaurants-user_id}}',
			'{{%ref_user_lnk_restaurants}}'
		);

		// drops index for column `user_id`
		$this->dropIndex(
			'{{%idx-ref_user_lnk_restaurants-user_id}}',
			'{{%ref_user_lnk_restaurants}}'
		);

		// drops foreign key for table `{{%ref_restaurant}}`
		$this->dropForeignKey(
			'{{%fk-ref_user_lnk_restaurants-ref_restaurant_id}}',
			'{{%ref_user_lnk_restaurants}}'
		);

		// drops index for column `ref_restaurant_id`
		$this->dropIndex(
			'{{%idx-ref_user_lnk_restaurants-ref_restaurant_id}}',
			'{{%ref_user_lnk_restaurants}}'
		);

		$this->dropTable(static::TABLE_NAME);
	}
}
