<?php

namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ref_restaurant_lnk_categories".
 *
 * @property int $ref_restaurant_id
 * @property int $ref_restaurant_categories_id
 *
 * @property RefRestaurantCategories $refRestaurantCategories
 * @property RefRestaurant $refRestaurant
 */
class RefRestaurantLnkCategories extends ActiveRecord
{
	const ATTR_REF_RESTAURANT_ID          = 'ref_restaurant_id';
	const ATTR_REF_RESTAURANT_CATEGORY_ID = 'ref_restaurant_categories_id';

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_restaurant_lnk_categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ref_restaurant_id', 'ref_restaurant_categories_id'], 'required'],
			[['ref_restaurant_id', 'ref_restaurant_categories_id'], 'integer'],
			[['ref_restaurant_id', 'ref_restaurant_categories_id'],
			 'unique',
			 'targetAttribute' => ['ref_restaurant_id', 'ref_restaurant_categories_id']],
			[['ref_restaurant_categories_id'],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => RefRestaurantCategories::class,
			 'targetAttribute' => ['ref_restaurant_categories_id' => 'id']],
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
		return [
			'ref_restaurant_id'            => 'Ref Restaurant ID',
			'ref_restaurant_categories_id' => 'Ref Restaurant Categories ID',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurantCategories()
	{
		return $this->hasOne(RefRestaurantCategories::class, ['id' => 'ref_restaurant_categories_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurant()
	{
		return $this->hasOne(RefRestaurant::class, ['id' => 'ref_restaurant_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefRestaurantLnkCategoriesQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefRestaurantLnkCategoriesQuery(get_called_class());
	}
}
