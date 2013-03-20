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
 * Model for order articles
 */
class pi_ratepay_RequestOrderArticle
{

    /**
     * Title
     * @var string
     */
    private $_title;

    /**
     * article number
     * @var string
     */
    private $_articleNumber;

    /**
     * Quantity
     * @var int
     */
    private $_quantity;

    /**
     * Unit price
     * @var double
     */
    private $_unitPrice;

    /**
     * Total price
     * @var double
     */
    private $_price;

    /**
     * VAT percentage
     * @var double
     */
    private $_vatValue;

    /**
     * Class constructor
     *
     * @param string $title
     * @param string $articleNumber
     * @param int $quantity
     * @param double $unitPrice
     * @param double $price
     * @param double $vatValue
     */
    function __construct($title, $articleNumber, $quantity, $unitPrice, $price, $vatValue)
    {
        $this->_title = $title;
        $this->_articleNumber = $articleNumber;
        $this->_quantity = $quantity;
        $this->_unitPrice = $unitPrice;
        $this->_price = $price;
        $this->_vatValue = $vatValue;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Get article number
     * @return string
     */
    public function getArticleNumber()
    {
        return $this->_articleNumber;
    }

    /**
     * Get quantity
     * @return int
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Get unit price
     * @return double
     */
    public function getUnitPrice()
    {
        return $this->_unitPrice;
    }

    /**
     * Get total price
     * @return double
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Get vat percentage
     * @return double
     */
    public function getVatValue()
    {
        return $this->_vatValue;
    }

}
