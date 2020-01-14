<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\db\RefFoodCategories;
use yii\validators\NumberValidator;
use yii\validators\SafeValidator;

/**
 * FoodCategoriesSearch represents the model behind the search form of `common\models\db\RefFoodCategories`.
 */
class FoodCategoriesSearch extends \common\yii\base\Model
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
	 * @var int
	 */
	public $status;
	const ATTR_STATUS = 'status';

	/**
	 * @var int
	 */
	public $ref_restaurant_id;
	const ATTR_REF_RESTAURANT_ID = 'ref_restaurant_id';

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[[static::ATTR_ID, static::ATTR_STATUS, static::ATTR_REF_RESTAURANT_ID], NumberValidator::class],
			[[static::ATTR_NAME,], SafeValidator::class],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}



	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = RefFoodCategories::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			RefFoodCategories::ATTR_ID                => $this->id,
			RefFoodCategories::ATTR_STATUS            => $this->status,
			RefFoodCategories::ATTR_REF_RESTAURANT_ID => $this->restaurant->id,
		]);

		$query->andFilterWhere(['like', RefFoodCategories::ATTR_NAME, $this->name]);

		return $dataProvider;
	}
}
