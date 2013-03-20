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
[{include file="headitem.tpl" title="[ratepay]"}]

<form id="sortOrderId" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortOrderId">
    [{if $sortmethod == "sortOrderId" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortTransactionId" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortTransactionId">
    [{if $sortmethod == "sortTransactionId" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortFirstName" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortFirstName">
    [{if $sortmethod == "sortFirstName" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortLastName" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortLastName">
    [{if $sortmethod == "sortLastName" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortPaymentMethod" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortPaymentMethod">
    [{if $sortmethod == "sortPaymentMethod" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortPaymentType" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortPaymentType">
    [{if $sortmethod == "sortPaymentType" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortPaymentSubType" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortPaymentSubType">
    [{if $sortmethod == "sortPaymentSubType" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortResult" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortResult">
    [{if $sortmethod == "sortResult" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortReason" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortReason">
    [{if $sortmethod == "sortReason" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>

<form id="sortDate" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="sortmethod" value="sortDate">
    [{if $sortmethod == "sortDate" }]
    <input type="hidden" name="sortType" value="[{$sortType}]">
    [{/if}]
</form>
[{if isset($deleteSuccess)}]
<div class="messagebox" style="color:green;"><b>[{ oxmultilang ident="PI_RATEPAY_LOGGING_SUCCESS" }]</b></div>
[{/if}]


<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortOrderId').submit();" >ORDER ID</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortTransactionId').submit();" >TRANSACTION ID</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortFirstName').submit();" >FIRST NAME</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortLastName').submit();" >LAST NAME</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortPaymentMethod').submit();" >PAYMENT METHOD</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortPaymentType').submit();" >OPERATION TYPE</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortPaymentSubType').submit();" >OPERATION SUBTYPE</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortResult').submit();" >RESULT</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortResult').submit();"> RATEPAY RESULT</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortResult').submit();" >RATEPAY RESULT CODE</a></td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortReason').submit();" >REASON</a></td>
        <td class="listheader">REQUEST</td>
        <td class="listheader">RESPONSE</td>
        <td class="listheader"><a href="#" onclick="document.getElementById('sortDate').submit();" >DATE</td>
    </tr>
    [{assign var=oddclass value="2"}]
    [{assign var=counter value="0"}]
    [{foreach from=$logs item=log}]
    [{if $oddclass == 2}]
    [{assign var=oddclass value=""}]
    [{else}]
    [{assign var=oddclass value="2"}]
    [{/if}]
    <tr>
        <td class="listitem[{$oddclass}]">[{$log.orderid}]</td>
        <td class="listitem[{$oddclass}]">[{$log.transactionid}]</td>
        <td class="listitem[{$oddclass}]">[{$log.firstname}]</td>
        <td class="listitem[{$oddclass}]">[{$log.lastname}]</td>
        <td class="listitem[{$oddclass}]">[{$log.paymentmethod}]</td>
        <td class="listitem[{$oddclass}]">[{$log.operationtype}]</td>
        <td class="listitem[{$oddclass}]">[{$log.operationsubtype}]</td>
        <td class="listitem[{$oddclass}]">[{$log.result}]</td>
        <td class="listitem[{$oddclass}]">[{$log.ratepayresult}]</td>
        <td class="listitem[{$oddclass}]">[{$log.ratepaycode}]</td>
        <td class="listitem[{$oddclass}]">[{$log.reason}]</td>
        <td class="listitem[{$oddclass}]"><a href="#" onclick="YAHOO.oxid.help.showPanel('request_[{$counter}]');" >Request</a></td>
        <td class="listitem[{$oddclass}]"><a href="#" onclick="YAHOO.oxid.help.showPanel('response_[{$counter}]');" >Response</a></td>
        <td class="listitem[{$oddclass}]">[{$log.date}]</td>
    </tr>
    <div id="helpText_request_[{$counter}]" class="helpPanelText"><textarea readonly cols="60" rows="20">[{$log.request}]</textarea>
        <br />
    </div>
    <div id="helpText_response_[{$counter}]" class="helpPanelText"><textarea readonly cols="60" rows="20">[{$log.response}]</textarea>
        <br />
    </div>
    [{assign var="counter" value=$counter+1}]
    [{/foreach}]
</table>
<br/>
<form action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="pi_ratepay_log">
    <input type="hidden" name="fnc" value="deleteLogs">
    [{oxmultilang ident="PI_RATEPAY_LOGGING_TEXTDAYS"}]<input type="text" name="logdays" maxlength="2" size="2" value="0"/> [{oxmultilang ident="PI_RATEPAY_LOGGING_DAYS"}].
    <input type="submit" name="delete" value="[{oxmultilang ident="PI_RATEPAY_LOGGING_DELETE"}]">
</form>

[{include file="bottomitem.tpl"}]
