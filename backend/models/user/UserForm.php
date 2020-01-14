<?php


namespace backend\models\user;


use common\models\User;
use common\yii\base\Model;
use Yii;
use yii\validators\RequiredValidator;
use yii\validators\UniqueValidator;

class UserForm extends Model
{
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
	public $role;
	const ATTR_ROLE = 'role';
	/**
	 * @var User
	 */
	private $model;

	public function __construct(User $model, $config = [])
	{
		$this->model = $model;

		parent::__construct($config);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[static::ATTR_USERNAME, 'trim'],
			[static::ATTR_USERNAME, RequiredValidator::class],
			[static::ATTR_USERNAME,
			 'unique',
			 'targetClass' => User::class,
			 'message'     => 'Пользователь с таким логином уже есть'],
			[static::ATTR_USERNAME, 'string', 'min' => 2, 'max' => 255],

			[static::ATTR_EMAIL, 'trim'],
			[static::ATTR_EMAIL, 'required'],
			[static::ATTR_EMAIL, 'email'],
			[static::ATTR_EMAIL, 'string', 'max' => 255],
			[static::ATTR_EMAIL,
			 'unique',
			 'targetClass' => User::class,
			 'message'     => 'Пользователь с таким E-mail уже есть'],

			[static::ATTR_ROLE, RequiredValidator::class]
		];
	}

	public function attributeLabels()
	{
		return [
			static::ATTR_USERNAME => 'Логин',
			static::ATTR_EMAIL    => 'Почта',
			static::ATTR_ROLE     => 'Роль',
		];
	}

	public function getRoles()
	{
		return $this->model::getRoleVariants();
	}

	public function save()
	{
		$authManager = Yii::$app->authManager;

		if (false === $this->validate()) {
			return false;
		}
		$this->model->username = $this->username;
		$this->model->email    = $this->email;
		$this->model->setPassword('11111111');
		$this->model->generateAuthKey();
		$this->model->generateEmailVerificationToken();

		if (true === $this->model->save()) {
			$authManager->assign($authManager->getRole($this->role), $this->model->id);
			$this->model->assignRestaurant($this->restaurant->id);
			$this->sendEmail($this->model);
			return true;
		}

		return false;
	}

	/**
	 * Sends confirmation email to user
	 * @param User $user user model to with email should be send
	 * @return bool whether the email was sent
	 */
	protected function sendEmail($user)
	{
		return Yii::$app
			->mailer
			->compose(
				['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
				['user' => $user]
			)
			->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
			->setTo($this->email)
			->setSubject('Account registration at ' . Yii::$app->name)
			->send();
	}

}