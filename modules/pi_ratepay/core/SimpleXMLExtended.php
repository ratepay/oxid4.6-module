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
 * {@inheritdoc}
 *
 * Extends SimpleXMLElement with a method to easyily add CData Child to XML.
 *
 * @package PayIntelligent_RatePAY
 * @extends SimpleXMLElement
 */
class SimpleXMLExtended extends SimpleXMLElement
{

    /**
     * create CData child
     *
     * @param string $sName
     * @param string $sValue
     * @param bool $utfMode
     * @return SimpleXMLElement
     */
    public function addCDataChild($sName, $sValue, $utfMode = true)
    {
        if (!$utfMode) {
            $sValue = utf8_encode($sValue);
        }

        $sValue = html_entity_decode($sValue);
        $sValue = str_replace("&#039;", "'", $sValue);

        $oNodeOld = dom_import_simplexml($this);
        $oDom = new DOMDocument();
        $oDataNode = $oDom->appendChild($oDom->createElement($sName));
        $oDataNode->appendChild($oDom->createCDATASection($sValue));
        $oNodeTarget = $oNodeOld->ownerDocument->importNode($oDataNode, true);
        $oNodeOld->appendChild($oNodeTarget);
        return simplexml_import_dom($oNodeTarget);
    }

}
