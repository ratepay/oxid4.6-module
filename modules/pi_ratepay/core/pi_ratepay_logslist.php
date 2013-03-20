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
 * Generate iterable list of pi_ratepay_logs model objects
 * @extends oxList
 */
class pi_ratepay_LogsList extends oxList
{

    /**
     * Core table name
     *
     * @var string
     */
    protected $_sCoreTable = 'pi_ratepay_logs';

    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = 'pi_ratepay_Logs';

    /**
     * Generic function for loading the list with where clause and order by
     *
     * @param string $where
     * @param array $orderBy example: array(array('column' => 'order_id', 'direction' => 'asc'))
     * @return pi_ratepay_LogsList
     */
    public function getFilteredList($where = null, $orderBy = null)
    {
        $listObject = $this->getBaseObject();
        $fieldList = $listObject->getSelectFields();
        $query = "select $fieldList from " . $listObject->getViewName();

        if ($where !== null) {
            $query .= " where $where ";
        }

        if ($orderBy !== null) {
            $lastArrayItem = end($orderBy);
            $addition = ', ';

            $query .= ' order by ';

            foreach ($orderBy as $orderByItem) {
                if ($orderByItem == $lastArrayItem)
                    $addition = '';
                $query .= $orderByItem['column'] . ' ' . $orderByItem['direction'] . $addition;
            }
        }

        $this->selectString($query);

        return $this;
    }

}
