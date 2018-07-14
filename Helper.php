<?php

/*
 * 2016-2018 Pavel Strejček
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *  @author Pavel Strejček <pavel.strejcek@brainweb.cz>
 *  @copyright  2016-2018 Pavel Strejček
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class BrainWebOptionalDni_Helper
{

	static public function checkDifferentPSVersion()
	{
		static $usedPSVersionCheck;

		if (is_null($usedPSVersionCheck)) {
			$usedPSVersion = Configuration::get('BRAINWEBOPTIONALDNI_PS_VERSION');
			if (version_compare(_PS_VERSION_, $usedPSVersion, '!=')) {
				$usedPSVersionCheck = $usedPSVersion;
			} else {
				$usedPSVersionCheck = false;
			}
		}
		return $usedPSVersionCheck;
	}

	static public function removeClassIndex()
	{
		if (!defined('_PS_ROOT_DIR_')) {
			return false;
		}
		$filename = static::normalizeDirectory(_PS_ROOT_DIR_) . PrestaShopAutoload::INDEX_FILE;
		return unlink($filename);
	}

	static public function normalizeDirectory($directory)
	{
		return rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
	}

}
