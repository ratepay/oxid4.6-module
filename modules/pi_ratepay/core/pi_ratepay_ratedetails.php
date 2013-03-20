<?php

/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category  PayIntelligent
 * @package   PayIntelligent_RatePAY
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * Model class for pi_ratepay_ratedetails table
 * @extends oxBase
 */
class pi_ratepay_RateDetails extends oxBase
{

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'pi_ratepay_RateDetails';

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('pi_ratepay_rate_details');
    }

    /**
     * Load data by orderid not oxid
     *
     * @param string $orderId
     * @return boolean
     */
    public function loadByOrderId($orderId)
    {
        //getting at least one field before lazy loading the object
        $this->_addField('oxid', 0);
        $selectQuery = $this->buildSelectString(array($this->getViewName() . ".orderid" => $orderId));

        return $this->_isLoaded = $this->assignRecord($selectQuery);
    }

}
