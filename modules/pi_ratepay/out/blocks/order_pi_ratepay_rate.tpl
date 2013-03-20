[{$smarty.block.parent}]
[{if $pi_payment->getId() == "pi_ratepay_rate"}]
    <link type="text/css" rel="stylesheet" href="modules/pi_ratepay/ratenrechner/css/style.css"/>
    <script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/path.js"></script>
    <script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/layout.js"></script>
    <script type="text/javascript" src="modules/pi_ratepay/ratenrechner/js/ajax.js"></script>
    <div id="pirpmain-cont">

    </div>
    <script type="text/javascript">
    if(document.getElementById('pirpmain-cont')) {
        piLoadrateResult();
    }
    </script>
[{/if}]
