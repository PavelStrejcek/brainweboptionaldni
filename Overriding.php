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

require_once dirname(__FILE__) . '/Config.php';

class BrainWebOptionalDni_Overriding
{

	private $module;
	private $config;
	private $fail;

	public function __construct($module)
	{
		$this->module = $module;
		$this->config = new BrainWebOptionalDni_Config($module);
	}

	public function generate()
	{
		foreach ($this->config->overrided as $class => $methods) {
			$code = "<" . "?php\n\n/*** DO NOT MODIFY THIS FILE BECAUSE IT WAS GENERATED AUTOMATICALLY ***/\n\n";
			$code .= 'if (!isset($this) || !$this instanceof ' . $class . ') exit;' . "\n\n";

			foreach ($methods as $method) {
				$refMethod = new ReflectionMethod($class, $method);

				$rows = file($refMethod->getFileName());
				if (empty($rows)) {
					$this->fail = true;
					$this->module->addError(sprintf($this->config->errMessages['MethodNotFound'], "$class::$method"));
				} else {
					$methodRows = array_slice($rows, $refMethod->getStartLine() - 1, $refMethod->getEndLine() - $refMethod->getStartLine() + 1);
					$methodStatement = implode('', $methodRows);
					$braceStart = strpos($methodStatement, '{');
					$braceEnd = strrpos($methodStatement, '}');
					$methodStatement = substr($methodStatement, $braceStart + 1, strlen($methodStatement) - (strlen($methodStatement) - $braceEnd) - $braceStart - 1);
					$methodStatement = $this->addVersionCheck($methodStatement, $method);
					$code .= $this->replaceCode($class, $method, $methodStatement);
				}
				$fileSuccess = file_put_contents(_PS_MODULE_DIR_ . $this->module->name . "/generated/$class-$method.php", $code);
				if (!$fileSuccess) {
					$this->fail = true;
					$this->module->addError(sprintf($this->config->errMessages['WritingFailed'], "generated/${class}\Generated.php"));
				}
			}
		}
		return !$this->fail;
	}

	private function addVersionCheck($methodStatement, $method)
	{

		$check = "\n" . '        require_once _PS_MODULE_DIR_ . \'/' . $this->module->name . '/Helper.php\';' . "\n";
		$check .= '        if (!Module::isEnabled("' . $this->module->name . '") || ' . $this->config->helperClass . '::checkDifferentPSVersion()) return parent::' . $method . '();' . "\n";
		$methodStatement = $check . $methodStatement;
		return $methodStatement;
	}

	private function replaceCode($class, $method, $statement)
	{
		if (isset($this->config->replacements["$class::$method"])) {
			foreach ($this->config->replacements["$class::$method"] as $search => $replace) {
				$statement = strtr($statement, array($search => $replace));
				if (false === strpos($statement, $replace)) {
					$this->fail = true;
					$this->module->addError(sprintf($this->config->errMessages['StatementNotFound'], "$class::$method"));
				}
			}
		}
		return $statement;
	}

	public function remove()
	{
		foreach ($this->config->overrided as $class => $methods) {
			foreach ($methods as $method) {
				unlink(_PS_MODULE_DIR_ . $this->module->name . "/generated/$class-$method.php");
			}
		}
		return true;
	}

}
