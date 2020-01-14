<?php

namespace backend\controllers;

use backend\models\restaurant\RestaurantForm;
use common\models\db\RefRestaurant;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
	const ACTION_RESTAURANT = 'restaurant';
	/**
	 * @var User
	 */
	private $user;

	/**
	 * {@inheritDoc}
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function init()
	{
		$this->user = Yii::$app->user->identity;
	}


	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['login', 'error'],
						'allow'   => true,
					],
					[
						'actions' => ['logout', 'index'],
						'allow'   => true,
						'roles'   => ['admin'],
					],

					[
						'actions' => [static::ACTION_RESTAURANT],
						'allow'   => true,
						'roles'   => [User::ROLE_MODERATOR]
					]
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		$this->layout = '_clear';
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			$model->password = '';

			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	public function actionRestaurant()
	{
		$form = new RestaurantForm($this->user->restaurant);

		if ($form->load(Yii::$app->request->post()) && $form->save()) {
			Yii::$app->session->setFlash('success',
				'Информация о ресторане успешно обновлена!');
		}

		return $this->render('restaurant', ['form' => $form]);
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
