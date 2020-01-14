<?php

namespace common\models\db\queries;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefUserLnkRestaurant]].
 *
 * @see \common\models\db\RefUserLnkRestaurant
 */
class RefUserLnkRestaurantQuery extends \common\yii\base\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\db\RefUserLnkRestaurant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\db\RefUserLnkRestaurant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
