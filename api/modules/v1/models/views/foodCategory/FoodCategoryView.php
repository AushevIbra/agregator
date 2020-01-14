<?php


namespace app\modules\v1\models\views\foodCategory;


use common\models\db\RefFoodCategories;

class FoodCategoryView
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var FoodItem[]
	 */
	public $foods;

	/**
	 * @var RefFoodCategories
	 */
	private $model;

	public function __construct(RefFoodCategories $model)
	{
		$this->model = $model;

		$this->name = $model->name;
		$this->id   = $model->id;

		$foods = $model->refFoods;


		foreach ($foods as $food) {
			$item          = new FoodItem($food);
			$this->foods[] = $item;
		}

	}
}