<?php

namespace common\models\db;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ref_user_lnk_restaurants".
 *
 * @property int $user_id
 * @property int $ref_restaurant_id
 *
 * @property RefRestaurant $refRestaurant
 * @property User $user
 */
class RefUserLnkRestaurants extends ActiveRecord
{
	const ATTR_USER_ID           = 'user_id';
	const ATTR_REF_RESTAURANT_ID = 'ref_restaurant_id';

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_user_lnk_restaurants';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id', 'ref_restaurant_id'], 'required'],
			[['user_id', 'ref_restaurant_id'], 'integer'],
			[['user_id', 'ref_restaurant_id'], 'unique', 'targetAttribute' => ['user_id', 'ref_restaurant_id']],
			[['ref_restaurant_id'],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => RefRestaurant::class,
			 'targetAttribute' => ['ref_restaurant_id' => 'id']],
			[['user_id'],
			 'exist',
			 'skipOnError'     => true,
			 'targetClass'     => User::class,
			 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'user_id'           => 'User ID',
			'ref_restaurant_id' => 'Ref Restaurant ID',
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
	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefUserLnkRestaurantsQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefUserLnkRestaurantsQuery(get_called_class());
	}
}
