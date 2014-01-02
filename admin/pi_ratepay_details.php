<?php

/**
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
 * @package   PayIntelligent_RatePAY
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * RatePay order admin panel
 * {@inheritdoc}
 *
 * @package   PayIntelligent_RatePAY
 * @extends oxAdminDetails
 */
class pi_ratepay_details extends oxAdminDetails
{

    /**
     * Unique Order ID
     *
     * @var string
     */
    private $orderId = null;

    /**
     * Amount of the Goodwill
     *
     * @var double
     */
    private $piRatepayVoucher = null;

    /**
     * Database Table name used for Order details
     *
     * @var string
     */
    private $pi_ratepay_order_details;

    /**
     * Type of the Order rate/rechnung
     *
     * @var string
     */
    private $_paymentMethod;

    /**
     * Order Model Object
     * An representation of the order whicht get edited.
     *
     * @var oxOrder
     */
    private $_oEditObject = null;

    /**
     *
     * @var mixed
     */
    private $_paymentSid;

    /**
     * request data backend object, get User Data.
     *
     * @var pi_ratepay_requestdatabackend
     */
    private $_requestDataBackend;

    /**
     * payment change subtypes
     *
     * @var array
     */
    private $_paymentChangeSubtype = array(
        'cancel' => 'partial-cancellation',
        'cancelfull' => 'full-cancellation',
        'return' => 'partial-return',
        'returnfull' => 'full-return'
    );

    /**
     * Is shop set to UTF8 Mode
     * @var bool
     */
    private $_utfMode = null;

    /**
     * Preparing all necessary Data for rendering and executing all calls
     * also: {@inheritdoc}
     *
     * @see oxAdminDetails::render()
     * @return string
     */
    public function render()
    {
        parent::render();

        $order = $this->getEditObject();

        $paymentSid = $this->_getPaymentSid();

        if ($paymentSid && in_array($paymentSid, pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD)) {
            $this->_initRatepayDetails($order);
            return "pi_ratepay_details.tpl";
        }

        return "pi_ratepay_no_details.tpl";
    }

    /**
     * Initialises smarty variables specific to RatePAY order.
     * @param oxorder $order
     */
    private function _initRatepayDetails(oxOrder $order)
    {
        $this->_paymentMethod = pi_ratepay_util_utilities::getPaymentMethod($this->_getPaymentSid());

        $this->pi_ratepay_order_details = 'pi_ratepay_order_details';

        $this->_requestDataBackend = oxNew('pi_ratepay_requestdatabackend', $this->getEditObject());

        $this->addTplParam('pitotalamount', number_format($order->getTotalOrderSum(), 2));

        $this->addTplParam('pi_ratepay_payment_type', $this->_paymentMethod);
        $this->addTplParam('articleList', $this->getPreparedOrderArticles());
        $this->addTplParam('historyList', $this->getHistory($this->_aViewData["articleList"]));

        if ($this->_getPaymentSid() == "pi_ratepay_rate") {
            $ratepayRateDetails = oxNew('pi_ratepay_ratedetails');
            $ratepayRateDetails->loadByOrderId($this->_getOrderId());

            $pirptotalamountvalue = $ratepayRateDetails->pi_ratepay_rate_details__totalamount->rawValue;
            $pirpamountvalue = $ratepayRateDetails->pi_ratepay_rate_details__amount->rawValue;
            $pirpinterestamountvalue = $ratepayRateDetails->pi_ratepay_rate_details__interestamount->rawValue;
            $pirpservicechargevalue = $ratepayRateDetails->pi_ratepay_rate_details__servicecharge->rawValue;
            $pirpannualpercentageratevalue = $ratepayRateDetails->pi_ratepay_rate_details__annualpercentagerate->rawValue;
            $pirpdebitinterestvalue = $ratepayRateDetails->pi_ratepay_rate_details__monthlydebitinterest->rawValue;
            $pirpnumberofratesvalue = $ratepayRateDetails->pi_ratepay_rate_details__numberofrates->rawValue;
            $pirpratevalue = $ratepayRateDetails->pi_ratepay_rate_details__rate->rawValue;
            $pirplastratevalue = $ratepayRateDetails->pi_ratepay_rate_details__lastrate->rawValue;

            $pirptotalamountvalue = str_replace(".", ",", number_format($pirptotalamountvalue, 2, ".", "")) . " EUR";
            $pirpamountvalue = str_replace(".", ",", number_format($pirpamountvalue, 2, ".", "")) . " EUR";
            $pirpinterestamountvalue = str_replace(".", ",", number_format($pirpinterestamountvalue, 2, ".", "")) . " EUR";
            $pirpservicechargevalue = str_replace(".", ",", number_format($pirpservicechargevalue, 2, ".", "")) . " EUR";
            $pirpannualpercentageratevalue = str_replace(".", ",", number_format($pirpannualpercentageratevalue, 2, ".", "")) . "%";
            $pirpdebitinterestvalue = str_replace(".", ",", number_format($pirpdebitinterestvalue, 2, ".", "")) . "%";
            $pirpnumberofratesvalue = str_replace(".", ",", number_format($pirpnumberofratesvalue, 2, ".", "")) . " Monate";
            $pirpratevalue = str_replace(".", ",", number_format($pirpratevalue, 2, ".", "")) . " EUR";
            $pirplastratevalue = str_replace(".", ",", number_format($pirplastratevalue, 2, ".", "")) . " EUR";

            $this->addTplParam('pirptotalamountvalue', $pirptotalamountvalue);
            $this->addTplParam('pirpamountvalue', $pirpamountvalue);
            $this->addTplParam('pirpinterestamountvalue', $pirpinterestamountvalue);
            $this->addTplParam('pirpservicechargevalue', $pirpservicechargevalue);
            $this->addTplParam('pirpannualpercentageratevalue', $pirpannualpercentageratevalue);
            $this->addTplParam('pirpmonthlydebitinterestvalue', $pirpdebitinterestvalue);
            $this->addTplParam('pirpnumberofratesvalue', $pirpnumberofratesvalue);
            $this->addTplParam('pirpratevalue', $pirpratevalue);
            $this->addTplParam('pirplastratevalue', $pirplastratevalue);
        }
    }

