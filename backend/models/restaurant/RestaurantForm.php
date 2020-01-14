<?php

declare(strict_types=1);

namespace backend\models\restaurant;

use common\models\db\RefRestaurant;
use Yii;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\web\UploadedFile;
use zalatov\yii2\extend\exceptions\ValidationException;

class RestaurantForm extends \common\yii\base\Model
{
	/**
	 * @var string
	 */
	public $name;
	const ATTR_NAME = 'name';
	/**
	 * @var string
	 */
	public $slug;
	const ATTR_SLUG = 'slug';
	/**
	 * @var string
	 */
	public $description;
	const ATTR_DESCRIPTION = 'description';

	/**
	 * @var string
	 */
	public $img;
	const ATTR_IMG = 'img';
	/**
	 * @var string
	 */
	public $icon;
	const ATTR_ICON = 'icon';
	/**
	 * @var int
	 */
	public $status;
	const ATTR_STATUS = 'status';
	/**
	 * @var integer
	 */
	public $min_amount;
	const ATTR_MIN_AMOUNT = 'min_amount';
	/**
	 * @var integer
	 */
	public $min_delivery_time;
	const ATTR_MIN_DELIVERY_TIME = 'min_delivery_time';
	/**
	 * @var integer
	 */
	public $max_delivery_time;
	const ATTR_MAX_DELIVERY_TIME = 'max_delivery_time';
	/**
	 * @var integer
	 */
	public $free_from;
	const ATTR_FREE_FROM = 'free_from';


	/**
	 * @var RestaurantCategoryForm
	 */
	public $categories;
	const FORM_CATEGORIES = 'categories';

	/**
	 * @var RefRestaurant
	 */
	private $model;

	public function __construct(RefRestaurant $model, $config = [])
	{

		$this->model      = $model;
		$this->categories = new RestaurantCategoryForm($model);

		if (false === $model->isNewRecord) {
			$this->name              = $model->name;
			$this->slug              = $model->slug;
			$this->description       = $model->description;
			$this->img               = $model->img;
			$this->icon              = $model->icon;
			$this->status            = $model->status;
			$this->min_amount        = $model->min_amount;
			$this->min_delivery_time = $model->min_delivery_time;
			$this->max_delivery_time = $model->max_delivery_time;
			$this->free_from         = $model->free_from;
		}

		parent::__construct($config);
	}

	public function attributeLabels()
	{
		return $this->model->attributeLabels();
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, RequiredValidator::class],
			[static::ATTR_STATUS, RequiredValidator::class],

			[[static::ATTR_FREE_FROM,
			  static::ATTR_MAX_DELIVERY_TIME,
			  static::ATTR_MIN_AMOUNT,
			  static::ATTR_ICON,
			  static::ATTR_IMG,
			  static::ATTR_DESCRIPTION,
			  static::ATTR_SLUG,
			  static::ATTR_MIN_DELIVERY_TIME],
			 SafeValidator::class]
		];
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function beforeValidate(): bool
	{
		if (false === parent::beforeValidate()) {
			return false;
		}

		$this->img = UploadedFile::getInstance($this, static::ATTR_IMG);

		return true;
	}

	public function save()
	{
		$this->categories->load(Yii::$app->request->post());

		if (false === ($this->validate() || $this->categories->validate())) {
			return false;
		}

		$transaction = Yii::$app->db->beginTransaction();

		try {
			$this->model->name              = $this->name;
			$this->model->description       = $this->description;
			$this->model->icon              = $this->icon;
			$this->model->status            = $this->status;
			$this->model->min_amount        = $this->min_amount;
			$this->model->min_delivery_time = $this->min_delivery_time;
			$this->model->max_delivery_time = $this->max_delivery_time;
			$this->model->free_from         = $this->free_from;

			if (null !== $this->img) {
				$this->model->img = $this->img;
			}

			if (false === $this->model->save()) {
				throw new ValidationException($this->model);
			}

			if (false === $this->categories->save()) {
				throw new ValidationException($this->categories);
			}

			$transaction->commit();

			return true;

		} catch (\Throwable $exception) {
			Yii::$app->errorHandler->logException($exception);
			$transaction->rollBack();
			return false;
		}

	}

	/**
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function getStatuses()
	{
		return RefRestaurant::getStatusVariants();
	}

	public function internalForms()
	{
		return [static::FORM_CATEGORIES];
	}
}