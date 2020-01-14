<?php

namespace common\models\db\queries;

/**
 * This is the ActiveQuery class for [[\common\models\db\RefRestaurantCategories]].
 *
 * @see \common\models\db\RefRestaurantCategories
 */
class RefRestaurantCategoriesQuery extends \common\yii\base\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\db\RefRestaurantCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\db\RefRestaurantCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
