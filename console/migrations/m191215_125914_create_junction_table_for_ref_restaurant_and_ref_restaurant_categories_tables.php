<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_restaurant_lnk_categories}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%ref_restaurant}}`
 * - `{{%ref_restaurant_categories}}`
 */
class m191215_125914_create_junction_table_for_ref_restaurant_and_ref_restaurant_categories_tables extends Migration
{
	const TABLE = 'ref_restaurant_lnk_categories';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE, [
			'ref_restaurant_id'            => $this->integer(),
			'ref_restaurant_categories_id' => $this->integer(),
			'PRIMARY KEY(ref_restaurant_id, ref_restaurant_categories_id)',
		]);

		// creates index for column `ref_restaurant_id`
		$this->createIndex(
			'{{%idx-ref_restaurant_lnk_categories-ref_restaurant_id}}',
			'{{%ref_restaurant_lnk_categories}}',
			'ref_restaurant_id'
		);

		// add foreign key for table `{{%ref_restaurant}}`
		$this->addForeignKey(
			'{{%fk-ref_restaurant_lnk_categories-ref_restaurant_id}}',
			'{{%ref_restaurant_lnk_categories}}',
			'ref_restaurant_id',
			'{{%ref_restaurant}}',
			'id',
			'CASCADE'
		);

		// creates index for column `ref_restaurant_categories_id`
		$this->createIndex(
			'{{%idx-ref_restaurant_lnk_categories-ref_restaurant_categories_id}}',
			'{{%ref_restaurant_lnk_categories}}',
			'ref_restaurant_categories_id'
		);

		// add foreign key for table `{{%ref_restaurant_categories}}`
		$this->addForeignKey(
			'{{%fk-ref_restaurant_lnk_categories-ref_restaurant_categories_id}}',
			'{{%ref_restaurant_lnk_categories}}',
			'ref_restaurant_categories_id',
			'{{%ref_restaurant_categories}}',
			'id',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		// drops foreign key for table `{{%ref_restaurant}}`
		$this->dropForeignKey(
			'{{%fk-ref_restaurant_lnk_categories-ref_restaurant_id}}',
			'{{%ref_restaurant_lnk_categories}}'
		);

		// drops index for column `ref_restaurant_id`
		$this->dropIndex(
			'{{%idx-ref_restaurant_lnk_categories-ref_restaurant_id}}',
			'{{%ref_restaurant_lnk_categories}}'
		);

		// drops foreign key for table `{{%ref_restaurant_categories}}`
		$this->dropForeignKey(
			'{{%fk-ref_restaurant_lnk_categories-ref_restaurant_categories_id}}',
			'{{%ref_restaurant_lnk_categories}}'
		);

		// drops index for column `ref_restaurant_categories_id`
		$this->dropIndex(
			'{{%idx-ref_restaurant_lnk_categories-ref_restaurant_categories_id}}',
			'{{%ref_restaurant_lnk_categories}}'
		);

		$this->dropTable(static::TABLE);
	}
}
