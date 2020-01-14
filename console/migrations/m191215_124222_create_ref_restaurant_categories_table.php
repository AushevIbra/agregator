<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ref_restaurant_categories}}`.
 */
class m191215_124222_create_ref_restaurant_categories_table extends Migration
{
	const TABLE_NAME = 'ref_restaurant_categories';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable(static::TABLE_NAME, [
			'id'         => $this->primaryKey(),
			'name'       => $this->string(),
			'icon'       => $this->string()->null(),
			'img'        => $this->string()->null(),
			'status'     => $this->integer()->defaultValue(0),
			'created_at' => $this->timestamp(),
			'updated_at' => $this->timestamp()->null(),
			'deleted_at' => $this->timestamp()->null(),
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
