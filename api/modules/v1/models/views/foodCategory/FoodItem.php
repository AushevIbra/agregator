<?php


namespace app\modules\v1\models\views\foodCategory;


use common\models\db\RefFoods;

class FoodItem
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
	public $description;

	/**
	 * @var string
	 */
	public $shortDescription;

	/**
	 * @var double
	 */
	public $price;

	/**
	 * @var double
	 */
	public $oldPrice;

	/**
	 * @var string
	 */
	public $img;
	/**
	 * @var RefFoods
	 */
	private $model;

	public function __construct(RefFoods $model)
	{
		$this->model = $model;

		$this->id          = $model->id;
		$this->name        = $model->name;
		$this->description = $model->description;
		$this->img         = $model->getUploadedFileUrl($model::ATTR_IMG);
		$this->price       = $model->price;
		$this->oldPrice    = $model->old_price;
	}
}