    /**
     * init RatePay data, start deliver request
     */
    public function deliver()
    {
        $this->_initRatepayDetails($this->getEditObject());
        $this->deliverRequest();
    }

    /**
     * init RatePay data, start paymentChangeRequest
     */
    public function cancel()
    {
        $this->_initRatepayDetails($this->getEditObject());
        $this->paymentChangeRequest('cancel');
    }

    /**
     * init RatePay data, start paymentChangeRequest
     */
    public function retoure()
    {
        $this->_initRatepayDetails($this->getEditObject());
        $this->paymentChangeRequest('return');
    }

    /**
     * init RatePay data, start credit request
     *
     * @return null
     */
    public function credit()
    {
        $voucherAmount = oxConfig::getParameter('voucherAmount');
        $voucherKomma = oxConfig::getParameter('voucherAmountKomma');

        $this->_initRatepayDetails($this->getEditObject());

        if (isset($voucherAmount) && preg_match("/^[0-9]{1,4}$/", $voucherAmount)) {
            $voucherKomma = isset($voucherKomma) && preg_match('/^[0-9]{1,2}$/', $voucherKomma)? $voucherKomma : '00';

            $voucherAmount .= '.' . $voucherKomma;
            $voucherAmount = (double) $voucherAmount;

            if ($voucherAmount <= $this->getEditObject()->getTotalOrderSum() && $voucherAmount > 0) {
                $this->piRatepayVoucher = $voucherAmount;

                $this->creditRequest();
                return;
            }
        }

        $this->addTplParam('pierror', 'credit');
    }

    /**
     * Gets the History of the order
     *
     * @param array articleList
     * @return string
     */
    private function getHistory($articleList)
    {
        $ratepayHistoryList = oxNew('pi_ratepay_historylist');
        $ratepayHistoryList->getFilteredList("order_number = '" . $this->_getOrderId() . "'");

        $historyList = array();

        foreach ($ratepayHistoryList as $historyItem) {
            $title = '';
            $articleNumber = '';

            foreach ($articleList as $article) {
                if ($historyItem->pi_ratepay_history__article_number->rawValue == $article['artid']) {
                    $title = $article['title'];
                    $articleNumber = $article['artnum'];
                }
            }

            array_push($historyList, array(
                'article_number' => $articleNumber,
                'title'          => $title,
                'quantity'       => $historyItem->pi_ratepay_history__quantity->rawValue,
                'method'         => $historyItem->pi_ratepay_history__method->rawValue,
                'subtype'        => $historyItem->pi_ratepay_history__subtype->rawValue,
                'date'           => $historyItem->pi_ratepay_history__date->rawValue
            ));
        }

        return $historyList;
    }

    /**
     * Gets all articles with additional informations
     *
     * @return array
     */
    public function getPreparedOrderArticles()
    {
        $detailsViewData = oxNew('pi_ratepay_detailsviewdata', $this->_getOrderId());

        return $detailsViewData->getPreparedOrderArticles();
    }

    /**
     * add new voucher for order
     *
     * @return string oxId of voucher
     */
    private function piAddVoucher()
    {
        $order = $this->getEditObject();
        $orderId = $this->_getOrderId();

        $voucherCount = oxDb::getDb()->getOne("SELECT count( * ) AS nr FROM `oxvouchers`	WHERE oxvouchernr LIKE 'pi-Merchant-Voucher-%'");
        $voucherNr = "pi-Merchant-Voucher-" . $voucherCount;

        $newVoucher = oxNew("oxvoucher");
        $newVoucher->assign(array(
            'oxvoucherserieid' => 'Anbieter Gutschrift',
            'oxorderid' => $orderId,
            'oxuserid' => $order->getFieldData("oxuserid"),
            'oxdiscount' => $this->piRatepayVoucher,
            'oxdateused' => date('Y-m-d', oxUtilsDate::getInstance()->getTime()),
            'oxvouchernr' => $voucherNr
        ));

        $newVoucher->save();

        $order->oxorder__oxvoucherdiscount->setValue($order->getFieldData("oxvoucherdiscount") + $this->piRatepayVoucher);
        $this->_recalculateOrder($order);

        $voucherId = $newVoucher->getId();

        $voucherDetails = oxNew('pi_ratepay_orderdetails');

        $voucherDetails->assign(array(
            'order_number' => $orderId,
            'article_number' => $voucherId,
            'ordered' => 1
        ));

        $voucherDetails->save();

        return $voucherId;
    }

