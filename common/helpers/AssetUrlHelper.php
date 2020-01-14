<?php

namespace common\helpers;

use yii\base\InvalidCallException;

class AssetUrlHelper {
	public static function include(string $filename): string {
		$filepath = \Yii::getAlias("@frontend/web/{$filename}");

		if (false === file_exists($filepath)) {
			throw new InvalidCallException();
		}

		$timestamp = @filemtime($filepath);

		return sprintf('%s?v=%d', $filename, $timestamp);
	}

}