<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "ref_restaurant_categories".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $img
 * @property int|null $status
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property RefRestaurantLnkCategories[] $refRestaurantLnkCategories
 * @property RefRestaurant[] $refRestaurants
 */
class RefRestaurantCategories extends \common\yii\base\ActiveRecord
{
	const ATTR_ID     = 'id';
	const ATTR_NAME   = 'name';
	const ATTR_ICON   = 'icon';
	const ATTR_IMG    = 'img';
	const ATTR_STATUS = 'status';

	const STATUS_ACTIVE   = 1;
	const STATUS_INACTIVE = 0;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_restaurant_categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['status'], 'integer'],
			[['created_at', 'updated_at', 'deleted_at'], 'safe'],
			[['name', 'icon', 'img'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'         => 'ID',
			'name'       => 'Name',
			'icon'       => 'Icon',
			'img'        => 'Img',
			'status'     => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurantLnkCategories()
	{
		return $this->hasMany(RefRestaurantLnkCategories::class, ['ref_restaurant_categories_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurants()
	{
		return $this->hasMany(RefRestaurant::class,
			['id' => 'ref_restaurant_id'])->viaTable('ref_restaurant_lnk_categories',
			['ref_restaurant_categories_id' => 'id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefRestaurantCategoriesQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefRestaurantCategoriesQuery(get_called_class());
	}
}
