<?php

namespace app\modules\v1\models\views\restaurant;

use common\models\db\RefRestaurant;

class RestaurantView
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
	 * @var string
	 */
	public $img;

	/**
	 * @var string
	 */
	public $slug;

	/**
	 * @var int
	 */
	public $minDeliveryTime;

	/**
	 * @var int
	 */
	public $maxDeliveryTime;

	/**
	 * @var int
	 */
	public $freeFrom;

	/**
	 * @var int
	 */
	public $minAmount;

	public function __construct(RefRestaurant $restaurant)
	{
		$this->id              = $restaurant->id;
		$this->name            = $restaurant->name;
		$this->slug            = $restaurant->slug;
		$this->img             = $restaurant->getUploadedFileUrl(RefRestaurant::ATTR_IMG);
		$this->minAmount       = $restaurant->min_amount;
		$this->maxDeliveryTime = $restaurant->max_delivery_time;
		$this->minDeliveryTime = $restaurant->min_delivery_time;
		$this->freeFrom        = $restaurant->free_from;
	}
}