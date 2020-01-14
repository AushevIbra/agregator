<?php


namespace app\modules\v1\models;


use app\modules\v1\models\views\foodCategory\FoodCategoryItem;
use app\modules\v1\models\views\foodCategory\FoodCategoryView;
use common\models\db\RefFoodCategories;
use common\models\db\RefFoods;
use common\models\db\RefRestaurant;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

class ApiFoodCategorySearch extends RefFoodCategories
{
	/**
	 * @var int
	 */
	public $id;
	const ATTR_ID = 'id';
	/**
	 * @var string
	 */
	public $name;
	const ATTR_NAME = 'name';

	/**
	 * @var string
	 */
	public $price;
	const ATTR_PRICE = 'price';

	/**
	 * @var string
	 */
	public $restaurant;
	const ATTR_RESTAURANT = 'restaurant';


	/**
	 * {@inheritDoc}
	 *
	 * @return string
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function formName()
	{
		return '';
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, StringValidator::class],
			[static::ATTR_ID, NumberValidator::class],
			[static::ATTR_RESTAURANT, RequiredValidator::class]
		];
	}


	public function search(array $params)
	{
		$this->load($params);

		$restaurant = RefRestaurant::findOne([RefRestaurant::ATTR_SLUG => $this->restaurant]);

		$result = [];

		if (false === $this->validate() || null === $restaurant) {
			return $result;
		}

		$query = RefFoodCategories::find();


		// grid filtering conditions
		$query->andFilterWhere([
			RefFoodCategories::ATTR_ID => $this->id,
			implode('.', [RefFoodCategories::tableName(), RefFoodCategories::ATTR_REF_RESTAURANT_ID]) => $restaurant->id,
		]);

//		$query->andFilterWhere(['like', RefFoodCategories::ATTR_NAME, $this->name]);
		$query->joinFood(['name' => $this->name]);


		foreach ($query->all() as $row) {
			$item = new FoodCategoryView($row);

			$result[] = $item;
		}

		return $result;
	}

}