    /**
     * Do RatePay request. If the request succeeds add voucher to order and log to history.
     */
    protected function creditRequest()
    {
        $operation = "PAYMENT_CHANGE";
        $subtype = "credit";

        $response = $this->ratepayRequest($operation, $subtype);

        $isSuccess = 'pierror';
        if ($response && (string) $response->head->processing->result->attributes()->code == '403') {
            $artid = $this->piAddVoucher();
            $this->_logHistory($this->_getOrderId(), $artid, 1, $operation, $subtype);

            $isSuccess = 'pisuccess';
        }
        $this->addTplParam($isSuccess, $subtype);
    }

    /**
     * Excecute payment change request. If the request succeeds add voucher to order and log to history.
     * @param string $paymentChangeType 'cancel' or 'return
     */
    protected function paymentChangeRequest($paymentChangeType)
    {
        $operation = 'PAYMENT_CHANGE';

        $full = $this->_isPaymentChangeFull()? 'full' : '';

        $subtype = $this->_paymentChangeSubtype[$paymentChangeType . $full];

        $response = $this->ratepayRequest($operation, $subtype);

        $isSuccess = 'pierror';
        if ($response && (string) $response->head->processing->result->attributes()->code == '403') {
            $articles = $this->getPreparedOrderArticles();
            $articleList = array();
            foreach ($articles as $article) {
                if (oxConfig::getParameter($article['arthash']) > 0) {
                    $quant = oxConfig::getParameter($article['arthash']);
                    $artid = $article['artid'];
                    if ($subtype == "partial-cancellation" || $subtype == "full-cancellation") {
                        oxDb::getDb()->execute("update $this->pi_ratepay_order_details set cancelled=cancelled+$quant where order_number='" . $this->_getOrderId() . "' and article_number='$artid'");
                    } else if ($subtype == "partial-return" || $subtype == "full-return") {
                        oxDb::getDb()->execute("update $this->pi_ratepay_order_details set returned=returned+$quant where order_number='" . $this->_getOrderId() . "' and article_number='$artid'");
                    }
                    $this->_logHistory($this->_getOrderId(), $artid, $quant, $operation, $subtype);
                    if ($article['oxid'] != "") {
                        $articleList[$article['oxid']] = array('oxamount' => $article['ordered'] - $article['cancelled'] - $article['returned'] - oxConfig::getParameter($article['arthash']));
                    } else {
                        $oOrder = $this->getEditObject();

                        if ($article['artid'] == "oxdelivery") {
                            $oOrder->oxorder__oxdelcost->setValue(0);
                        } else if ($article['artid'] == "oxpayment") {
                            $oOrder->oxorder__oxpaycost->setValue(0);
                        } else if ($article['artid'] == "oxwrapping") {
                            $oOrder->oxorder__oxwrapcost->setValue(0);
                        } else if ($article['artid'] == "oxtsprotection") {
                            $oOrder->oxorder__oxtsprotectcosts->setValue(0);
                        } else if ($article['artid'] == "Discount") {
                            $oOrder->oxorder__oxdiscount->setValue(0);
                        } else {
                            $value = $oOrder->oxorder__oxvoucherdiscount->getRawValue() + $article['totalprice'];
                            $oOrder->oxorder__oxvoucherdiscount->setValue($value);
                        }
                    }
                }
            }
            $this->updateOrder($articleList, $full);
            $isSuccess = 'pisuccess';
        }
        $this->addTplParam($isSuccess, $subtype);
    }

    /**
     * Tests if all available articles are returned or cancelled.
     * @return boolean
     */
    protected function _isPaymentChangeFull()
    {
        $full = true;
        $articles = $this->getPreparedOrderArticles();

        foreach ($articles as $article) {
            if (oxConfig::getParameter($article['arthash']) != $article['ordered']) {
                $full = false;
            }
        }

        return $full;
    }

    /**
     * Excecute payment change request. If the request succeeds add voucher to order and log to history.
     */
    protected function deliverRequest()
    {
        $operation = 'CONFIRMATION_DELIVER';
        $subtype = '';

        $response = $this->ratepayRequest($operation, $subtype);

        $isSuccess = 'pierror';
        if ($response && (string) $response->head->processing->result->attributes()->code == '404') {
            $articles = $this->getPreparedOrderArticles();
            foreach ($articles as $article) {
                if (oxConfig::getParameter($article['arthash']) > 0) {
                    $quant = oxConfig::getParameter($article['arthash']);
                    $artid = $article['artid'];
                    // @todo this can be done better
                    oxDb::getDb()->execute("update $this->pi_ratepay_order_details set shipped=shipped+$quant where order_number='" . $this->_getOrderId() . "' and article_number='$artid'");
                    $this->_logHistory($this->_getOrderId(), $artid, $quant, $operation, $subtype);
                }
            }
            $isSuccess = 'pisuccess';
        }

        $this->addTplParam($isSuccess, $subtype);
    }

