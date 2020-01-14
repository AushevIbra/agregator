<?php

declare(strict_types=1);

namespace backend\models\restaurant;

use common\models\db\RefRestaurant;
use common\models\db\RefRestaurantCategories;
use common\models\db\RefRestaurantLnkCategories;
use yii\base\Model;
use yii\validators\SafeValidator;

/**
 * Форма для управления категориями.
 *
 * @author Ibra Aushev <aushevibra@yandex.ru>
 */
class RestaurantCategoryForm extends Model
{
	/** @var int[] Список категорий. */
	public $categories = [];
	const ATTR_CATEGORIES = 'categories';

	/**
	 * @var RefRestaurant
	 */
	private $model;


	public function __construct(RefRestaurant $model, array $config = [])
	{

		parent::__construct($config);
		$this->model      = $model;
		$this->categories = $this->getAssignedCategoriesID();
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function rules(): array
	{
		return [
			[static::ATTR_CATEGORIES, SafeValidator::class],
		];
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function attributeLabels(): array
	{
		return [
			static::ATTR_CATEGORIES => 'Категории'
		];
	}


	/**
	 * Сохранить категории
	 *
	 * @return bool
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function save(): bool
	{
		if (false === $this->validate()) {
			return false;
		}

		if (false === is_array($this->categories)) {
			return true;
		}

		$categories = $this->getAssignedCategoriesID();

		foreach ($categories as $categoryId) {
			if (false === in_array($categoryId, $this->categories)) {
				$this->model->revokeCategory((int)$categoryId);
			}
		}

		foreach ($this->categories as $categoryId) {
			if (false === in_array($categoryId, $categories)) {
				$this->model->assignCategory((int)$categoryId);
			}
		}
		return true;
	}

	/**
	 * Получить список категорий для аудиосказок.
	 *
	 * @return string[]
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function getCategoriesList(): array
	{
		$categories = RefRestaurantCategories::find()
			->select([RefRestaurantCategories::ATTR_NAME, RefRestaurantCategories::ATTR_ID])
			->orderBy([RefRestaurantCategories::ATTR_NAME => SORT_ASC])
			->indexBy(RefRestaurantCategories::ATTR_ID)
			->column();

		return $categories;
	}

	/**
	 * Получить список ID привязанных категорий.
	 *
	 * @param int $audioId
	 *
	 * @return int[]
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	private function getAssignedCategoriesID(): array
	{
		return RefRestaurantLnkCategories::find()
			->select(RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_CATEGORY_ID)
			->where([RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_ID => $this->model->id])
			->column();
	}
}