<!--
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
* @package   PayIntelligent_RatePAY_Rechnung
* @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
* @license	http://www.gnu.org/licenses/  GNU General Public License 3
*-->
[{include file="headitem.tpl" titre="[ratepay]"}]

[{if $error == 0}]
<table>
    <tr>
        <td>Interestrate Minimum:</td>
        <td>[{$interestrateMin}]</td>
    </tr>
    <tr>
        <td>Interestrate Default:</td>
        <td>[{$interestrateDefault}]</td>
    </tr>
    <tr>
        <td>Interestrate Maximum:</td>
        <td>[{$interestrateMax}]</td>
    </tr>
    <tr>
        <td>Month Number Minimum:</td>
        <td>[{$monthNumberMin}]</td>
    </tr>
    <tr>
        <td>Month Number Maximum:</td>
        <td>[{$monthNumberMax}]</td>
    </tr>
    <tr>
        <td>Month Longrun:</td>
        <td>[{$monthLongrun}]</td>
    </tr>
    <tr>
        <td>Months Allowed:</td>
        <td>[{$monthAllowed}]</td>
    </tr>
    <tr>
        <td>Payment Firstday:</td>
        <td>[{$paymentFirstday}]</td>
    </tr>
    <tr>
        <td>Payment Amount:</td>
        <td>[{$paymentAmount}]</td>
    </tr>
    <tr>
        <td>Payment Lastrate:</td>
        <td>[{$paymentLastrate}]</td>
    </tr>
    <tr>
        <td>Rate Minimum Normal:</td>
        <td>[{$rateMinNormal}]</td>
    </tr>
    <tr>
        <td>Rate Minimum Longrun:</td>
        <td>[{$rateMinLongrun}]</td>
    </tr>
    <tr>
        <td>Service Charge:</td>
        <td>[{$serviceCharge}]</td>
    </tr>
</table>
[{/if}]

[{include file="bottomitem.tpl"}]
