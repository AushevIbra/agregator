<?php

namespace common\models\db\queries;

/**
 * This is the ActiveQuery class for [[\common\models\db\User]].
 *
 * @see \common\models\db\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\db\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\db\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
