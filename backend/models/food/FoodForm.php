<?php


namespace backend\models\food;


use backend\models\photo\PhotoForm;
use common\models\db\RefFoodCategories;
use common\models\db\RefFoods;
use common\yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;
use yii\validators\ImageValidator;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\UploadedFile;

class FoodForm extends Model
{
	/**
	 * @var integer
	 */
	public $id;
	const ATTR_ID = 'id';
	/**
	 * @var string
	 */
	public $name;
	const ATTR_NAME = 'name';

	/**
	 * @var string
	 */
	public $img;
	const ATTR_IMG = 'img';

	/**
	 * @var float
	 */
	public $price;
	const ATTR_PRICE = 'price';

	/**
	 * @var float
	 */
	public $old_price;
	const ATTR_OLD_PRICE = 'old_price';

	/**
	 * @var string
	 */
	public $description;
	const ATTR_DESCRIPTION = 'description';

	/**
	 * @var int
	 */
	public $ref_food_category_id;
	const ATTR_REF_FOOD_CATEGORY_ID = 'ref_food_category_id';

	/**
	 * @var int
	 */
	public $status;
	const ATTR_STATUS = 'status';

	/**
	 * @var RefFoods
	 */
	private $model;

	/**
	 * @var PhotoForm
	 */
	public $photo;
	const FORM_PHOTO = 'photo';

	public function __construct(RefFoods $model, $config = [])
	{
		$this->model = $model;
		$this->photo = new PhotoForm();

		if (false === $model->isNewRecord) {
			$this->name                 = $this->model->name;
			$this->description          = $this->model->description;
			$this->price                = $this->model->price;
			$this->old_price            = $this->model->old_price;
			$this->status               = $this->model->status;
			$this->ref_food_category_id = $this->model->ref_food_category_id;
			$this->img                  = $this->model->img;
		}

		parent::__construct($config);
	}


	/**
	 * Правила валидации
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, RequiredValidator::class],
			[static::ATTR_NAME, 'trim'],
			[static::ATTR_REF_FOOD_CATEGORY_ID, RequiredValidator::class],
			[static::ATTR_DESCRIPTION, StringValidator::class],
			[static::ATTR_DESCRIPTION, 'trim'],
			[static::ATTR_PRICE, RequiredValidator::class],
			[[static::ATTR_PRICE, static::ATTR_OLD_PRICE], NumberValidator::class],
			[static::ATTR_STATUS, RequiredValidator::class],
			[static::ATTR_IMG, ImageValidator::class],
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

		$this->img = UploadedFile::getInstance($this, 'img');

		return true;
	}

	/**
	 *
	 * @return bool
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 *
	 */
	public function save()
	{
		if (false === ($this->validate() || $this->photo->validate())) {
			return false;
		}

		$transaction = Yii::$app->db->beginTransaction();

		try {
			$this->model->name                 = $this->name;
			$this->model->description          = $this->description;
			$this->model->price                = $this->price;
			$this->model->old_price            = $this->old_price;
			$this->model->status               = $this->status;
			$this->model->ref_food_category_id = $this->ref_food_category_id;

			if (null !== $this->img) {
				$this->model->img = $this->img;
			}

			$this->model->ref_restaurant_id = $this->restaurant->id;
			$this->model->save();
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
	public function getCategories()
	{
		return ArrayHelper::map(RefFoodCategories::find()->where([RefFoodCategories::ATTR_REF_RESTAURANT_ID => $this->restaurant->id])->orderBy(RefFoodCategories::ATTR_NAME)->asArray()->all(),
			RefFoodCategories::ATTR_ID, RefFoodCategories::ATTR_NAME);

	}

	public function attributeLabels()
	{
		return $this->model->attributeLabels();
	}

	/**
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function getStatuses()
	{
		return $this->model::getStatusVariants();
	}
}