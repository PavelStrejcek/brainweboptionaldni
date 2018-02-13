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

class AuthController extends AuthControllerCore
{

    /**
     * Process submit on an account
     */
    protected function processSubmitAccount()
    {
        require(_PS_MODULE_DIR_ . 'brainweboptionaldni/generated/AuthControllerCore-processSubmitAccount.php');
    }

}
