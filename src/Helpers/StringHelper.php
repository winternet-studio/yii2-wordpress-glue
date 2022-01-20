<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\helpers;

class StringHelper extends \yii\helpers\StringHelper {

	/**
	 * Standardize a parameter (strip special characters and convert spaces)
	 *
	 * @param string  $strString            The input string
	 * @param boolean $blnPreserveUppercase True to preserver uppercase characters
	 *
	 * @return string The converted string
	 */
	public static function standardize($strString, $blnPreserveUppercase=false) {
		$arrSearch = array('/[^\pN\pL \.\&\/_-]+/u', '/[ \.\&\/-]+/', '/[äöüÄÖÜß]+/');
		$arrReplace = array('','','');
		$strString = html_entity_decode($strString, ENT_QUOTES);
		$strString = static::stripInsertTags($strString);
		$strString = preg_replace($arrSearch, $arrReplace, $strString);

		if (!$blnPreserveUppercase) {
			$strString = strtolower($strString);
		}

		return trim($strString, '-');
	}

	/**
	 * Remove insert tags from a string
	 *
	 * @param string $strString The input string
	 *
	 * @return string The converted string
	 */
	public static function stripInsertTags($strString) {
		$count = 0;
		do {
			$strString = preg_replace('/\{[^\{\}]*\}/', '', $strString, -1, $count);
		} while ($count > 0);
		return $strString;
	}

}
