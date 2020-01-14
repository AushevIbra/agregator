<?php


namespace app\modules\v1\controllers;


use common\models\db\RefRestaurantCategories;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;

class ApiActiveController extends ActiveController
{

	/**
	 * {@inheritdoc}
	 *
	 * @author
	 */
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();

		// remove authentication filter
		$auth = $behaviors['authenticator'];
		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		return array_merge($behaviors, [
			[
				'class'   => ContentNegotiator::class,
				'formats' => [
					'application/json' => Yii::$app->response::FORMAT_JSON,
				]
			],
		]);
	}
}