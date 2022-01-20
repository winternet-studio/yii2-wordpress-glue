<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\models;

use yii\db\ActiveQuery;
use winternet\yii2wordpress\db\ActiveRecord;

class WpPostMeta extends ActiveRecord {

	public static function tableName() {
		global $wpdb;
		return $wpdb->postmeta;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPost() {
		return $this->hasOne(WpPost::class, ['ID' => 'post_id']);
	}

	/**
	 * @return \WP_Post
	 */
	public function getWpPost() {
		return get_post($this->post_id);
	}

	/**
	 * @return \WP_Post
	 */
	public function getWpPostMeta() {
		return get_post_meta($this->meta_id, $this->meta_key);
	}

}
