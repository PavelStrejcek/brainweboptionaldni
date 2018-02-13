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
 *  @copyright  2016-2018Pavel Strejček
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class BrainWebOptionalDni_Config
{

	private $module;
	public $overrided = array(
		'AddressControllerCore' => array('processSubmitAddress'),
		'AuthControllerCore' => array('processSubmitAccount')
	);
	public $replacements = array(
		'AddressControllerCore::processSubmitAddress' =>
		array(
			"if (\$country->isNeedDni() && (!Tools::getValue('dni') || !Validate::isDniLite(Tools::getValue('dni')))) {" =>
			"if (\$country->isNeedDni() && Tools::getValue('dni') && !Validate::isDniLite(Tools::getValue('dni'))) {"
		),
		'AuthControllerCore::processSubmitAccount' =>
		array(
			"if (\$country->need_identification_number && (!Tools::getValue('dni') || !Validate::isDniLite(Tools::getValue('dni')))) {" =>
			"if (\$country->need_identification_number && Tools::getValue('dni') && !Validate::isDniLite(Tools::getValue('dni'))) {"
		)
	);
	public $helperClass = 'BrainWebOptionalDni_Helper';
	public $errMessages = array();

	public function __construct($module)
	{
		$this->module = $module;
		$this->errMessages['MethodNotFound'] = $this->module->l("Method %s not found for overriding.", 'Overriding');
		$this->errMessages['WritingFailed'] = $this->module->l("Writing of file %s failed.", 'Overriding');
		$this->errMessages['StatementNotFound'] = $this->module->l("Overriding of method %s failed. Statement not found.", 'Overriding');
	}

}
