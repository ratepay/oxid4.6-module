[{if $pi_payment->getId()  == "pi_ratepay_rate" || $pi_payment->getId()  == "pi_ratepay_rechnung"}]
<form action="[{ $oViewConf->getSslSelfLink() }]" method="post" id="orderConfirmAgbBottom">
    [{ $oViewConf->getHiddenSid() }]
    [{ $oViewConf->getNavFormParams() }]
    <input type="hidden" name="cl" value="order">
    <input type="hidden" name="fnc" value="[{$oView->getExecuteFnc()}]">
    <input type="hidden" name="challenge" value="[{$challenge}]">
    <input type="hidden" name="ord_agb" value="1">
    [{if $oView->piIsFourPointSixShop()}]
        <input type="hidden" name="sDeliveryAddressMD5" value="[{$oView->getDeliveryAddressMD5()}]">
    [{/if}]
    <div class="agb">
        [{if $oView->isActive('PsLogin') }]
        <input type="hidden" name="ord_agb" value="1">
        [{else}]
        [{if $oView->isConfirmAGBActive()}]
        [{oxifcontent ident="oxrighttocancellegend" object="oContent"}]
        <h3 class="section">
            <strong>[{ $oContent->oxcontents__oxtitle->value }]</strong>
        </h3>
        <input type="hidden" name="ord_agb" value="0">
        <input id="checkAgbBottom" class="checkbox" type="checkbox" name="ord_agb" value="1">
        [{ $oContent->oxcontents__oxcontent->value }]
        [{/oxifcontent}]
        <p class="errorMsg" name="agbError">[{ oxmultilang ident="PAGE_CHECKOUT_ORDER_READANDCONFIRMTERMS" }]</p>
        [{else}]
        [{oxifcontent ident="oxrighttocancellegend2" object="oContent"}]
        <h3 class="section">
            <strong>[{ $oContent->oxcontents__oxtitle->value }]</strong>
        </h3>
        <input type="hidden" name="ord_agb" value="1">
        [{ $oContent->oxcontents__oxcontent->value }]
        [{/oxifcontent}]
        [{/if}]

        [{/if}]
    </div>
    <div class="lineBox clear">
        <div id="waitingWheel" class="popup" style="visibility:hidden;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #000000;display: block; height: 150px;left: 50%;margin-left: -135px;margin-top: -75px; padding: 10px;position: fixed;top: 50%;width: 270px;z-index: 2000;">
            <p>Bitte warten, Ihre Anfrage wird gerade &uuml;berpr&uuml;ft. Schlie&szlig;en Sie diese Seite nicht und klicken Sie nicht "Reload" bis die &Uuml;berpr&uuml;fung abgeschlossen ist. Dies wird ca. 10 Sekunden dauern.</p>
            <center><img class="waitIMG" src="[{$oViewConf->getImageUrl()}]ajax-loader.gif" alt="wait"/></center>
        </div>
        <a href="[{ $oViewConf->getSslSelfLink() }]cl=payment" class="submitButton largeButton">[{ oxmultilang ident="PAGE_CHECKOUT_ORDER_BACKSTEP" }]</a>
        <button type="submit" class="submitButton nextStep largeButton"  onClick="showWaitingWheel()">[{ oxmultilang ident="PAGE_CHECKOUT_ORDER_SUBMITORDER" }]</button>
    </div>
</form>
[{else}]
[{$smarty.block.parent}]
[{/if}]
