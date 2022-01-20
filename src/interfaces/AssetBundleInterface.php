<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\interfaces;

interface AssetBundleInterface {

	/**
	 * returns an array of registered script handles this script depends on.
	 * This will pased as 3rd params to wp_enqueue_script()
	 */
	public function getJsDeps(): array;

}
