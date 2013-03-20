[{assign var="pi_payment" value=$oView->getPayment() }]
[{if $pi_payment->getId() == "pi_ratepay_rate" || $pi_payment->getId() == "pi_ratepay_rechnung"}]
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
[{/if}]
[{$smarty.block.parent}]
