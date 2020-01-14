<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_restaurant}}`.
 */
class m191215_122452_create_ref_restaurant_table extends Migration
{
	const TABLE_NAME = 'ref_restaurant';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE_NAME, [
			'id'                => $this->primaryKey(),
			'name'              => $this->string()->notNull(),
			'slug'              => $this->string()->notNull(),
			'description'       => $this->text()->null(),
			'img'               => $this->string()->notNull(),
			'icon'              => $this->string()->null(),
			'status'            => $this->integer()->defaultValue(0),
			'min_amount'        => $this->integer()->null(),
			'min_delivery_time' => $this->integer()->null(),
			'max_delivery_time' => $this->integer()->null(),
			'free_from'         => $this->integer()->null(),
			'created_at'        => $this->timestamp(),
			'updated_at'        => $this->timestamp()->null(),
			'deleted_at'        => $this->timestamp()->null(),
		]);

		$this->createIndex('idx-' . static::TABLE_NAME . '[status]', static::TABLE_NAME, 'status');
		$this->createIndex('idx-' . static::TABLE_NAME . '[deleted]', static::TABLE_NAME, 'deleted_at');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable(static::TABLE_NAME);
	}
}
