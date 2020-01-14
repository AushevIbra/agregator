<?php

namespace common\models\db;

use common\behaviors\FileUploadBehavior;
use common\behaviors\ImageUploadBehavior;
use common\yii\base\ActiveRecord;
use core\entities\behaviors\MetaBehavior;
use Yii;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * This is the model class for table "ref_foods".
 *
 * @property int $id
 * @property string $name
 * @property string|null $img
 * @property int $price
 * @property int|null $old_price
 * @property string|null $description
 * @property int $ref_food_category_id
 * @property int|null $ref_restaurant_id
 * @property int|null $status
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property RefFoodCategories $refFoodCategory
 * @property RefRestaurant $refRestaurant
 * @property RefFoodCategories $category
 * @property RefRestaurant $restaurant
 */
class RefFoods extends ActiveRecord
{
	const ATTR_ID                   = 'id';
	const ATTR_NAME                 = 'name';
	const ATTR_IMG                  = 'img';
	const ATTR_PRICE                = 'price';
	const ATTR_OLD_PRICE            = 'old_price';
	const ATTR_DESCRIPTION          = 'description';
	const ATTR_REF_FOOD_CATEGORY_ID = 'ref_food_category_id';
	const ATTR_REF_RESTAURANT_ID    = 'ref_restaurant_id';
	const ATTR_STATUS               = 'status';

	const STATUS_ACTIVE   = 1;
	const STATUS_INCATIVE = 0;

	/**
	 * {@inheritDoc}
	 *
	 * @return array|false
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function extraFields()
	{
		return ['category'];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_foods';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, RequiredValidator::class],
			[static::ATTR_PRICE, RequiredValidator::class],
			[static::ATTR_REF_FOOD_CATEGORY_ID, RequiredValidator::class],
			[static::ATTR_REF_RESTAURANT_ID, RequiredValidator::class],
			[static::ATTR_PRICE, 'integer'],
			[static::ATTR_OLD_PRICE, 'integer'],
			[static::ATTR_REF_RESTAURANT_ID, 'integer'],
			[static::ATTR_REF_FOOD_CATEGORY_ID, 'integer'],
			[static::ATTR_STATUS, 'integer'],
			[static::ATTR_DESCRIPTION, StringValidator::class],
			[static::ATTR_NAME, StringValidator::class],
			[static::ATTR_NAME, 'trim'],
			[[static::ATTR_CREATED_AT, static::ATTR_UPDATED_AT, static::ATTR_DELETED_AT], 'safe'],
			[[static::ATTR_REF_FOOD_CATEGORY_ID],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => RefFoodCategories::class,
			 'targetAttribute' => [static::ATTR_REF_FOOD_CATEGORY_ID => RefFoodCategories::ATTR_ID]],
			[[static::ATTR_REF_RESTAURANT_ID],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => RefRestaurant::class,
			 'targetAttribute' => [static::ATTR_REF_RESTAURANT_ID => RefRestaurant::ATTR_ID]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return array_merge([
			static::ATTR_ID                   => 'ID',
			static::ATTR_NAME                 => 'Название',
			static::ATTR_IMG                  => 'Изображение',
			static::ATTR_PRICE                => 'Цена',
			static::ATTR_OLD_PRICE            => 'Старая цена',
			static::ATTR_DESCRIPTION          => 'Описание',
			static::ATTR_REF_FOOD_CATEGORY_ID => 'Категория',
			static::ATTR_REF_RESTAURANT_ID    => 'Ресторан',
			static::ATTR_STATUS               => 'Статус',
		], parent::attributeLabels());
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefFoodCategory()
	{
		return $this->hasOne(RefFoodCategories::class, ['id' => 'ref_food_category_id'])->inverseOf('refFoods');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurant()
	{
		return $this->hasOne(RefRestaurant::class, ['id' => 'ref_restaurant_id'])->inverseOf('refFoods');
	}

	/**
	 * @return RefFoodCategories|null
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function getCategory()
	{
		return RefFoodCategories::getModel($this->ref_food_category_id);
	}


	/**
	 * @return RefRestaurant|null
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function getRestaurant()
	{
		return RefRestaurant::getModel($this->ref_restaurant_id);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefFoodsQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefFoodsQuery(get_called_class());
	}


	public static function getStatusVariants()
	{
		return [
			static::STATUS_ACTIVE   => 'Активно',
			static::STATUS_INCATIVE => 'Выключено'
		];
	}

	public function behaviors()
	{
		return array_merge([
			[
				'class'          => FileUploadBehavior::class,
				'attribute'      => static::ATTR_IMG,
				'filePath'       => '@storageRoot/web/source/origin/foods/[[id]]/[[attribute_id]].[[extension]]',
				's3AbsolutePath' => 'source/origin/foods/[[id]]/[[attribute_id]].[[extension]]',
				'fileUrl'        => '@storage/source/origin/foods/[[id]]/[[attribute_id]].[[extension]]',
			],
		], parent::behaviors());
	}
}
