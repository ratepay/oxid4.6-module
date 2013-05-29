[{if $sPaymentID == "pi_ratepay_rate"}]
[{assign var="dynvalue" value=$oView->getDynValue()}]
<dl>
    <dt>
        <input id="payment_[{$sPaymentID}]" type="radio" name="paymentid" value="[{$sPaymentID}]" [{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]checked[{/if}] style="position:relative; [{if !$pi_ratepay_rate_whitelabel}]top:-17px;[{/if}]">
        <label for="payment_[{$sPaymentID}]"><b>
            [{if !$pi_ratepay_rate_whitelabel}]
                <img src="[{$oViewConf->getImageUrl()}]/pi_ratepay_rate_checkout_logo.png" title="RatePAY [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_WHITELABEL_TEXT"}]" alt="RatePAY [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_WHITELABEL_TEXT"}]" />
            [{else}]
                [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_WHITELABEL_TEXT"}]
            [{/if}]
        </b></label>
    </dt>
    <dd class="[{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]activePayment[{/if}]">
        <div id="policy[{$sPaymentID}]" style="display: none;">
            <h4>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_1"}]</h4>
            <p>
                [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_2"}]
                [{$pi_ratepay_rate_minimumAmount}]
                [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_3"}]
                [{$pi_ratepay_rate_maximumAmount}]
                [{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_4"}]
            </p>
            <p>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_6"}]</p>
            <p>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_5"}]</p>
        </div>
        <button id="policyButton[{$sPaymentID}]" class="submitButton largeButton" type="button">
            <span class="policyButtonText[{$sPaymentID}]">[{oxmultilang ident="PI_RATEPAY_SHOW_MORE_INFORMATION"}]</span>
            <span class="policyButtonText[{$sPaymentID}]" style="display: none;">[{oxmultilang ident="PI_RATEPAY_HIDE_MORE_INFORMATION"}]</span>
        </button>
        <ul class="form">
            [{if isset($pi_ratepay_rate_fon_check)}]
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_FON"}]</label>
                <input name='pi_ratepay_rate_fon' type='text' value='' size='37'>
            </li>
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_MOBILFON"}]</label>
                <input name='pi_ratepay_rate_mobilfon' type='text' value='' size='37'>
                <div class='note'>[{ oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_FON_NOTE" }]</div>
            </li>
            [{/if}]
            [{if isset($pi_ratepay_rate_birthdate_check)}]
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE"}]</label>
                <input name='pi_ratepay_rate_birthdate_day' maxlength='2' type='text' value='' data-fieldsize='small'>
                <input name='pi_ratepay_rate_birthdate_month' maxlength='2' type='text' value='' data-fieldsize='small'>
                <input name='pi_ratepay_rate_birthdate_year' maxlength='4' type='text' value='' data-fieldsize='small'>
                <div class='note'>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE_FORMAT"}]</div>
            </li>
            [{/if}]
            [{if isset($pi_ratepay_rate_company_check)}]
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_COMPANY"}]</label>
                <input name='pi_ratepay_rate_company' maxlength='255' size='37' type='text' value=''>
            </li>
            [{/if}]
            [{if isset($pi_ratepay_rate_ust_check)}]
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_RATE_VIEW_PAYMENT_UST"}]</label>
                <input name='pi_ratepay_rate_ust' maxlength='255' size='37' type='text' value=''>
            </li>
            [{/if}]
            [{if $pi_ratepay_rate_activateelv == 1}]
            <li>
                <label for="piRpRadioWire">[{oxmultilang ident="PI_RATEPAY_VIEW_RADIO_PAYMENT_WIRE"}]</label>
                <input id="piRpRadioWire" type="radio" name="pi_rp_rate_pay_method" value="pi_ratepay_rate_radio_wire" checked >
            </li>
            <li>
                <label for="piRpRadioElv">[{oxmultilang ident="PI_RATEPAY_VIEW_RADIO_LABEL_ELV"}]</label>
                <input id="piRpRadioElv" type="radio" name="pi_rp_rate_pay_method" value="pi_ratepay_rate_radio_elv">
            </li>
            [{/if}]
        </ul>
        [{if $pi_ratepay_rate_activateelv == 1}]
        <ul id="pi_ratepay_rate_bank_box" class="form">
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_OWNER"}]:</label>
                <input name='pi_ratepay_rate_bank_owner' maxlength='255' size='37' type='text' value='[{$piDbBankowner}]'/>
            </li>
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_ACCOUNT_NUMBER"}]:</label>
                <input name='pi_ratepay_rate_bank_account_number' maxlength='255' size='37' type='text' value='[{$piDbBankaccountnumber}]'/>
            </li>
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_CODE"}]:</label>
                <input name='pi_ratepay_rate_bank_code' maxlength='255' size='37' type='text' value='[{$piDbBankcode}]'/>
            </li>
            <li>
                <label>[{oxmultilang ident="PI_RATEPAY_ELV_VIEW_BANK_NAME"}]:</label>
                <input name='pi_ratepay_rate_bank_name' maxlength='255' size='37' type='text' value='[{$piDbBankname}]'/>
            </li>
        </ul>
        [{/if}]
        <div style="margin: 15px 0;">
            <input type="checkbox" name="pi_ratepay_rate_privacy" value="1" style="float: left;">
            <p>
                [{oxmultilang ident="PI_RATEPAY_VIEW_PRIVACY_AGREEMENT_TEXT_1"}]
                <a href='[{$pi_ratepay_rate_ratepayurl}]' target='_blank' style="text-decoration:underline;">[{oxmultilang ident="PI_RATEPAY_VIEW_PRIVACY_AGREEMENT_PRIVACYPOLICY"}]</a>
                [{if $policyurl != '' }]
                [{oxmultilang ident="PI_RATEPAY_VIEW_PRIVACY_AGREEMENT_TEXT_2"}]
                <a href='[{$policyurl}]' target='_blank' style="text-decoration:underline;">[{oxmultilang ident="PI_RATEPAY_VIEW_PRIVACY_AGREEMENT_OWNERPOLICY"}]</a>
                [{/if}]
                [{oxmultilang ident="PI_RATEPAY_VIEW_PRIVACY_AGREEMENT_TEXT_3"}]
            </p>
        </div>
    </dd>
</dl>

[{oxscript add="piTogglePolicy('$sPaymentID');"}]
[{oxscript add="$('#pi_ratepay_rate_bank_box').hide();"}]
[{oxscript add="piShow('#piRpRadioElv', '#pi_ratepay_rate_bank_box');"}]
[{oxscript add="piHide('#piRpRadioWire', '#pi_ratepay_rate_bank_box');"}]

[{else}]
[{$smarty.block.parent}]
[{/if}]
