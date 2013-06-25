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
 * Model class for oxpayments table
 * @extends oxBase
 */
class pi_ratepay_Profile extends oxBase
{

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'pi_ratepay_Profile';

    /**
     * Class constructor
     *
     * @return null
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('oxpayments');
    }

    /**
     * Load either invoice or installment settings
     *
     * @param string $type 'invoice' | 'installment'
     * @return boolean
     */
    public function loadByType($type)
    {
        //getting at least one field before lazy loading the object
        $this->_addField('oxid', 0);
        $selectQuery = $this->buildSelectString(array($this->getViewName() . ".type" => strtolower($type)));

        return $this->_isLoaded = $this->assignRecord($selectQuery);
    }

}
