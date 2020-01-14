<?php


namespace common\yii\base;


class ActiveQuery extends \yii\db\ActiveQuery
{
	public function init()
	{
		$class = '\\' . $this->modelClass;
		parent::init();

		$this->andOnCondition([$class::tableName() . '.' . $class::ATTR_DELETED_AT => null]);
	}
}