<?php

declare(strict_types=1);

namespace common\components\upload\interfaces;

use common\behaviors\FileUploadBehavior;
use common\behaviors\ImageUploadBehavior;
use igogo5yo\uploadfromurl\UploadFromUrl;
use PHPThumb\GD;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yiidreamteam\upload\exceptions\FileUploadException;

/**
 * Методы работы с файлами на сервере
 *
 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
 */
class DefaultFileUpload implements FileUploadInterface {
	/**
	 * @param UploadedFile|UploadFromUrl $file     Файл временно загруженный на сервер из формы
	 * @param FileUploadBehavior         $behavior Поведение из которого вызывается
	 *
	 * @return string
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function uploadFile($file, FileUploadBehavior $behavior) {
		$path = $this->getUploadedFilePath($behavior);

		FileHelper::createDirectory(pathinfo($path, PATHINFO_DIRNAME), 0775, true);

		if (!$file->saveAs($path)) {
			throw new FileUploadException($file->error, 'File saving error.');
		}
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function deleteFile(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->filePath);

		@unlink($path);
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @return resource
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getFileAsResource(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->filePath);

		return fopen($path, 'r');
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @return string
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getFileAsString(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->filePath);

		return file_get_contents($path);
	}


	/**
	 * @param ImageUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function createThumbs(ImageUploadBehavior $behavior) {
		$path = $this->getUploadedFilePath($behavior);

		foreach ($behavior->thumbs as $profile => $config) {
			$thumbPath = $this->getThumbFilePath($behavior, $behavior->attribute, $profile); // Путь куда сохранять

			if (is_file($path) && !is_file($thumbPath)) {
				// setup image processor function
				if (isset($config['processor']) && is_callable($config['processor'])) {
					$processor = $config['processor'];
					unset($config['processor']);
				}
				else {
					$processor = function (GD $thumb) use ($config) {
						$thumb->adaptiveResize($config['width'], $config['height']);
					};
				}

				$thumb = new GD($path, $config);
				call_user_func($processor, $thumb, $behavior->attribute);
				FileHelper::createDirectory(pathinfo($thumbPath, PATHINFO_DIRNAME), 0775, true);
				$thumb->save($thumbPath);
			}
		}
	}

	/**
	 * Возвращает путь до сохраненного файла к атрибуту
	 *
	 * @param FileUploadBehavior $behavior
	 *
	 * @return string Путь
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	protected function getUploadedFilePath(FileUploadBehavior $behavior): string {
		$behavior = $behavior::getInstance($behavior->owner, $behavior->attribute);

		if (!$behavior->owner->{$behavior->attribute}) {
			return '';
		}

		return $behavior->resolvePath($behavior->filePath);
	}

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @return string
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getThumbFileUrl(ImageUploadBehavior $behavior, string $profile) {
		return $behavior->resolveProfilePath($behavior->thumbUrl, $profile);
	}

	/**
	 * Возвращает путь thumb файла
	 *
	 * @param ImageUploadBehavior $behavior
	 * @param string              $attribute
	 * @param string              $profile
	 *
	 * @return string
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getThumbFilePath(ImageUploadBehavior $behavior, $attribute, $profile = 'thumb'): string {
		$instance = ImageUploadBehavior::getInstance($behavior->owner, $attribute);

		return $behavior->resolveProfilePath($instance->thumbPath, $profile);
	}

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function cleanThumbFile(ImageUploadBehavior $behavior, string $profile) {
		@unlink($this->getThumbFilePath($behavior, $behavior->attribute, $profile));
	}
}