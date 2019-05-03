<?php

/**
 * 2016-2019 Pavel Strejček
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author Pavel Strejček <pavel.strejcek@brainweb.cz>
 *  @copyright 2016-2019 Pavel Strejček
 *  @license   Licensed under the Open Software License version 3.0  https://opensource.org/licenses/OSL-3.0
 */
if (!defined('BRAINWEBOPTIONALDNIDIR')) {
	exit;
}

require_once BRAINWEBOPTIONALDNIDIR . 'Overriding.php';
require_once BRAINWEBOPTIONALDNIDIR . 'Helper.php';

/**
 * This function updates your module from previous versions to the version 1.1,
 * usefull when you modify your database, or register a new hook ...
 * Don't forget to create one file per version.
 */
function upgrade_module_1_0_13($module)
{
	$generator = new BrainWebOptionalDni_Overriding($module);

	if ($generator->remove()) {
		if ($generator->generate()) {
			Configuration::updateValue('BRAINWEBOPTIONALDNI_PS_VERSION', _PS_VERSION_);
			BrainWebOptionalDni_Helper::removeClassIndex();
			return true;
		}
	}
	return false;
}