    /**
     * Handles requests to RatePay and success/error messages for the view
     *
     * @param string $operation RatePay Actions, like: payment change, credit, deliver confirmation etc.
     */
    private function ratepayRequest($operation, $subtype)
    {
        $ratepay = $this->_getRatepayXmlService();

        $request = $ratepay->getXMLObject();

        $this->setRatepayHead($request, $operation, $subtype);
        $this->setRatepayContent($request, $operation, $subtype);

        $response = $ratepay->paymentOperation($request, $this->_paymentMethod);

        $ratepayOrder = oxNew('pi_ratepay_orders');
        $ratepayOrder->loadByOrderNumber($this->_getOrderId());

        $transId = $ratepayOrder->pi_ratepay_orders__transaction_id->rawValue;

        $fname = $this->removeSpecialChars(html_entity_decode($this->_requestDataBackend->getCustomerFirstName()));
        $lname = $this->removeSpecialChars(html_entity_decode($this->_requestDataBackend->getCustomerLastName()));

        $response = $response? $response : null;
        pi_ratepay_LogsService::getInstance()->logRatepayTransaction($this->_getOrderId(), $transId, $this->_paymentMethod, $operation, $subtype, $request, $fname, $lname, $response);

        if (isset($response) && (string) $response->head->processing->status->attributes()->code == "OK") {
            return $response;
        }

        $this->addTplParam('pierror', $subtype);

        return false;
    }

    /**
     * logs ratepay backend transactions history.
     *
     * @param string $orderId oxid of the order
     * @param string $artid oxid of the article which is modified
     * @param string $quant quantity which is changed
     * @param string $operation (deliver, payment change, credit)
     * @param string $subtype (cancellation, return)
     */
    protected function _logHistory($orderId, $artid, $quant, $operation, $subtype)
    {
        $ratepayHistory = oxNew('pi_ratepay_history');
        $ratepayHistory->assign(array(
            'order_number'   => $orderId,
            'article_number' => $artid,
            'quantity'       => $quant,
            'method'         => $operation,
            'submethod'      => $subtype,
            'date'           => date('Y-m-d H:i:s', oxUtilsDate::getInstance()->getTime())
        ));
        $ratepayHistory->save();
    }

    /**
     * Construct header of RatePay Request XML
     *
     * @param SimpleXMLExtended $request XML representation of the request
     * @param string $operation RatePay Actions, like: payment change, credit, deliver confirmation etc.
     * @param string $subtype Actions subtypes, like: full cancellation, partial cancellation, full return, partial return
     */
    private function setRatepayHead($request, $operation, $subtype)
    {
        $ratepayOrder = oxNew('pi_ratepay_orders');
        $ratepayOrder->loadByOrderNumber($this->_getOrderId());

        $systemId = $this->getRatepaySystemID();
        $transid = $ratepayOrder->pi_ratepay_orders__transaction_id->rawValue;
        $transshortid = $ratepayOrder->pi_ratepay_orders__transaction_short_id->rawValue;

        $head = $request->addChild('head');
        $head->addChild('system-id', $systemId);
        $head->addChild('transaction-id', $transid);
        $head->addChild('transaction-short-id', $transshortid);
        $operation = $head->addChild('operation', $operation);

        if ($operation == "PAYMENT_CHANGE") {
            $operation->addAttribute('subtype', $subtype);
        }

        $this->setRatepayHeadCredentials($head);
        $this->setRatepayHeadExternal($head);
        $this->_setRatepayHeadMeta($head);
    }

    /**
     * Add shop name and version. Add also module version.
     * <system name=”<shopname>_<edition>” version=”<shopversion>_<moduleversion>”></system>
     *
     * @param SimpleXMLExtended $head
     */
    private function _setRatepayHeadMeta($head)
    {
        $meta = $head->addChild('meta');
        $systems = $meta->addChild('systems');
        $system = $systems->addChild('system');

        $system->addAttribute('name', 'OXID_' . oxConfig::getInstance()->getEdition());
        $system->addAttribute('version', oxConfig::getInstance()->getVersion() . '_' . pi_ratepay_util_utilities::PI_MODULE_VERSION);
    }

    /**
     * Adds credentials to RatePay Request XML header
     *
     * @param SimpleXMLExtended $head RatePay Request XML header
     */
    private function setRatepayHeadCredentials($head)
    {
        $credential = $head->addChild('credential');

        $settings = $this->_getSettings();

        $profileId = $settings->pi_ratepay_settings__profile_id->rawValue;
        $securityCode = $settings->pi_ratepay_settings__security_code->rawValue;

        $credential->addChild('profile-id', $profileId);
        $credential->addChild('securitycode', $securityCode);
    }

