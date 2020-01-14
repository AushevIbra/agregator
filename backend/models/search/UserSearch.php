<?php

namespace backend\models\search;

use common\models\db\RefUserLnkRestaurants;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends \common\yii\base\Model
{
	/**
	 * @var int
	 */
	public $id;
	const ATTR_ID = 'id';

	/**
	 * @var string
	 */
	public $username;
	const ATTR_USERNAME = 'username';

	/**
	 * @var string
	 */
	public $email;
	const ATTR_EMAIL = 'email';

	/**
	 * @var string
	 */
	public $status;
	const ATTR_STATUS = 'status';

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'status',], 'integer'],
			[['username', 'email',], 'safe'],
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
		$query = User::find();

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
		$query->leftJoin(RefUserLnkRestaurants::tableName(),
			RefUserLnkRestaurants::ATTR_USER_ID . '=' . implode('.', [User::tableName(), User::ATTR_ID]));

		$query->andWhere([
			'=',
			implode('.', [RefUserLnkRestaurants::tableName(), RefUserLnkRestaurants::ATTR_REF_RESTAURANT_ID]),
			$this->restaurant->id
		]);
		// grid filtering conditions
		$query->andFilterWhere([
			'id'     => $this->id,
			'status' => $this->status,
		]);

		$query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'email', $this->email]);

		return $dataProvider;
	}
}
