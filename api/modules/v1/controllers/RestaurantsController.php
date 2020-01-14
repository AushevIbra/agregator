<?php


namespace app\modules\v1\controllers;


use app\modules\v1\models\search\restaurant\ApiRestaurantSearch;
use app\modules\v1\models\views\restaurant\RestaurantView;
use common\models\db\RefRestaurant;
use Yii;

class RestaurantsController extends ApiController
{
	public function actionIndex()
	{
		$search = new ApiRestaurantSearch;
		return $search->search(Yii::$app->request->queryParams);
	}

	public function actionView(string $slug)
	{
		$restaurant = RefRestaurant::findOne([RefRestaurant::ATTR_SLUG => $slug]);

		if (null !== $restaurant) {
			return new RestaurantView($restaurant);
		}

		return null;
	}
}