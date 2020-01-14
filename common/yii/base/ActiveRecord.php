<?php


namespace common\yii\base;

use DateTime;
use yii\behaviors\TimestampBehavior;
use zalatov\runtimeCache\RuntimeCacheTrait;

/**
 * Class ActiveRecord
 *
 * @author Aushev Ibra <aushevibra@yandex.ru>
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
	use RuntimeCacheTrait;

	const ATTR_CREATED_AT = 'created_at';
	const ATTR_UPDATED_AT = 'updated_at';
	const ATTR_DELETED_AT = 'deleted_at';


	public function delete()
	{
		$this->deleted_at = (new DateTime('now'))->format('Y-m-d h:m:s');
		$this->save(false, [static::ATTR_DELETED_AT]);

		return 1;
	}

	/**
	 * @return array
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::class,
				'createdAtAttribute' => static::ATTR_CREATED_AT,
				'updatedAtAttribute' => static::ATTR_UPDATED_AT,
				'value'              => (new DateTime('now'))->format('Y-m-d h:m:s'),
			],
		];
	}

	public function attributeLabels()
	{
		return [
			static::ATTR_CREATED_AT => 'Дата создания',
			static::ATTR_UPDATED_AT => 'Дата редактирования',
			static::ATTR_DELETED_AT => 'Дата удаления',
		];
	}

	/**
	 * Получить закешированную модель
	 *
	 * @param int $id
	 * @return static|null
	 *
	 * @author Aushev Ibra <aushevibra@yandex.ru>
	 */
	public static function getModel(int $id): ?self
	{
		return static::globalRuntimeCache([__CLASS__, __METHOD__, $id], function () use ($id) {
			return static::findOne($id);
		});
	}
}