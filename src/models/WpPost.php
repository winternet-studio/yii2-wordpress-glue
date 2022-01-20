<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\models;

use yii\db\ActiveQuery;
use winternet\yii2wordpress\db\ActiveRecord;

class WpPost extends ActiveRecord {

	public static function tableName() {
		global $wpdb;
		return $wpdb->posts;
	}

	public function findPostPage(): ActiveQuery {
		$finder = static::find();
		$finder->andWhere([
			'post_type' => ['post', 'page'],
			'post_status' => ['draft', 'publish', 'inherit'],
		]);

		return $finder;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getMeta() {
		return $this->hasMany(WpPostMeta::class, ['post_id' => 'ID']);
	}

}
