<?php

declare(strict_types=1);

namespace common\components\upload;

use frostealth\yii2\aws\s3\Service as BaseService;

/**
 * Class Service
 *
 * @author Nikita Bolshebratskii <nik.kg@ya.ru>
 */
class Service extends BaseService {
	/**
	 * @param string $endpoint
	 */
	public function setEndpoint(string $endpoint) {
		$this->clientConfig['endpoint'] = $endpoint;
	}
	/**
	 * @param string $version
	 */
	public function setVersion(string $version) {
		$this->clientConfig['version'] = $version;
		$this->clientConfig['use_path_style_endpoint'] = true;
	}
}