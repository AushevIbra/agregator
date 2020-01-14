<?php

declare(strict_types=1);

namespace common\components\upload\interfaces;

use common\behaviors\FileUploadBehavior;
use common\behaviors\ImageUploadBehavior;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;

/**
 * Интерфейс для реализации различных способов работы с файлами
 *
 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
 */
interface FileUploadInterface {
	/**
	 * @param UploadedFile|UploadFromUrl $file     Файл временно загруженный на сервер из формы
	 * @param FileUploadBehavior         $behavior Поведение из которого вызывается
	 *
	 * @return string
	 */
	public function uploadFile($file, FileUploadBehavior $behavior);

	/**
	 * @param FileUploadBehavior $behavior
	 */
	public function deleteFile(FileUploadBehavior $behavior);

	/**
	 * @param FileUploadBehavior $behavior
	 */
	public function getFileAsResource(FileUploadBehavior $behavior);

	/**
	 * @param FileUploadBehavior $behavior
	 */
	public function getFileAsString(FileUploadBehavior $behavior);

	/**
	 * @param ImageUploadBehavior $behavior
	 *
	 * @return string
	 */
	public function createThumbs(ImageUploadBehavior $behavior);

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @return string
	 */
	public function getThumbFilePath(ImageUploadBehavior $behavior, $attribute, $profile = 'thumb');

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 *
	 * @return string
	 */
	public function getThumbFileUrl(ImageUploadBehavior $behavior, string $profile);

	/**
	 * @param ImageUploadBehavior $behavior
	 * @param string              $profile
	 */
	public function cleanThumbFile(ImageUploadBehavior $behavior, string $profile);
}