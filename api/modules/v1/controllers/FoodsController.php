<?php

namespace app\modules\v1\controllers;


use app\modules\v1\models\ApiFoodCategorySearch;
use common\models\db\RefFoodCategories;
use common\models\db\RefFoods;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Food controller for the `v1` module
 */
class FoodsController extends ApiController
{


	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		return array_merge([
			[
				'class'   => ContentNegotiator::class,
				'formats' => [
					'application/json' => Yii::$app->response::FORMAT_JSON,
				]
			],
		], $behaviors);
	}

	public function actionIndex()
	{
		$search = new ApiFoodCategorySearch();

		return $search->search(Yii::$app->request->queryParams);
	}

}
