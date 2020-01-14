<?php

namespace app\modules\v1\models\api;


use common\models\db\RefRestaurantCategories;

class ApiCategories extends RefRestaurantCategories
{
	public function fields()
	{
		return [static::ATTR_ID, static::ATTR_IMG, static::ATTR_ICON, static::ATTR_NAME];
	}
}