    /**
     * Add external (orderId) to RatePay Request XML Header
     *
     * @param SimpleXMLExtended $head RatePay Request XML Header
     */
    private function setRatepayHeadExternal($head)
    {
        $external = $head->addChild('external');

        $external->addChild('order-id', $this->getEditObject()->oxorder__oxordernr->value);
    }

    /**
     * Construct body of RatePay Request XML
     *
     * @param SimpleXMLExtended $request XML representation of the request
     * @param string $operation RatePay Actions, like: payment change, credit, deliver confirmation etc.
     * @param string $subtype Actions subtypes, like: full cancellation, partial cancellation, full return, partial return
     */
    private function setRatepayContent($request, $operation, $subtype)
    {
        $content = $request->addChild('content');
        if ($operation == "CONFIRMATION_DELIVER") {
            if ($this->_getPaymentSid() === 'pi_ratepay_rechnung' || $this->_getPaymentSid() === 'pi_ratepay_elv') {
                $this->_setContentInvoicing($content);
            }
            $this->setRatepayContentBasket($content);
        } else if ($operation == "PAYMENT_CHANGE") {
            $total = $this->_orderTotalAmount($subtype);
            $this->setRatepayContentCustomer($content);
            $this->setRatepayContentBasketChange($content, $subtype, $total);
            $this->setRatepayContentPayment($content, $total);
        }
    }

    /**
     * Calculate total amount of the order.
     *
     * @param string $subtype
     * @return int
     */
    private function _orderTotalAmount($subtype)
    {
        $total = 0;

        $articles = $this->getPreparedOrderArticles();
        $total = 0;

        foreach ($articles as $article) {
            if ($subtype == "credit") {
                $total = $total + (($article['ordered'] - $article['cancelled'] - $article['returned']) * $article['unitprice']);
            } else {
                $total = $total + (($article['ordered'] - $article['cancelled'] - $article['returned'] - oxConfig::getParameter($article['arthash'])) * $article['unitprice']);
            }
        }

        if ($subtype == "credit") {
            $total = $total - $this->piRatepayVoucher;
        }

        return $total;
    }

    /**
     * Add 'shopping-basket node' to RatePay Request XML with the attributes amount and currency.
     *
     * If subtype of the request is other than full cancellation or full return, calculate the new total amount.
     * If the subtype is full cancellation or full return add an amount of zero.
     *
     * @param SimpleXMLExtended $content XML representation of the request
     * @param string $subtype Actions subtypes, like: full cancellation, partial cancellation, full return, partial return
     */
    private function setRatepayContentBasketChange($content, $subtype, $total)
    {
        $shoppingBasket = $content->addChild('shopping-basket');
        $shoppingBasket->addAttribute('amount', number_format($total, 2, ".", ""));
        $shoppingBasket->addAttribute('currency', 'EUR');
        $this->setRatepayContentBasketItemsChange($shoppingBasket, $subtype);
    }

    /**
     * Adds 'items' node to the RatePay Request XML.
     *
     * If subtype of the request is other than full cancellation or full return
     * call to this setRatepayContentBasketItemsChange.
     *
     * @param SimpleXMLExtended $shoppingBasket XML representation of the request
     * @param type $subtype Actions subtypes, like: full cancellation, partial cancellation, full return, partial return
     */
    private function setRatepayContentBasketItemsChange($shoppingBasket, $subtype)
    {
        $items = $shoppingBasket->addChild('items');
        $this->setRatepayContentBasketItemsItemChange($items, $subtype);
    }

    /**
     * Add 'item' for each article of the order which remains after a partial cancellation or a partial delivery.
     *
     * @param SimpleXMLExtended $items XML representation of the request
     * @param type $subtype Actions subtypes, like: full cancellation, partial cancellation, full return, partial return
     */
    private function setRatepayContentBasketItemsItemChange($items, $subtype)
    {
        $articles = $this->getPreparedOrderArticles();
        foreach ($articles as $article) {
            if ($subtype == "credit") {
                $quant = $article['ordered'] - $article['cancelled'] - $article['returned'];
            } else {
                $quant = $article['ordered'] - $article['cancelled'] - $article['returned'] - (int) oxConfig::getParameter($article['arthash']);
            }

            if ($quant > 0) {
                $title = $this->removeSpecialChars(html_entity_decode($article['title']));
                $item = $items->addCDataChild('item', $title, $this->_isUtfMode());
                $item->addAttribute('article-number', $article['artnum']);
                $item->addAttribute('quantity', $quant);
                $item->addAttribute('unit-price', $this->_convertNumber($article['unitPriceNetto']));
                $item->addAttribute('total-price', $this->_convertNumber($article['unitPriceNetto']) * $quant);
                $item->addAttribute('tax', ($this->_convertNumber($article['unitprice']) - $this->_convertNumber($article['unitPriceNetto'])) * $quant);
            }
        }

        if ($subtype == "credit") {
            $nr = oxDb::getDb()->getOne("SELECT count( * ) AS nr FROM `oxvouchers` WHERE oxvouchernr LIKE 'pi-Merchant-Voucher-%'");
            $vouchertitel = "pi-Merchant-Voucher-" . $nr;
            $item = $items->addChild('item', "Anbieter Gutschrift");
            $item->addAttribute('article-number', $vouchertitel);
            $item->addAttribute('quantity', 1);
            $item->addAttribute('unit-price', "-" . number_format($this->piRatepayVoucher, 2, ".", ""));
            $item->addAttribute('total-price', "-" . number_format($this->piRatepayVoucher, 2, ".", ""));
            $item->addAttribute('tax', number_format(0, 2, ".", ""));
        }
    }

