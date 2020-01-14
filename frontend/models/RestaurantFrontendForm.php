<?php

namespace frontend\models;

use common\models\db\RefRestaurant;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;

/**
 * Форма для добавление ресторана
 */
class RestaurantFrontendForm extends Model
{
	/**
	 * @var string Название ресторана
	 */
	public $name;
	const ATTR_NAME = 'name';

	/**
	 * @var string Описание ресторана
	 */
	public $description;
	const ATTR_DESCRIPTION = 'description';
	/**
	 * @var RefRestaurant
	 */
	private $model;

	public function __construct(RefRestaurant $model, $config = [])
	{
		$this->model = $model;
		parent::__construct($config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[static::ATTR_NAME, RequiredValidator::class],
			[static::ATTR_DESCRIPTION, SafeValidator::class],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			static::ATTR_NAME        => 'Название ресторана',
			static::ATTR_DESCRIPTION => 'Описание ресторана (Не обязательно)',
		];
	}

	/**
	 * Сохранение ресторана
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function save()
	{
		/**
		 * @var User $user
		 */
		$user = Yii::$app->user->identity;

		if (null !== $user->restaurant) {
			Yii::$app->session->setFlash('error', 'Вы уже создавали ресторан!');
			return false;
		}

		$transaction = Yii::$app->db->beginTransaction();
		try {
			$auth = Yii::$app->authManager;


			$this->model->name        = $this->name;
			$this->model->description = $this->description;
			$this->model->status      = RefRestaurant::STATUS_WAIT;
			$this->model->img         = 'test';
			$this->model->save();

			$user->assignRestaurant($this->model->id);
			$auth->assign($auth->getRole(User::ROLE_ADMIN), $user->id);
			$transaction->commit();

			return true;

		} catch (\Throwable $exception) {
			$transaction->rollBack();
			return false;
		}
	}

}
