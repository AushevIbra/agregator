<?php


namespace app\modules\v1\models\search\restaurant\models;


use app\modules\v1\models\views\foodCategory\FoodCategoryItem;

class ApiRestaurantItem
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $img = '';

	/**
	 * @var string
	 */
	public $description = '';

	/**
	 * @var FoodCategoryItem[]
	 */
	public $categories;

	/**
	 * @var int Минимальная сумма заказа
	 */
	public $min_amount;

	/**
	 * @var float
	 */
	public $rating;

	/**
	 * @var int
	 */
	public $minDeliveryTime;

	/**
	 * @var int
	 */
	public $maxDeliveryTime;

	/**
	 * @var string
	 */
	public $slug;
}