<?php

namespace common\models\db\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefUserLnkRestaurants]].
 *
 * @see \common\models\db\RefUserLnkRestaurants
 */
class RefUserLnkRestaurantsQuery extends ActiveQuery
{
	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefUserLnkRestaurants[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefUserLnkRestaurants|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
