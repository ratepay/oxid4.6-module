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
 * Data Provider for frontend requests
 * @extends pi_ratepay_RequestAbstract
 */
class pi_ratepay_RequestDataFrontend extends pi_ratepay_RequestAbstract
{

    /**
     * Basket object
     * @var oxbasket
     */
    protected $_basket;

    /**
     * PaymentType: pi_ratepay_rechnung | pi_ratepay_rate
     * @var string
     */
    protected $_paymentType;

    public function __construct($paymentType, $basket = null)
    {
        $this->_basket = $basket;
        $this->_paymentType = $paymentType;
    }

    /**
     * Get basket amount.
     * @return dobule
     */
    public function getBasketAmount()
    {
        return $this->_basket->getPrice()->getBruttoPrice();
    }

    /**
     * Get article Data for consumption in requests.
     * @return article
     */
    public function getBasketArticles()
    {
        $basketArticles = array();

        foreach ($this->_basket->getContents() as $article) {
            $basketArticles[] = oxNew('pi_ratepay_RequestOrderArticle',
                    $article->getTitle(),
                    $article->getArticle()->oxarticles__oxartnum->value,
                    $article->getAmount(),
                    $article->getUnitPrice()->getNettoPrice(),
                    $article->getPrice()->getNettoPrice(),
                    $article->getPrice()->getVatValue()
            );
        }

        return $basketArticles;
    }

    /**
     * Get basket costs
     * @deprecated Stil here compatibility reasons, getBasketArticles should do the job in the future.
     * @return array
     */
    public function getBasketCosts()
    {
        return $this->_basket->getCosts();
    }

    /**
     * Get order number.
     * @return string
     */
    public function getOrderId()
    {
        $order = oxNew("oxorder");
        $order->load($this->_basket->getOrderId());

        return $order->oxorder__oxordernr->value;
    }

    /**
     * Get transaction id
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getSession()->getVar($this->_paymentType . '_trans_id');
    }

    /**
     * Get sum of discounts.
     * @return double
     */
    public function getBasketDiscounts()
    {
        $amount = 0;
        $discounts = $this->_basket->getDiscounts();
        if ($discounts) {
            foreach ($discounts as $discount) {
                $amount = $amount + $discount->dDiscount;
            }
        }
        return $amount;
    }

    /**
     * Get basket vouchers for consumption in requests.
     * @return array
     */
    public function getBasketVouchers()
    {
        $basketVouchers = array();

        foreach ($this->_basket->getVouchers() as $voucher) {
            $voucherSerieNrQuery = "select ovs.OXSERIENR from oxvoucherseries ovs, oxvouchers ov where ov.oxid = '$voucher->sVoucherId' and ovs.oxid = ov.OXVOUCHERSERIEID";
            $voucherSerieNr = oxDb::getDb()->getOne($voucherSerieNrQuery);

            $basketVouchers[] = oxNew('pi_ratepay_RequestOrderArticle',
                    $voucherSerieNr,
                    $voucher->sVoucherNr,
                    1,
                    $voucher->dVoucherdiscount,
                    $voucher->dVoucherdiscount,
                    0
            );
        }

        return $basketVouchers;
    }

    /**
     * Get installment total amount.
     * @return double
     */
    public function getInstallmentAmount()
    {
        return $this->getSession()->getVar('pi_ratepay_rate_total_amount');
    }

    /**
     * Get Payment total amount. If installment its the installment amount not the basket amount.
     * @return double
     */
    public function getPaymentAmount()
    {
        if ($this->_paymentType === 'pi_ratepay_rechnung'
            || $this->_paymentType === 'pi_ratepay_elv'
        ) {
            return $this->getBasketAmount();
        } else {
            return $this->getInstallmentAmount();
        }
    }

}
