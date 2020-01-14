<?php

namespace common\models\db\queries;

use common\models\db\RefRestaurant;
use common\models\db\RefRestaurantCategories;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefRestaurant]].
 *
 * @see \common\models\db\RefRestaurant
 */
class RefRestaurantQuery extends \common\yii\base\ActiveQuery
{
	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefRestaurant[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefRestaurant|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}

	public function joinRestaurantCategories($params = [])
	{
		$this->joinWith(RefRestaurant::WITH_RESTAURANT_CATEGORIES)
			->andFilterWhere(
				['=',
				 implode('.', [RefRestaurantCategories::tableName(), RefRestaurantCategories::ATTR_ID]),
				 $params['id'] ?? ''
				]
			);
	}
}
