<?php

/*
 * 2016 Pavel Strejček
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *  @author Pavel Strejček <pavel.strejcek@brainweb.cz>
 *  @copyright  2016-2017 Pavel Strejček
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define('BRAINWEBOPTIONALDNIDIR', dirname(__FILE__) . '/');

require_once dirname(__FILE__) . '/Helper.php';
require_once dirname(__FILE__) . '/Overriding.php';

if (!defined('_PS_VERSION_'))
	exit;

class BrainWebOptionalDni extends Module
{

	public function __construct()
	{
		$this->name = 'brainweboptionaldni';
		$this->tab = 'others';
		$this->version = '1.0.5';
		$this->author = 'Pavel Strejček [BrainWeb.cz]';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = array('min' => '1.6.1.4', 'max' => '1.6.1.11');
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Optional Identification Number');
		$this->description = $this->l('Optional field Identification number in customer address');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		$this->checkVersionWarning();
	}

	private function checkVersionWarning()
	{
		if (BrainWebOptionalDni_Helper::checkDifferentPSVersion()) {
			if (version_compare(_PS_VERSION_, $this->ps_versions_compliancy['min'], '<') || version_compare(_PS_VERSION_, $this->ps_versions_compliancy['max'], '>')) {
				$this->warning = sprintf($this->l('Module is not active. Module is installed for old version of PrestaShop: %s. Install a new version of the module.'), BrainWebOptionalDni_Helper::checkDifferentPSVersion());
			} else {
				$this->warning = sprintf($this->l('Module is not active. Module is installed for different version of PrestaShop: %s. Try unistall and install again.'), BrainWebOptionalDni_Helper::checkDifferentPSVersion());
			}
		}
	}

	public function install()
	{

		$generator = new BrainWebOptionalDni_Overriding($this);

		$ret = $generator->generate() &&
				parent::install() &&
				$this->registerHook('header') &&
				Configuration::updateValue('BRAINWEBOPTIONALDNI_PS_VERSION', _PS_VERSION_);
		BrainWebOptionalDni_Helper::removeClassIndex();
		return $ret;
	}

	public function uninstall()
	{
		$generator = new BrainWebOptionalDni_Overriding($this);
		return Configuration::deleteByName('BRAINWEBOPTIONALDNI_PS_VERSION') &&
				parent::uninstall() &&
				$generator->remove();
	}

	public function hookDisplayHeader()
	{
		if (!BrainWebOptionalDni_Helper::checkDifferentPSVersion()) {
			$this->context->controller->addCSS($this->_path . 'css/style.css', 'all');
		}
	}

	public function addError($err)
	{
		$this->_errors[] = Tools::displayError($err);
	}

	private function _displayInfo()
	{
		return $this->display(__FILE__, 'info.tpl');
	}

	public function getContent()
	{
		$this->_html = '';

		$this->_html .= $this->_displayInfo();

		return $this->_html;
	}

}
