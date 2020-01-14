<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_foods}}`.
 */
class m191218_181810_create_ref_foods_table extends Migration
{
	const TABLE_NAME = 'ref_foods';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE_NAME, [
			'id'                   => $this->primaryKey(),
			'name'                 => $this->string()->notNull(),
			'img'                  => $this->string()->null(),
			'price'                => $this->integer()->notNull(),
			'old_price'            => $this->integer()->null(),
			'description'          => $this->text()->null(),
			'ref_food_category_id' => $this->integer()->notNull(),
			'ref_restaurant_id'    => $this->integer()->notNull(),
			'status'               => $this->integer()->defaultValue(0),
			'created_at'           => $this->timestamp(),
			'updated_at'           => $this->timestamp()->null(),
			'deleted_at'           => $this->timestamp()->null(),
		]);

		$this->createIndex('idx-' . static::TABLE_NAME . '[status]', static::TABLE_NAME, 'status');
		$this->createIndex('idx-' . static::TABLE_NAME . '[deleted]', static::TABLE_NAME, 'deleted_at');
		$this->addForeignKey('fk-' . static::TABLE_NAME . '[restaurant]', static::TABLE_NAME, 'ref_restaurant_id',
			'ref_restaurant', 'id', 'CASCADE');
		$this->addForeignKey('fk-' . static::TABLE_NAME . '[category]', static::TABLE_NAME, 'ref_food_category_id',
			'ref_food_categories', 'id', 'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable(static::TABLE_NAME);
	}
}