    /**
     * Add invoicing information to the request
     *
     * @param SimpleXMLExtended $content
     */
    private function _setContentInvoicing($content)
    {
        $dueDays = $this->_getSettings()->pi_ratepay_settings__duedate->rawValue;
        $invoicing = $content->addChild('invoicing');
        $invoicing->addChild('due-date', date(DATE_ATOM, mktime(date("H"), date("i"), date("s"), date("m"), date("d") + $dueDays, date("Y"))));
    }

    /**
     * Add node 'shopping-basket' with total 'amount' attribute and currency.
     * Call to this setRatepayContentBasketItems.
     *
     * @param SimpleXMLExtended $content XML representation of the request
     */
    private function setRatepayContentBasket($content)
    {
        $articles = $this->getPreparedOrderArticles();
        $total = 0;
        foreach ($articles as $article) {
            if (oxConfig::getParameter($article['arthash']) > 0) {
                $total = $total + (oxConfig::getParameter($article['arthash']) * $article['unitprice']);
            }
        }
        $shoppingBasket = $content->addChild('shopping-basket');
        $shoppingBasket->addAttribute('amount', number_format($total, 2, ".", ""));
        $shoppingBasket->addAttribute('currency', 'EUR');
        $this->setRatepayContentBasketItems($shoppingBasket);
    }

    /**
     * Add node 'items' and call this setRatepayContentBasketItemsItem.
     *
     * @param SimpleXMLExtended $shoppingBasket XML representation of the request
     */
    private function setRatepayContentBasketItems($shoppingBasket)
    {
        $items = $shoppingBasket->addChild('items');
        $this->setRatepayContentBasketItemsItem($items);
    }

    /**
     * Add 'item' childnodes to 'items' node with attributes: article-number, quantity, unit-price, total-price and tax.
     * Also adds the title of the article as cdata childnote of 'item'.
     *
     * @param SimpleXMLExtended $items XML representation of the request
     */
    private function setRatepayContentBasketItemsItem($items)
    {
        $articles = $this->getPreparedOrderArticles();
        foreach ($articles as $article) {
            if (oxConfig::getParameter($article['arthash']) > 0) {

                $title = $this->removeSpecialChars(html_entity_decode($article['title']));
                $item = $items->addCDataChild('item', $title, $this->_isUtfMode());
                $quant = (int) oxConfig::getParameter($article['arthash']);

                $item->addAttribute('article-number', $article['artnum']);
                $item->addAttribute('quantity', $quant);
                $item->addAttribute('unit-price', $this->_convertNumber($article['unitPriceNetto']));
                $item->addAttribute('total-price', $this->_convertNumber($article['unitPriceNetto']) * $quant);
                $item->addAttribute('tax', ($this->_convertNumber($article['unitprice']) - $this->_convertNumber($article['unitPriceNetto'])) * $quant);
            }
        }
    }

    /**
     * Adds customer Information to the request xml
     *
     * @param SimpleXMLExtended $content
     */
    private function setRatepayContentCustomer($content)
    {
        $customer = $content->addChild('customer');

        $gender = $this->_requestDataBackend->getGender();

        $cid = oxDb::getDb()->getOne("select OXBILLCOUNTRYID from oxorder where oxid='" . $this->_getOrderId() . "'");
        $country = oxDb::getDb()->getOne("SELECT OXISOALPHA2 FROM oxcountry WHERE OXID = '$cid'");

        $fname = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLFNAME from oxorder where oxid='" . $this->_getOrderId() . "'")));
        $customer->addCDataChild('first-name', $fname, $this->_isUtfMode());
        $lname = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLLNAME from oxorder where oxid='" . $this->_getOrderId() . "'")));
        $customer->addCDataChild('last-name', $lname, $this->_isUtfMode());

        $customer->addChild('gender', $gender);

        $ratepayOrder = oxNew('pi_ratepay_orders');
        $ratepayOrder->loadByOrderNumber($this->_getOrderId());

        $userBirth = $ratepayOrder->pi_ratepay_orders__userbirthdate->rawValue;
        $customer->addChild('date-of-birth', $userBirth);

        $billcompany = oxDb::getDb()->getOne("select OXBILLCOMPANY from oxorder where oxid='" . $this->_getOrderId() . "'");
        $billustid = oxDb::getDb()->getOne("select OXBILLUSTID from oxorder where oxid='" . $this->_getOrderId() . "'");

        if ($billcompany != '' && $billustid != '') {
            $customer->addCDataChild('company-name', $billcompany, $this->_isUtfMode());
            $customer->addChild('vat-id', $billustid);
        }

        $this->setRatepayContentCustomerContacts($customer);
        $this->setRatepayContentCustomerAddress($customer);

        $customer->addChild('nationality', $country);
        $customer->addChild('customer-allow-credit-inquiry', 'yes');
    }

