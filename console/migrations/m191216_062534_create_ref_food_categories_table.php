<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_food_categories}}`.
 */
class m191216_062534_create_ref_food_categories_table extends Migration
{
	const TABLE_NAME = 'ref_food_categories';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE_NAME, [
			'id'                => $this->primaryKey(),
			'name'              => $this->string()->notNull(),
			'icon'              => $this->string()->null(),
			'img'               => $this->string()->null(),
			'status'            => $this->integer()->defaultValue(0),
			'ref_restaurant_id' => $this->integer()->notNull(),
			'created_at'        => $this->timestamp(),
			'updated_at'        => $this->timestamp()->null(),
			'deleted_at'        => $this->timestamp()->null(),
		]);

		$this->createIndex('idx-' . static::TABLE_NAME . '[status]', static::TABLE_NAME, 'status');
		$this->createIndex('idx-' . static::TABLE_NAME . '[deleted]', static::TABLE_NAME, 'deleted_at');
		$this->addForeignKey('fk-' . static::TABLE_NAME . '[restaurant]', static::TABLE_NAME, 'ref_restaurant_id',
			'ref_restaurant', 'id', 'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable(static::TABLE_NAME);
	}
}
