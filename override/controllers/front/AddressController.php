<?php
/*
* 2016-2019 Pavel Strejček
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
*  @author Pavel Strejček <pavel.strejcek@brainweb.cz>
*  @copyright  2016-2019Pavel Strejček
*  @license   Licensed under the Open Software License version 3.0  https://opensource.org/licenses/OSL-3.0
*/

class AddressController extends AddressControllerCore
{

    /**
     * Process changes on an address
     */
    protected function processSubmitAddress()
    {
        require(_PS_MODULE_DIR_ . 'brainweboptionaldni/generated/AddressControllerCore-processSubmitAddress.php');
    }

}
