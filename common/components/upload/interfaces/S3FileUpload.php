<?php

declare(strict_types=1);

namespace common\components\upload\interfaces;

use Aws\S3\Exception\S3Exception;
use common\behaviors\FileUploadBehavior;
use common\behaviors\ImageUploadBehavior;
use frostealth\yii2\aws\s3\Service;
use GuzzleHttp\Psr7\Stream;
use igogo5yo\uploadfromurl\UploadFromUrl;
use PHPThumb\GD;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\UploadedFile;

/**
 * Методы работы с S3 файлами
 *
 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
 */
class S3FileUpload implements FileUploadInterface {
	/** @var Service $s3 */
	public $s3;

	/**
	 * S3FileUpload constructor.
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function __construct() {
		$this->s3 = Yii::$app->get('s3');
	}

	/**
	 * @param UploadedFile|UploadFromUrl $file     Файл временно загруженный на сервер из формы
	 * @param FileUploadBehavior         $behavior Поведение из которого вызывается
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function uploadFile($file, FileUploadBehavior $behavior) {

		if (null === $behavior->s3AbsolutePath) {
			throw new InvalidConfigException('У модели должен быть задан s3AbsolutePath');
		}

		$tempUploadedFilepath = $file->tempName;
		$path = $behavior->resolvePath($behavior->s3AbsolutePath);

		$this->s3->commands()->upload($path, $tempUploadedFilepath)->execute();
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function deleteFile(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->s3AbsolutePath);

		try {
			$this->s3->commands()->delete($path)->execute();
		} catch (S3Exception $e) {
			Yii::error($e->getMessage());
		}
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getFileAsResource(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->s3AbsolutePath);

		return $this->getFileStreamByPath($path)->detach();
	}

	/**
	 * @param FileUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getFileAsString(FileUploadBehavior $behavior) {
		$path = $behavior->resolvePath($behavior->s3AbsolutePath);

		return $this->getFileStreamByPath($path)->getContents();
	}

	/**
	 * @param string $path
	 *
	 * @return Stream
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	private function getFileStreamByPath(string $path) {
		return $this->s3->commands()->get($path)->execute()->get('Body');
	}

	/**
	 * Создание миниатюр для оригинального изображения
	 *
	 * @param ImageUploadBehavior $behavior
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function createThumbs(ImageUploadBehavior $behavior) {
		$path = $this->getUploadedS3FilePath($behavior);

		// -- Получаем и сохраняем в tmp оригинальное изображение из S3
		try {
			$tempFilePath = tempnam(sys_get_temp_dir(), 'img');

			$this->s3->commands()->get($path)->saveAs($tempFilePath)->execute();
		} catch (S3Exception $e) {
			// Если не существует оригинала или файл не удалось получить
			return;
		}
		// -- -- -- --

		foreach ($behavior->thumbs as $profile => $config) {
			$thumbPath = $this->getThumbFilePath($behavior, $behavior->attribute, $profile); // Путь куда сохранять

			if (is_file($tempFilePath) && '' !== ($thumbPath)) {
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

				// Путь для временного хранения thumb версии картинки
				$tempThumbFilePath = tempnam(sys_get_temp_dir(), 'img');

				try {
					// -- Создаём thumb версию картинки
					$thumb = new GD($tempFilePath, $config);
					call_user_func($processor, $thumb, $behavior->attribute);
					$thumb->save($tempThumbFilePath);
					// -- -- -- --

					// Загружаем созданную картинку на S3
					$this->s3->commands()->upload($thumbPath, $tempThumbFilePath)->execute();
				} catch (Throwable $e) {
					// Удаляем временные файлы в случае ошибки
					unlink($tempFilePath);
					unlink($tempThumbFilePath);

					throw $e;
				}
				unlink($tempThumbFilePath);
			}
		}
		unlink($tempFilePath);
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
	protected function getUploadedS3FilePath(FileUploadBehavior $behavior): string {
		$behavior = $behavior::getInstance($behavior->owner, $behavior->attribute);

		if (!$behavior->owner->{$behavior->attribute}) {
			return '';
		}

		return $behavior->resolvePath($behavior->s3AbsolutePath);
	}

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @return string
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function getThumbFileUrl(ImageUploadBehavior $behavior, string $profile): string {
		return $behavior->resolveProfilePath($behavior->s3ThumbAbsolutePath, $profile);
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
		$instance = $behavior::getInstance($behavior->owner, $attribute);

		return $behavior->resolveProfilePath($instance->s3ThumbAbsolutePath, $profile);
	}

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
	 */
	public function cleanThumbFile(ImageUploadBehavior $behavior, string $profile) {
		$path = $this->getThumbFilePath($behavior, $behavior->attribute, $profile);

		$this->s3->commands()->delete($path)->execute();
	}
}