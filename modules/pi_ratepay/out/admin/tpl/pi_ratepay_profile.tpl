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
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_MERCHANTNAME" }]:</td>
        <td>[{$merchantname}]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_MERCHANTSTATUS" }]:</td>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_MERCHANTSTATUS_$merchantstatus" }]</td>
    </tr>    
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_SHOPNAME" }]:</td>
        <td>[{$shopname}]</td>
    </tr>    
    <tr>
        <td colspan="2" style="font-weight: bold;">[{ oxmultilang ident="PI_RATEPAY_PROFILE_INVOICE" }]:</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ELIGIBILITY" }]:</td>
        <td>[{$eligibility_invoice}]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION" }]:</td>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION_$activation_invoice" }]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_LIMIT" }]:</td>
        <td>[{$limit_invoice_min}] / [{$limit_invoice_max}]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_DELIVERYADDRESS" }]:</td>
        <td>[{$deliveryaddress_invoice}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_B2B" }]:</td>
        <td>[{$b2b_invoice}]</td>
    </tr>               
    <tr>
        <td colspan="2" style="font-weight: bold;">[{ oxmultilang ident="PI_RATEPAY_PROFILE_INSTALLMENT" }]:</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ELIGIBILITY" }]:</td>
        <td>[{$eligibility_installment}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION" }]:</td>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION_$activation_installment" }]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_LIMIT" }]:</td>
        <td>[{$limit_installment_min}] / [{$limit_installment_max}]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_DELIVERYADDRESS" }]:</td>
        <td>[{$deliveryaddress_installment}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_B2B" }]:</td>
        <td>[{$b2b_installment}]</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">[{ oxmultilang ident="PI_RATEPAY_PROFILE_ELV" }]:</td>
    </tr>    
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ELIGIBILITY" }]:</td>
        <td>[{$eligibility_elv}]</td>
    </tr>     
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION" }]:</td>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION_$activation_elv" }]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_LIMIT" }]:</td>
        <td>[{$limit_elv_min}] / [{$limit_elv_max}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_DELIVERYADDRESS" }]:</td>
        <td>[{$deliveryaddress_elv}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_B2B" }]:</td>
        <td>[{$b2b_elv}]</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">[{ oxmultilang ident="PI_RATEPAY_PROFILE_PREPAYMENT" }]:</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ELIGIBILITY" }]:</td>
        <td>[{$eligibility_prepayment}]</td>
    </tr>
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION" }]:</td>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_ACTIVATION_$activation_prepayment" }]</td>
    </tr>         
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_LIMIT" }]:</td>
        <td>[{$limit_prepayment_min}] / [{$limit_prepayment_max}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_DELIVERYADDRESS" }]:</td>
        <td>[{$deliveryaddress_prepayment}]</td>
    </tr> 
    <tr>
        <td>[{ oxmultilang ident="PI_RATEPAY_PROFILE_B2B" }]:</td>
        <td>[{$b2b_prepayment}]</td>
    </tr> 
    
    <tr>
        <td colspan="2">
            <form name="myedit" id="myedit" action="[{ $shop->selflink }]" method="post">
                [{ $shop->hiddensid }]
                <input type="hidden" name="cl" value="pi_ratepay_Profile">
                <input type="hidden" name="fnc" value="reloadRatepayProfile">
                <input type="hidden" name="stoken" value="[{ $stoken }]">

                <input type="submit" class="edittext" name="[{ oxmultilang ident="PI_RATEPAY_PROFILE_RELOAD" }]" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{ oxmultilang ident="PI_RATEPAY_PROFILE_RELOAD" }]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
            </form>
        </td>
    </tr>    
</table>
[{/if}]

[{include file="bottomitem.tpl"}]
