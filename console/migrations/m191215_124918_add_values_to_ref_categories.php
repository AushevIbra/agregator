<?php

use yii\db\Migration;

/**
 * Class m191215_124918_add_values_to_ref_categories
 */
class m191215_124918_add_values_to_ref_categories extends Migration
{
	const TABLE_NAME = 'ref_restaurant_categories';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->insert(static::TABLE_NAME, [
			'id'     => 1,
			'name'   => 'Бургеры',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 2,
			'name'   => 'Суши',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 3,
			'name'   => 'Пицца',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 4,
			'name'   => 'Фастфуд',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 5,
			'name'   => 'Шашлыки',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 6,
			'name'   => 'Азиатская',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 7,
			'name'   => 'Пироги',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 8,
			'name'   => 'Десерты',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 9,
			'name'   => 'Здоровая еда ',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 10,
			'name'   => 'Мясо и рыба',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 11,
			'name'   => 'Обеды',
			'status' => 1,
		]);

		$this->insert(static::TABLE_NAME, [
			'id'     => 12,
			'name'   => 'Русская',
			'status' => 1,
		]);


	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->delete(static::TABLE_NAME, ['id' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]]);
	}

}