    /**
     * Adds customer contact information to request xml.
     *
     * @param SimpleXMLExtended $customer
     */
    private function setRatepayContentCustomerContacts($customer)
    {
        $contacts = $customer->addChild('contacts');
        $contacts->addChild('email', oxDb::getDb()->getOne("select oxbillemail from oxorder where oxid='" . $this->_getOrderId() . "'"));

        $this->setRatepayContentCustomerContactsPhone($contacts);
    }

    /**
     * Adds customers' phone number to the request xml
     *
     * @param SimpleXMLExtended $contacts
     */
    private function setRatepayContentCustomerContactsPhone($contacts)
    {
        $phone = $contacts->addChild('phone');
        $phone->addChild('direct-dial', oxDb::getDb()->getOne("select oxbillfon from oxorder where oxid='" . $this->_getOrderId() . "'"));
    }

    /**
     * Adds customer addresses to request xml
     * @uses setRatepayContentCustomerAddressBilling
     * @uses setRatepayContentCustomerAddressShipping
     *
     * @param SimpleXMLExtended $customer
     */
    private function setRatepayContentCustomerAddress($customer)
    {
        $addresses = $customer->addChild('addresses');

        $this->setRatepayContentCustomerAddressBilling($addresses);
        $this->setRatepayContentCustomerAddressShipping($addresses);
    }

    /**
     * Adds customer billding address to request xml
     *
     * @param SimpleXMLExtended $addresses
     */
    private function setRatepayContentCustomerAddressBilling($addresses)
    {
        $orderId = $this->_getOrderId();
        $billingAddress = $addresses->addChild('address');
        $billingAddress->addAttribute('type', 'BILLING');
        $street = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLSTREET from oxorder where oxid='$orderId'")));
        $billingAddress->addCDataChild('street', $street, $this->_isUtfMode());

        $billingAddress->addChild('street-number', oxDb::getDb()->getOne("select OXBILLSTREETNR from oxorder where oxid='$orderId'"));
        $billingAddress->addChild('zip-code', oxDb::getDb()->getOne("select OXBILLZIP from oxorder where oxid='$orderId'"));

        $city = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLCITY from oxorder where oxid='$orderId'")));
        $billingAddress->addCDataChild('city', $city, $this->_isUtfMode());

        $cid = oxDb::getDb()->getOne("select OXBILLCOUNTRYID from oxorder where oxid='$orderId'");
        $country = oxDb::getDb()->getOne("SELECT OXISOALPHA2 FROM oxcountry WHERE OXID = '$cid'");
        $billingAddress->addChild('country-code', $country);
    }

    /**
     * Adds customer shipping address to request xml
     *
     * @param SimpleXMLExtended $addresses
     */
    private function setRatepayContentCustomerAddressShipping($addresses)
    {
        $orderId = $this->_getOrderId();
        $shippingAddress = $addresses->addChild('address');
        $shippingAddress->addAttribute('type', 'DELIVERY');

        $street = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLSTREET from oxorder where oxid='$orderId'")));
        $shippingAddress->addCDataChild('street', $street, $this->_isUtfMode());

        $shippingAddress->addChild('street-number', oxDb::getDb()->getOne("select OXBILLSTREETNR from oxorder where oxid='$orderId'"));
        $shippingAddress->addChild('zip-code', oxDb::getDb()->getOne("select OXBILLZIP from oxorder where oxid='$orderId'"));

        $city = $this->removeSpecialChars(html_entity_decode(oxDb::getDb()->getOne("select OXBILLCITY from oxorder where oxid='$orderId'")));
        $shippingAddress->addCDataChild('city', $city, $this->_isUtfMode());

        $cid = oxDb::getDb()->getOne("select OXBILLCOUNTRYID from oxorder where oxid='$orderId'");
        $country = oxDb::getDb()->getOne("SELECT OXISOALPHA2 FROM oxcountry WHERE OXID = '$cid'");
        $shippingAddress->addChild('country-code', $country);
    }

    /**
     * Adds payment informations to request xml
     *
     * @param SimpleXMLExtended $content
     * @param string $subtype
     */
    private function setRatepayContentPayment($content, $total)
    {
        $payment = $content->addChild('payment');

        $payment->addAttribute('method', $this->_paymentMethod);
        $payment->addAttribute('currency', 'EUR');
        $payment->addChild('amount', number_format($total, 2, ".", ""));
    }

