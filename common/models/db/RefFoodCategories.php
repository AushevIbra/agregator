<?php

namespace common\models\db;

use common\yii\base\ActiveRecord;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ref_food_categories".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $img
 * @property int|null $status
 * @property int|null $ref_restaurant_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property RefRestaurant $refRestaurant
 * @property RefFoods[] $refFoods
 */
class RefFoodCategories extends ActiveRecord
{
	const ATTR_ID                = 'id';
	const ATTR_NAME              = 'name';
	const ATTR_ICON              = 'icon';
	const ATTR_IMG               = 'img';
	const ATTR_STATUS            = 'status';
	const ATTR_REF_RESTAURANT_ID = 'ref_restaurant_id';

	const STATUS_ACTIVE   = 1;
	const STATUS_INACTIVE = 0;

	public function extraFields()
	{
		return ['refFoods'];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_food_categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['status', 'ref_restaurant_id'], 'integer'],
			[['created_at', 'updated_at', 'deleted_at'], 'safe'],
			[['name', 'icon', 'img'], 'string', 'max' => 255],
			[['ref_restaurant_id'],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => RefRestaurant::class,
			 'targetAttribute' => ['ref_restaurant_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return array_merge(static::labels(), parent::attributeLabels());
	}

	public static function labels()
	{
		return [
			static::ATTR_ID                => 'ID',
			static::ATTR_NAME              => 'Название',
			static::ATTR_ICON              => 'Иконка',
			static::ATTR_IMG               => 'Изображение',
			static::ATTR_STATUS            => 'Статус',
			static::ATTR_REF_RESTAURANT_ID => 'Ресторан',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurant()
	{
		return $this->hasOne(RefRestaurant::class, ['id' => 'ref_restaurant_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefFoods()
	{
		return $this->hasMany(RefFoods::className(), ['ref_food_category_id' => 'id'])->inverseOf('refFoodCategory');
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefFoodCategoriesQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefFoodCategoriesQuery(get_called_class());
	}

	/**
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public static function getStatusVariants()
	{
		return [
			static::STATUS_ACTIVE   => 'Включено',
			static::STATUS_INACTIVE => 'Выключено',

		];
	}


}
