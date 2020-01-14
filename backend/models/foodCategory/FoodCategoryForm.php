<?php


namespace backend\models\foodCategory;


use common\models\db\RefFoodCategories;
use DateTime;
use Yii;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

class FoodCategoryForm extends \common\yii\base\Model
{

	/**
	 * @var string
	 */
	public $name;
	const ATTR_NAME = 'name';

	/**
	 * @var int
	 */
	public $status;
	const ATTR_STATUS = 'status';

	/**
	 * @var RefFoodCategories
	 */
	private $model;

	public function __construct(RefFoodCategories $model, $config = [])
	{
		if (false === $model->isNewRecord) {
			$this->status = $model->status;
			$this->name   = $model->name;
		}

		parent::__construct($config);
		$this->model = $model;
	}

	/**
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, RequiredValidator::class],
			[static::ATTR_NAME, StringValidator::class],
			[static::ATTR_STATUS, NumberValidator::class],
			[static::ATTR_STATUS, RequiredValidator::class],
		];
	}

	/**
	 * @return bool
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function save()
	{
		if (false === $this->validate()) {
			return false;
		}
		$transaction = Yii::$app->db->beginTransaction();

		try {
			$this->model->name              = $this->name;
			$this->model->status            = $this->status;
			$this->model->ref_restaurant_id = $this->restaurant->id;
			$this->model->save();

			$transaction->commit();
		} catch (\Throwable $exception) {
			$transaction->rollBack();
			Yii::$app->errorHandler->logException($exception);
			return false;
		}

		return true;

	}

	public function attributeLabels()
	{
		return $this->model::labels();
	}

	public function getStatuses()
	{
		return $this->model::getStatusVariants();
	}

}