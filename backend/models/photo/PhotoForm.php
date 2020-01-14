<?php

declare(strict_types=1);

namespace backend\models\photo;

use yii\base\Model;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

/**
 * Форма для загрузки изображений.
 *
 * @author Ibra Aushev <aushevibra@yandex.ru>
 */
class PhotoForm extends Model
{
	/** @var UploadedFile */
	public $file;
	const ATTR_FILE = 'file';

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function rules(): array
	{
		return [
			[static::ATTR_FILE, ImageValidator::class],
		];
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function beforeValidate(): bool
	{
		if (false === parent::beforeValidate()) {
			return false;
		}
		$this->file = UploadedFile::getInstance($this, 'file');

		return true;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Ibra Aushev <aushevibra@yandex.ru>
	 */
	public function attributeLabels(): array
	{
		return [
			static::ATTR_FILE => 'Загрузить обложку',
		];
	}
}
