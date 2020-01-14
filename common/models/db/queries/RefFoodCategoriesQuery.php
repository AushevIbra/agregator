<?php

namespace common\models\db\queries;

use common\models\db\RefFoods;
use common\yii\base\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefFoodCategories]].
 *
 * @see \common\models\db\RefFoodCategories
 */
class RefFoodCategoriesQuery extends ActiveQuery
{
	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefFoodCategories[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefFoodCategories|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}

	public function joinFood($params = [])
	{
		$this->joinWith('refFoods')
			->andFilterWhere(
				['like',
				 implode('.', [RefFoods::tableName(), RefFoods::ATTR_NAME]),
				 $params['name'] ?? ''
				]
			);
	}

}