    /**
     * Updates order articles stock and recalculates order
     *
     * @return null
     */
    public function updateOrder($articleList, $fullCancellation)
    {
        $aOrderArticles = $articleList;

        if (is_array($aOrderArticles) && $oOrder = $this->getEditObject()) {

            $myConfig = $this->getConfig();
            $oOrderArticles = $oOrder->getOrderArticles();

            $blUseStock = $myConfig->getConfigParam('blUseStock');
            if ($fullCancellation) {
                $oOrder->oxorder__oxstorno = new oxField(1);
            }

            $oOrder->save();

            foreach ($oOrderArticles as $oOrderArticle) {
                $sItemId = $oOrderArticle->getId();
                if (isset($aOrderArticles[$sItemId])) {

                    // update stock
                    if ($blUseStock) {
                        $oOrderArticle->setNewAmount($aOrderArticles[$sItemId]['oxamount']);
                    } else {
                        $oOrderArticle->assign($aOrderArticles[$sItemId]);
                        $oOrderArticle->save();
                    }
                    if ($aOrderArticles[$sItemId]['oxamount'] == 0) {
                        $this->storno($sItemId);
                    }
                }
            }

            // recalculating order
            $this->_recalculateOrder($oOrder);
        }
    }

    /**
     * cancels order item
     *
     * @param string $sItemId
     */
    public function storno($sItemId)
    {
        $myConfig = $this->getConfig();

        $sOrderArtId = $sItemId;
        $oArticle = oxNew('oxorderarticle');
        $oArticle->load($sOrderArtId);

        $oArticle->oxorderarticles__oxstorno->setValue(1);

        // stock information
        if ($myConfig->getConfigParam('blUseStock')) {
            $oArticle->updateArticleStock($oArticle->oxorderarticles__oxamount->value, $myConfig->getConfigParam('blAllowNegativeStock'));
        }

        $oDb = oxDb::getDb();
        $sQ = "update oxorderarticles set oxstorno = " . $oDb->quote($oArticle->oxorderarticles__oxstorno->value) . " where oxid = " . $oDb->quote($sOrderArtId);
        $oDb->execute($sQ);
    }

    /**
     * removes special character from string and returns the result
     *
     * @uses removeSpecialChar
     * @param string $str
     * @return string
     */
    private function removeSpecialChars($str)
    {
        $search = array("–", "´", "‹", "›", "‘", "’", "‚", "“", "”", "„", "‟", "•", "‒", "―", "—", "™", "¼", "½", "¾");
        $replace = array("-", "'", "<", ">", "'", "'", ",", '"', '"', '"', '"', "-", "-", "-", "-", "TM", "1/4", "1/2", "3/4");
        return str_replace($search, $replace, $str);
    }

    /**
     * Returns the server address
     *
     * @return string
     */
    private function getRatepaySystemID()
    {
        $systemId = $_SERVER['SERVER_ADDR'];
        return $systemId;
    }

    /**
     * Returns editable order object
     *
     * @return oxorder
     */
    public function getEditObject()
    {
        $orderId = $this->_getOrderId();
        if ($this->_oEditObject === null && isset($orderId) && $orderId != "-1") {
            $this->_oEditObject = oxNew("oxorder");
            $this->_oEditObject->load($orderId);
        }
        return $this->_oEditObject;
    }

    protected function _getOrderId()
    {
        if ($this->orderId === null) {
            $this->orderId = $this->getEditObjectId();
        }

        return $this->orderId;
    }

    /**
     * Call to order object to recalculateOrder
     *
     * @param oxorder $oOrder
     */
    private function _recalculateOrder($oOrder)
    {
        // keeps old delivery cost
        $oOrder->reloadDiscount(false);
        $oOrder->reloadDelivery(false);
        $oOrder->recalculateOrder();
    }

    /**
     * Return payment type used in order.
     * @return string
     */
    protected function _getPaymentSid()
    {
        if ($this->_paymentSid === null) {
            $order = $this->getEditObject();
            $this->_paymentSid = isset($order)? $order->getPaymentType()->oxuserpayments__oxpaymentsid->value : false;
        }
        return $this->_paymentSid;
    }

    /**
     * Get RatePAY xml service needed for the requests.
     * @return pi_ratepay_xmlService
     */
    protected function _getRatepayXmlService()
    {
        return pi_ratepay_xmlService::getInstance();
    }

    /**
     * Is shop set to UTF8 Mode
     * @return bool
     */
    private function _isUtfMode()
    {
        if ($this->_utfMode === null) {
            $this->_utfMode = $this->getConfig()->isUtf();
        }

        return $this->_utfMode;
    }

    /**
     * Get Settings according to RatePAY payment type
     * @return pi_ratepay_Settings
     */
    private function _getSettings()
    {
        $settings = oxNew('pi_ratepay_settings');
        $settings->loadByType(pi_ratepay_util_utilities::getPaymentMethod($this->_getPaymentSid()));

        return $settings;
    }

    /**
     * Convert number with thousands separator to calculable float numbers
     * @return float
     */
    private function _convertNumber($number)
    {
        return (float) str_replace(',', '', $number);
    }

}
