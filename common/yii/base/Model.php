<?php

declare(strict_types=1);

namespace common\yii\base;

use common\models\db\RefRestaurant;
use common\models\User;
use elisdn\compositeForm\CompositeForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;
use zalatov\runtimeCache\RuntimeCacheTrait;

/**
 * @inheritdoc
 *
 * @author Залатов Александр <zalatov.ao@gmail.com>
 */
class Model extends CompositeForm
{
	/**
	 * @var User
	 */
	public $user;

	/**
	 * @var RefRestaurant
	 */
	public $restaurant;
	use RuntimeCacheTrait;

	public function init()
	{
		$this->user       = Yii::$app->user->identity;
		$this->restaurant = $this->user->restaurant;
	}

	/**
	 * @param ActiveQueryInterface $query
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function getDataProvider(ActiveQueryInterface $query, array $params = []): ActiveDataProvider
	{
		return new ActiveDataProvider(ArrayHelper::merge([
			'query' => $query,
		], $params));
	}

	/**
	 * @inheritDoc
	 */
	protected function internalForms()
	{
		// TODO: Implement internalForms() method.
	}

	public function attributeLabels()
	{
		return [
			'name'   => 'Название',
			'status' => 'Статус',
		];
	}
}
