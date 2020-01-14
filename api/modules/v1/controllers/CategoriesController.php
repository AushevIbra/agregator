<?php


namespace app\modules\v1\controllers;


use app\modules\v1\models\api\ApiCategories;
use common\models\db\RefRestaurantCategories;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;

class CategoriesController extends ApiActiveController
{
	public $modelClass = ApiCategories::class;

}