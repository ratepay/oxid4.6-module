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

[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<script type="text/javascript">
    function showWaitingWheel() {
        document.getElementById("waitingWheel").style.visibility = 'visible';
    }
</script>
<!--[if gte IE 6]>
<style>
    .waitIMG{
        visibility:hidden;
    }
</style>
<![endif]-->

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="pi_ratepay_details">
</form>

[{if isset($pierror)}]
[{if $pierror == ""}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORDELIVERY"}]</b></div>
[{/if}]
[{if $pierror == "credit"}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORVOUCHER"}]</b></div>
[{/if}]
[{if $pierror == "partial-return"}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORPARTIALRETURN"}]</b></div>
[{/if}]
[{if $pierror == "full-return"}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORFULLRETURN"}]</b></div>
[{/if}]
[{if $pierror == "partial-cancellation"}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORPARTIALCANCELLATION"}]</b></div>
[{/if}]
[{if $pierror == "full-cancellation"}]
<div class="messagebox" style="color:red;"><b>[{oxmultilang ident="PI_RATEPAY_ERRORFULLCANCELLATION"}]</b></div>
[{/if}]
[{/if}]
[{if isset($pisuccess)}]
[{if $pisuccess == ""}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSDELIVERY"}]</b></div>
[{/if}]
[{if $pisuccess == "credit"}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSVOUCHER"}]</b></div>
[{/if}]
[{if $pisuccess == "partial-return"}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSPARTIALRETURN"}]</b></div>
[{/if}]
[{if $pisuccess == "full-return"}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSFULLRETURN"}]</b></div>
[{/if}]
[{if $pisuccess == "partial-cancellation"}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSPARTIALCANCELLATION"}]</b></div>
[{/if}]
[{if $pisuccess == "full-cancellation"}]
<div class="messagebox" style="color:green;"><b>[{oxmultilang ident="PI_RATEPAY_SUCCESSFULLCANCELLATION"}]</b></div>
[{/if}]
[{/if}]
<div id="message" class="messagebox" style="visibility:hidden;">[{oxmultilang ident="PI_RATEPAY_ERRORTYPING"}]</div>
[{if $pi_ratepay_payment_type === "INSTALLMENT"}]
<fieldset style="padding-left: 5px; padding-right: 5px;">
    <legend>Ratendetails</legend><br/>
    <table>
        <tr>
            <td>Gesamtbetrag:</td>
            <td>[{$pirptotalamountvalue}]</td>
        </tr>
        <tr>
            <td>Barzahlungspreis:</td>
            <td>[{$pirpamountvalue}]</td>
        </tr>
        <tr>
            <td>Zinsbetrag:</td>
            <td>[{$pirpinterestamountvalue}]</td>
        </tr>
        <tr>
            <td>Vertragsabschlussgebühr:</td>
            <td>[{$pirpservicechargevalue}]</td>
        </tr>
        <tr>
            <td>Effektiver Jahreszins:</td>
            <td>[{$pirpannualpercentageratevalue}]</td>
        </tr>
        <tr>
            <td>Sollzinssatz pro Monat:</td>
            <td>[{$pirpmonthlydebitinterestvalue}]</td>
        </tr>
        <tr>
            <td>Laufzeit:</td>
            <td>[{$pirpnumberofratesvalue}]</td>
        </tr>
        <tr>
            <td>[{$pirpnumberofratesvalue-1}]&nbsp;monatliche Raten à:</td>
            <td>[{$pirpratevalue}]</td>
        </tr>
        <tr>
            <td>zzgl. einer Abschlussrate à:</td>
            <td>[{$pirplastratevalue}]</td>
        </tr>
    </table>
</fieldset>

<br/>
[{/if}]
[{assign var="storniert_versendet" value="0"}]
[{foreach from=$articleList item=article}]
[{if $article.amount > 0}]
[{assign var="storniert_versendet" value="1"}]
[{/if}]
[{/foreach}]

<fieldset title="[{oxmultilang ident="PI_RATEPAY_SHIPPING"}]/[{oxmultilang ident="PI_RATEPAY_CANCELLING"}]" style="padding-left: 5px; padding-right: 5px;">
          <legend>[{oxmultilang ident="PI_RATEPAY_SHIPPING_TABLE_HEAD"}]</legend><br/>
    <form action="[{$oViewConf->getSelfLink()}]" method="post" id="articleList">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cur" value="[{$oCurr->id}]">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="cl" value="pi_ratepay_details">
        <input type="hidden" name="fnc" value="">

        [{assign var="blWhite" value=""}]

        <table cellspacing="0" cellpadding="0" border="0" width="98%">
            <tr>
                <td class="listheader first">[{oxmultilang ident="PI_RATEPAY_QUANTITY"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENR"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENAME"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_UNITPRICE"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_TAX"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_TOTALPRICE"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ORDERED"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_SHIPPED"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_CANCELLED"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_RETURNED"}]</td>

            </tr>
            [{foreach from=$articleList item=article}]
            [{assign var="listclass" value=listitem$blWhite}]
            <tr>
                [{if $article.amount > 0}]
                <td valign="top" class="[{$listclass}]"><input name="[{$article.arthash}]" type="text" maxlength="4" style="width: 40px;" class="edittext" value="[{$article.amount}]" onkeyup="check('[{$article.arthash}]',[{$article.amount}],this.value);" onFocus="hideMessageBox();this.select();" onBlur="hideMessageBox();"/></td>
                [{else}]
                <td valign="top" class="[{$listclass}]"><input name="[{$article.arthash}]" type="text" maxlength="4" style="width: 40px;" class="edittext" value="[{$article.amount}]" disabled="disabled"/></td>
                [{/if}]
                <td valign="top" class="[{$listclass}]">[{$article.artnum}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.title|strip_tags}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.unitprice}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.vat}] %</td>
                <td valign="top" class="[{$listclass}]">[{$article.totalprice}] EUR</td>
                <td valign="top" class="[{$listclass}]">[{$article.ordered}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.shipped}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.cancelled}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.returned}]</td>
            <tr/>
            [{if $blWhite == "2"}]
            [{assign var="blWhite" value=""}]
            [{else}]
            [{assign var="blWhite" value="2"}]
            [{/if}]
            [{/foreach}]
            <tr>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">[{$pitotalamount}] EUR</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
                <td valign="top" class="[{$listclass}]">&nbsp;</td>
            <tr/>
        </table>
        <div id="waitingWheel" class="popup" style="visibility:hidden;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #000000;display: block; height: 150px;left: 50%;margin-left: -135px;margin-top: -75px; padding: 10px;position: fixed;top: 50%;width: 270px;z-index: 2000;">
            <p>Bitte warten, Ihre Anfrage wird gerade &uuml;berpr&uuml;ft. Schlie&szlig;en Sie diese Seite nicht und klicken Sie nicht "Reload" bis die &Uuml;berpr&uuml;fung abgeschlossen ist. Dies wird ca. 10 Sekunden dauern.</p>
            <center><img class="waitIMG" src="[{$oViewConf->getImageUrl()}]ajax-loader.gif" alt="wait"/></center>
        </div>
        [{if $storniert_versendet == "1"}]
        <input type="submit" name="deliver" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_SHIPPING"}]&nbsp;&nbsp;" class="edittext" onClick="setFnc('deliver', 'articleList'); showWaitingWheel();">
        <input type="submit" name="cancel" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_CANCELLING"}]&nbsp;&nbsp;" class="edittext" onClick="setFnc('cancel', 'articleList');">
        [{else}]
        <input type="submit" name="deliver" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_SHIPPING"}]&nbsp;&nbsp;" class="edittext" disabled="disabled">
        <input type="submit" name="cancel" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_CANCELLING"}]&nbsp;&nbsp;" class="edittext" disabled="disabled">
        [{/if}]
    </form>
</fieldset>

[{assign var="retourniert" value="0"}]
[{foreach from=$articleList item=article}]
[{if $article.shipped-$article.returned > 0}]
[{assign var="retourniert" value="1"}]
[{/if}]
[{/foreach}]

<br/>
<fieldset title="[{oxmultilang ident="PI_RATEPAY_RETURNING_TABLE_HEAD"}]" style="padding-left: 5px; padding-right: 5px;">
          <legend>[{oxmultilang ident="PI_RATEPAY_RETURNING_TABLE_HEAD"}]</legend><br/>
    <form action="[{$oViewConf->getSelfLink()}]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cur" value="[{$oCurr->id}]">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="cl" value="pi_ratepay_details">
        <input type="hidden" name="fnc" value="retoure">

        [{assign var="blWhite" value=""}]
        <table cellspacing="0" cellpadding="0" border="0" width="98%">
            <tr>
                <td class="listheader first">[{oxmultilang ident="PI_RATEPAY_QUANTITY"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENR"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENAME"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_SHIPPED"}]</td>
                <td class="listheader">[{oxmultilang ident="PI_RATEPAY_RETURNED"}]</td>

            </tr>
            [{foreach from=$articleList item=article}]
            [{assign var="listclass" value=listitem$blWhite}]
            <tr>
                [{if $article.shipped-$article.returned > 0}]
                <td valign="top" class="[{$listclass}]"><input name="[{$article.arthash}]" type="text" maxlength="4" style="width: 40px;" class="edittext" value="[{$article.shipped-$article.returned}]" onkeyup="check_shipped('[{$article.arthash}]',[{$article.shipped - $article.returned}],this.value);" onFocus="hideMessageBox();this.select();" onBlur="hideMessageBox();"/></td>
                [{else}]
                <td valign="top" class="[{$listclass}]"><input name="[{$article.arthash}]" type="text" maxlength="4" style="width: 40px;" class="edittext" value="0" disabled="disabled" /></td>
                [{/if}]
                <td valign="top" class="[{$listclass}]">[{$article.artnum}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.title|strip_tags}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.shipped}]</td>
                <td valign="top" class="[{$listclass}]">[{$article.returned}]</td>
            <tr/>
            [{if $blWhite == "2"}]
            [{assign var="blWhite" value=""}]
            [{else}]
            [{assign var="blWhite" value="2"}]
            [{/if}]
            [{/foreach}]
        </table>
        [{if $retourniert == "1"}]
        <input type="submit" name="return" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_RETURNING"}]&nbsp;&nbsp;" class="edittext"/>
               [{else}]
        <input type="submit" name="return" value="&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_RETURNING"}]&nbsp;&nbsp;" class="edittext" disabled="disabled"/>
               [{/if}]

    </form>
</fieldset>

<br/>
<fieldset title="[{oxmultilang ident="PI_RATEPAY_GOODWILL"}]" style="padding-left: 5px; padding-right: 5px;">
    <legend>[{oxmultilang ident="PI_RATEPAY_GOODWILL"}]</legend><br/>
    <form action="[{$oViewConf->getSelfLink()}]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cur" value="[{$oCurr->id}]">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="cl" value="pi_ratepay_details">
        <input type="hidden" name="fnc" value="credit">
        <span>Wert: </span>
        <input id='voucherAmount' type='text' style="float:none;" maxlength='4' name='voucherAmount' size='4' value='0' onkeyup="check_voucher('[{$pitotalamount}]');" onFocus="this.select();">[{oxmultilang ident="PI_RATEPAY_KOMMA"}]<input style='float:none;' id='voucherAmountKomma' type='text' maxlength='2' name='voucherAmountKomma' size='2' value='00' onkeyup="check_voucher('[{$pitotalamount}]');" onFocus="hideMessageBox();this.select();" onBlur="hideMessageBox();">EUR<br><br>
        <input type='submit' name='voucher' value='&nbsp;&nbsp;[{oxmultilang ident="PI_RATEPAY_VOUCHER"}]&nbsp;&nbsp;'">
    </form>
</fieldset>

[{assign var="historyCount" value="0"}]
[{foreach from=$historyList item=history}]
[{assign var="historyCount" value="1"}]
[{/foreach}]

<br/>
<fieldset title="[{oxmultilang ident="PI_RATEPAY_HISTORY"}]" style="padding-left: 5px; padding-right: 5px;">
          <legend>[{oxmultilang ident="PI_RATEPAY_HISTORY"}]</legend><br/>

    [{assign var="blWhite" value=""}]
    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>
            <td class="listheader first">[{oxmultilang ident="PI_RATEPAY_QUANTITY"}]</td>
            <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENR"}]</td>
            <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ARTICLENAME"}]</td>
            <td class="listheader">[{oxmultilang ident="PI_RATEPAY_ACTION"}]</td>
            <td class="listheader">[{oxmultilang ident="PI_RATEPAY_DATE"}]</td>

        </tr>
        [{foreach from=$historyList item=history}]
        [{assign var="listclass" value=listitem$blWhite}]
        <tr>
            <td valign="top" class="[{$listclass}]">[{$history.quantity}]</td>
            <td valign="top" class="[{$listclass}]">[{$history.article_number}]</td>
            <td valign="top" class="[{$listclass}]">[{$history.title|strip_tags}]</td>
            <td valign="top" class="[{$listclass}]">
                [{if $history.method == "CONFIRMATION_DELIVER"}]
                [{oxmultilang ident="PI_RATEPAY_CONFIRMDELIVER"}]
                [{/if}]
                [{if $history.method == "PAYMENT_CHANGE"}]
                [{if $history.subtype == "credit"}]
                [{oxmultilang ident="PI_RATEPAY_GOODWILL"}]
                [{/if}]
                [{if $history.subtype == "partial-return"}]
                [{oxmultilang ident="PI_RATEPAY_PARTIALRETURN"}]
                [{/if}]
                [{if $history.subtype == "full-return"}]
                [{oxmultilang ident="PI_RATEPAY_FULLRETURN"}]
                [{/if}]
                [{if $history.subtype == "partial-cancellation"}]
                [{oxmultilang ident="PI_RATEPAY_PARTIALCANCELLATION"}]
                [{/if}]
                [{if $history.subtype == "full-cancellation"}]
                [{oxmultilang ident="PI_RATEPAY_FULLCANCELLATION"}]
                [{/if}]
                [{/if}]
            </td>
            <td valign="top" class="[{$listclass}]">[{$history.date}]</td>
        <tr/>
        [{if $blWhite == "2"}]
        [{assign var="blWhite" value=""}]
        [{else}]
        [{assign var="blWhite" value="2"}]
        [{/if}]
        [{/foreach}]
    </table>
</fieldset>

[{include file="bottomitem.tpl"}]

<script type="text/javascript">
function setFnc(fnc, form) {
    var form = document.getElementById(form);
    form.fnc.value = fnc;
    form.submit();
}

function check(arthash, totalamount, amount) {
    var sub = document.getElementsByName(arthash)[0].value;
    if(sub.match(/^[0-9]{1,4}$/i)) {
        if(totalamount < amount) {
            document.getElementById('message').style.visibility = 'visible';
            document.getElementsByName(arthash)[0].value = totalamount;
        }
    } else {
        document.getElementById('message').style.visibility = 'visible';
        document.getElementsByName(arthash)[0].value = totalamount;
    }
}

function check_shipped(arthash, totalamount, amount) {
    var sub = document.getElementsByName(arthash)[1].value;
    if(sub.match(/^[0-9]{1,4}$/i)) {
        if(totalamount < amount) {
            document.getElementById('message').style.visibility = 'visible';
            document.getElementsByName(arthash)[1].value = totalamount;
        }
    } else {
        document.getElementById('message').style.visibility = 'visible';
        document.getElementsByName(arthash)[1].value = totalamount;
    }
}

function check_voucher(totalamount) {
    var vouchertotal = 0;
    var sub = document.getElementById('voucherAmount').value;
    var subKomma = document.getElementById('voucherAmountKomma').value;
    if(sub.match(/^[0-9]{1,4}$/i)) {
        vouchertotal = parseInt(sub);
        if(vouchertotal > totalamount) {
            document.getElementById('voucherAmount').value = "0";
            document.getElementById('message').style.visibility = 'visible';
        } else {
            if(subKomma.match(/^[0-9]{1,2}$/i)) {
                vouchertotal = sub + "." + subKomma;
                vouchertotal = parseFloat(vouchertotal);
                totalamount = parseFloat(totalamount);
                if(vouchertotal > totalamount) {
                    document.getElementById('message').style.visibility = 'visible';
                    document.getElementById('voucherAmountKomma').value = "00";
                }
            } else {
                document.getElementById('message').style.visibility = 'visible';
                document.getElementById('voucherAmountKomma').value = "00";
            }
        }
    } else {
        document.getElementById('message').style.visibility = 'visible';
        document.getElementById('voucherAmount').value = "0";
    }
}

function hideMessageBox() {
    document.getElementById('message').style.visibility = 'hidden';
}
</script>
