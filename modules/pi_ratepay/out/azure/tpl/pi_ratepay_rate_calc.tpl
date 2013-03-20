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
* @package   PayIntelligent_RatePAY_Rate
* @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
* @license	http://www.gnu.org/licenses/  GNU General Public License 3
*-->
[{oxstyle include="css/checkout.css"}]
[{capture append="oxidBlock_content"}]
[{* ordering steps *}]
[{include file="page/checkout/inc/steps.tpl" active=3 }]
[{ if isset($error)}]
<div class="status error">[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_AGBERROR" }]</div>
[{/if}]

<br/>
<link type="text/css" rel="stylesheet" href="modules/pi_ratepay/ratenrechner/css/style.css"/>
<script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/path.js"></script>
<script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/layout.js"></script>
<script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/ajax.js"></script>
[{if $pierror == "-461"}]
    <div class="status error">
        [{oxmultilang ident="PI_RATEPAY_RATE_ERROR_CALCULATE_TO_PROCEED"}]
    </div>
[{/if}]
<div id="pirpmain-cont">

</div>
<script type="text/javascript">
    if(document.getElementById('pirpmain-cont')){
    piLoadrateCalculator();
}

</script>
<form action="[{ $oViewConf->getSslSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    [{ $oViewConf->getNavFormParams() }]
    <input type="hidden" name="cl" value="pi_ratepay_rate_calc">
    <input type="hidden" name="fnc" value="check">
    <div class="lineBox clear">
        <a href="[{ $oViewConf->getSslSelfLink() }]cl=payment" class="submitButton largeButton" id="paymentBackStepBottom">[{ oxmultilang ident="PAGE_CHECKOUT_PAYMENT_BACKSTEP" }]</a>
        <button type="submit" name="userform" class="submitButton nextStep largeButton" id="paymentNextStepBottom">[{ oxmultilang ident="PAGE_CHECKOUT_PAYMENT_NEXTSTEP" }]</button>
    </div>

</form>
[{insert name="oxid_tracker" title=$template_title }]
[{/capture}]
[{include file="layout/page.tpl"}]
