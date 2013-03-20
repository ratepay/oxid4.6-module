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
 * Generate iterable list of history model objects
 * @extends oxList
 */
class pi_ratepay_HistoryList extends oxList
{

    /**
     * Core table name
     *
     * @var string
     */
    protected $_sCoreTable = 'pi_ratepay_history';

    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = 'pi_ratepay_History';

    /**
     * Generic function for loading the list with where clause
     *
     * @param string $where optional: where condition for query
     */
    public function getFilteredList($where = null)
    {
        $oListObject = $this->getBaseObject();
        $sFieldList = $oListObject->getSelectFields();
        $sQ = "select $sFieldList from " . $oListObject->getViewName();

        if ($where != null) {
            $sQ .= " where $where ";
        }
        $this->selectString($sQ);

        return $this;
    }

}
