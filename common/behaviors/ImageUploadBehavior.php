<?php

declare(strict_types=1);

namespace common\behaviors;

use yii\helpers\ArrayHelper;

class ImageUploadBehavior extends FileUploadBehavior {
	public $attribute = 'image';

	public $createThumbsOnSave = true;
	public $createThumbsOnRequest = false;

	/** @var array Thumbnail profiles, array of [width, height, ... PHPThumb options] */
	public $thumbs = [];

	/** @var string Path template for thumbnails. Please use the [[profile]] placeholder. */
	public $thumbPath = '@webroot/images/[[profile]]_[[pk]].[[extension]]';
	/** @var string Url template for thumbnails. */
	public $thumbUrl = '/images/[[profile]]_[[pk]].[[extension]]';
	/** @var string S3 path template for thumbnails. */
	public $s3ThumbAbsolutePath;

	public $filePath = '@webroot/images/[[pk]].[[extension]]';
	public $fileUrl = '/images/[[pk]].[[extension]]';

	/**
	 * @inheritdoc
	 */
	public function events() {
		return ArrayHelper::merge(parent::events(), [
			static::EVENT_AFTER_FILE_SAVE => 'afterFileSave',
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function cleanFiles() {
		parent::cleanFiles();

		foreach (array_keys($this->thumbs) as $profile) {
			$this->uploader->cleanThumbFile($this, $profile);
		}
	}

	/**
	 * Resolves profile path for thumbnail profile.
	 *
	 * @param string $path
	 * @param string $profile
	 *
	 * @return string
	 */
	public function resolveProfilePath($path, $profile) {
		$path = $this->resolvePath($path);

		return preg_replace_callback('|\[\[([\w\_/]+)\]\]|', function ($matches) use ($profile) {
			$name = $matches[1];
			switch ($name) {
				case 'profile':
					return $profile;
			}

			return '[[' . $name . ']]';
		}, $path);
	}

	/**
	 *
	 * @param string      $attribute
	 * @param string|null $emptyUrl
	 *
	 * @return string|null
	 */
	public function getImageFileUrl($attribute, $emptyUrl = null) {
		if (!$this->owner->{$attribute}) {
			return $emptyUrl;
		}

		return $this->getUploadedFileUrl($attribute);
	}

	/**
	 * @param string      $attribute
	 * @param string      $profile
	 * @param string|null $emptyUrl
	 *
	 * @return string|null
	 */
	public function getThumbFileUrl($attribute, $profile = 'thumb', $emptyUrl = null) {
		if (!$this->owner->{$attribute}) {
			return $emptyUrl;
		}

		$behavior = static::getInstance($this->owner, $attribute);

		// Если проверять существуют ли на S3 миниатюры при каждом запросе на каждую миниатюру
		// То будет очень долгий ответ сервера
		//  if ($behavior->createThumbsOnRequest) {
		//  $behavior->createThumbs();
		//  }

		return $behavior->resolveProfilePath($behavior->thumbUrl, $profile);
	}

	/**
	 * Creates image thumbnails
	 */
	public function createThumbs() {
		$this->uploader->createThumbs($this);
	}

	/**
	 * After file save event handler.
	 */
	public function afterFileSave() {
		$this->createThumbs();
	}
}