<?php

namespace common\models\db;

use common\behaviors\FileUploadBehavior;
use common\behaviors\SlugBehavior;
use common\models\User;
use Yii;
use yii\validators\SafeValidator;

/**
 * This is the model class for table "ref_restaurant".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $img
 * @property string|null $icon
 * @property int|null $status
 * @property int|null $min_amount
 * @property int|null $min_delivery_time
 * @property int|null $max_delivery_time
 * @property int|null $free_from
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property RefFoodCategories[] $refFoodCategories
 * @property RefFoods[] $refFoods
 * @property RefRestaurantLnkCategories[] $refRestaurantLnkCategories
 * @property RefRestaurantCategories[] $restaurantCategories
 * @property RefUserLnkRestaurants[] $refUserLnkRestaurants
 * @property User[] $users
 */
class RefRestaurant extends \common\yii\base\ActiveRecord
{
	const STATUS_WAIT     = 2;
	const STATUS_ACTIVE   = 1;
	const STATUS_INACTIVE = 0;

	const ATTR_ID                = 'id';
	const ATTR_NAME              = 'name';
	const ATTR_SLUG              = 'slug';
	const ATTR_DESCRIPTION       = 'description';
	const ATTR_IMG               = 'img';
	const ATTR_ICON              = 'icon';
	const ATTR_STATUS            = 'status';
	const ATTR_MIN_AMOUNT        = 'min_amount';
	const ATTR_MIN_DELIVERY_TIME = 'min_delivery_time';
	const ATTR_MAX_DELIVERY_TIME = 'max_delivery_time';
	const ATTR_FREE_FROM         = 'free_from';

	const WITH_RESTAURANT_CATEGORIES = 'restaurantCategories';

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'ref_restaurant';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'slug', 'img'], 'required'],
			[['description'], 'string'],
			[['status', 'min_amount', 'min_delivery_time', 'max_delivery_time', 'free_from'], 'integer'],
			[['created_at', 'updated_at', 'deleted_at', static::ATTR_IMG], SafeValidator::class],
			[['name', 'slug', 'icon'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			static::ATTR_ID                => 'ID',
			static::ATTR_NAME              => 'Название',
			static::ATTR_SLUG              => 'ЧПУ',
			static::ATTR_DESCRIPTION       => 'Описание',
			static::ATTR_IMG               => 'Изображение',
			static::ATTR_ICON              => 'Иконка',
			static::ATTR_STATUS            => 'Статус',
			static::ATTR_MIN_AMOUNT        => 'Минимальная сумма заказа',
			static::ATTR_MIN_DELIVERY_TIME => 'Минимальное время доставки',
			static::ATTR_MAX_DELIVERY_TIME => 'Максимальное время доставки',
			static::ATTR_FREE_FROM         => 'Бесплатная доставка от',
			static::ATTR_CREATED_AT        => 'Дата создания',
			static::ATTR_UPDATED_AT        => 'Дата обновления',
			static::ATTR_DELETED_AT        => 'Дата удаления',
		];
	}


	/**
	 * Добавить категорию.
	 *
	 * @param int $categoryId
	 *
	 * @return bool
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function assignCategory(int $categoryId): bool
	{
		// -- Проверяем есть ли у аудиосказки эта категория
		$check = RefRestaurantLnkCategories::find()
			->where([
				RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_ID          => $this->id,
				RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_CATEGORY_ID => $categoryId,
			])
			->exists();

		if (false !== $check) {
			return true;
		}
		// -- -- -- --

		// -- Привязываем аудиосказку к категории
		$link                               = new RefRestaurantLnkCategories;
		$link->ref_restaurant_id            = $this->id;
		$link->ref_restaurant_categories_id = $categoryId;

		return $link->save();
	}

	/**
	 * Удалить категорию.
	 *
	 * @param int $categoryId
	 *
	 * @return bool
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function revokeCategory(int $categoryId): bool
	{
		$link = RefRestaurantLnkCategories::findOne([
			RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_ID          => $this->id,
			RefRestaurantLnkCategories::ATTR_REF_RESTAURANT_CATEGORY_ID => $categoryId,
		]);

		if (false === $link) {
			return false;
		}

		$link->delete();

		return true;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefFoodCategories()
	{
		return $this->hasMany(RefFoodCategories::class, ['ref_restaurant_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefRestaurantLnkCategories()
	{
		return $this->hasMany(RefRestaurantLnkCategories::class, ['ref_restaurant_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRestaurantCategories()
	{
		return $this->hasMany(RefRestaurantCategories::class,
			['id' => 'ref_restaurant_categories_id'])->viaTable('ref_restaurant_lnk_categories',
			['ref_restaurant_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefUserLnkRestaurants()
	{
		return $this->hasMany(RefUserLnkRestaurants::class, ['ref_restaurant_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsers()
	{
		return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('ref_user_lnk_restaurants',
			['ref_restaurant_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefFoods()
	{
		return $this->hasMany(RefFoods::class, ['ref_restaurant_id' => 'id'])->inverseOf('refRestaurant');
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\db\queries\RefRestaurantQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \common\models\db\queries\RefRestaurantQuery(get_called_class());
	}

	/**
	 * {@inheritdoc}
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function behaviors()
	{
		return array_merge([
			'slug' => [
				'class'         => SlugBehavior::class,
				'in_attribute'  => 'name',
				'out_attribute' => 'slug',
				'translit'      => true,
			],
			[
				'class'          => FileUploadBehavior::class,
				'attribute'      => static::ATTR_IMG,
				'filePath'       => '@storageRoot/web/source/origin/restaurants/[[id]]/[[attribute_id]].[[extension]]',
				's3AbsolutePath' => 'source/origin/restaurants/[[id]]/[[attribute_id]].[[extension]]',
				'fileUrl'        => '@storage/source/origin/restaurants/[[id]]/[[attribute_id]].[[extension]]',
			],
		], parent::behaviors());

	}

	public static function getStatusVariants()
	{
		return [
			static::STATUS_WAIT     => 'В ожидании',
			static::STATUS_ACTIVE   => 'Включен',
			static::STATUS_INACTIVE => 'Выключен',
		];
	}

}
