<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\db\RefFoods;
use yii\validators\NumberValidator;
use yii\validators\SafeValidator;

/**
 * FoodsSearch represents the model behind the search form of `common\models\db\RefFoods`.
 */
class FoodsSearch extends \common\yii\base\Model
{
	/**
	 * @var int
	 */
	public $id;
	const ATTR_ID = 'id';
	/**
	 * @var
	 */
	public $name;
	const ATTR_NAME = 'name';
	/**
	 * @var int
	 */
	public $ref_restaurant_id;
	const ATTR_REF_RESTAURANT_ID = 'ref_restaurant_id';

	/**
	 * @var string
	 */
	public $ref_food_category_id;
	const ATTR_REF_FOOD_CATEGORY_ID = 'ref_food_category_id';

	/**
	 * @var int
	 */
	public $status;
	const ATTR_STATUS = 'status';

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[[static::ATTR_ID, static::ATTR_REF_RESTAURANT_ID, static::ATTR_REF_FOOD_CATEGORY_ID, static::ATTR_STATUS],
			 NumberValidator::class],
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

	public function attributeLabels()
	{
		return [
			static::ATTR_ID     => 'ID',
			static::ATTR_NAME   => 'Название',
			static::ATTR_STATUS => 'Статус'
		];
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
		$query = RefFoods::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			static::ATTR_ID                   => $this->id,
			static::ATTR_REF_FOOD_CATEGORY_ID => $this->ref_food_category_id,
			static::ATTR_REF_RESTAURANT_ID    => $this->restaurant->id,
			static::ATTR_STATUS               => $this->status,
		]);

		$query->andFilterWhere(['like', static::ATTR_NAME, $this->name]);

		return $dataProvider;
	}
}
