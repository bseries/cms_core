<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\models;

use lithium\util\String;

class Tokens extends \lithium\data\Model {

	// Generates a random token either short (8 chars) or long (16 chars) and
	// returns it. Default expiration is one year.
	public static function generate($short = false) {
		$token = substr(md5(String::random(32)), 0, $short ? 8 : 16);
		$expires = date('Y-m-d H:i:s', strtotime('+1 year'));

		$item = static::create(compact('token', 'expires'));
		return $item->save() ? $token : false;
	}

	// Checks if a given token is valid and not yet expired.
	public static function check($token) {
		return (boolean) static::find('count', [
			'conditions' => [
				'token' => $token,
				'expires' => ['>=' => date('Y-m-d H:i:s')]
			]
		]);
	}

	// Deletes a given token if it exists.
	public static function void($token) {
		$item = static::find('first', [
			'conditions' => compact('token'),
			'fields' => ['id']
		]);
		if (!$item) {
			return false;
		}
		return $item->delete();
	}

	// Runs garbage collection on the collection, deleting any expired items.
	public static function gc() {
		return static::remove([
			'expires <' => date('Y-m-d H:i:s')
		]);
	}
}

?>