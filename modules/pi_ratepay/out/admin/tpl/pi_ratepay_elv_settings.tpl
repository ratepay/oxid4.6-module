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

<script type="text/javascript">

    function check() {
    var text = document.getElementById('invoice_field').value;
    if(text.length > 520) {
    document.getElementById('invoice_field').value = text.substr(0,520);
}

}
</script>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td width="100%" align="center" valign="top">


            <form name="myedit" id="myedit" action="[{ $shop->selflink }]" method="post">
                [{ $shop->hiddensid }]
                <input type="hidden" name="cl" value="pi_ratepay_elv_settings">
                <input type="hidden" name="fnc" value="saveRatepaySettings">
                <input type="hidden" name="oxid" value="[{ $settings->pi_ratepay_settings__oxid->value }]">
                <input type="hidden" name="stoken" value="[{ $stoken }]">

                <table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
                    <tr height="10">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="15"></td>
                        <td valign="top" align="center" class="edittext">

                            [{ if $sError }]
                            <span class="loginerror">[{ $sError }]</span><br>
                            <br>
                            [{/if}]
                            RatePAY Modul v[{$moduleVersion}]<br/>
                            <fieldset title="[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_TITLE" }]" style="padding-left: 5px; padding-right: 5px;">
                                      <legend>[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_TITLE" }]</legend><br>
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td class="edittext" width="15%">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_PROFILEID" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" maxlength="255" name="profile_id" value="[{$settings->pi_ratepay_settings__profile_id->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_SECURITYCODE" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" maxlength="255" name="security_code" value="[{$settings->pi_ratepay_settings__security_code->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_SANDBOX" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            [{ if $settings->pi_ratepay_settings__sandbox->rawValue == 1}]
                                            <input type="checkbox" name="sandbox" checked='checked' value='on'>
                                            [{else}]
                                            <input type="checkbox" name="sandbox">
                                            [{/if}]
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_LOGGING" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            [{ if $settings->pi_ratepay_settings__logging->rawValue == 1}]
                                            <input type="checkbox" name="logging" checked='checked' value='on'>
                                            [{else}]
                                            <input type="checkbox" name="logging">
                                            [{/if}]
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_WHITELABEL" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            [{ if $settings->pi_ratepay_settings__whitelabel->rawValue == 1}]
                                            <input type="checkbox" name="whitelabel" checked='checked' value='on'>
                                            [{else}]
                                            <input type="checkbox" name="whitelabel">
                                            [{/if}]
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_SAVEBANKDATA" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            [{ if $settings->pi_ratepay_settings__savebankdata->rawValue == 1}]
                                            <input type="checkbox" name="savebankdata" checked='checked' value='on'>
                                            [{else}]
                                            <input type="checkbox" name="savebankdata">
                                            [{/if}]
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_RECHNUNG_SETTINGS_DUEDATE" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="duedate" value="[{$settings->pi_ratepay_settings__duedate->rawValue}]">
                                            &nbsp;[{ oxmultilang ident="PI_RATEPAY_RECHNUNG_SETTINGS_DUEDATE" }]
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_RATEPAY" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="ratepay_url" value="[{$settings->pi_ratepay_settings__ratepay_url->rawValue}]">
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                            <br/>
                            <br/>
                            <fieldset title="[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_BANKTITLE" }]" style="padding-left: 5px; padding-right: 5px;">
                                      <legend>[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_BANKTITLE" }]</legend><br>
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td class="edittext" width="15%">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_ACCOUNTHOLDER" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="account_holder" value="[{$settings->pi_ratepay_settings__account_holder->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_BANKNAME" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="bank_name" value="[{$settings->pi_ratepay_settings__bank_name->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_BANKCODENUMBER" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="bank_code_number" value="[{$settings->pi_ratepay_settings__bank_code_number->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_ACCOUNTNUMBER" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="account_number" value="[{$settings->pi_ratepay_settings__account_number->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_SWIFTBIC" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="swift_bic" value="[{$settings->pi_ratepay_settings__swift_bic->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_IBAN" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <input type="text" class="editinput" size="50" name="iban" value="[{$settings->pi_ratepay_settings__iban->rawValue}]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext" valign="top">
                                            [{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_INVOICEFIELD" }]:&nbsp;
                                        </td>
                                        <td class="edittext">
                                            <textarea class="editinput" cols="140" rows="4"  id="invoice_field" name="invoice_field" onkeyup="check();">[{$settings->pi_ratepay_settings__invoice_field->rawValue}]</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="edittext"></td>
                                        <td class="edittext">
                                            <br>
                                            <input type="submit" class="edittext" name="[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_SAVE" }]" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{ oxmultilang ident="PI_RATEPAY_ELV_SETTINGS_SAVE" }]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"><br>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
        </td>
    </tr>
</form>

</table>
[{include file="bottomitem.tpl"}]
