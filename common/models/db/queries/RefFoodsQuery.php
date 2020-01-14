<?php

namespace common\models\db\queries;

use common\yii\base\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefFoods]].
 *
 * @see \common\models\db\RefFoods
 */
class RefFoodsQuery extends ActiveQuery
{
	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefFoods[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\RefFoods|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
