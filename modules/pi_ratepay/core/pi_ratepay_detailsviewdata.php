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
 * Helper Class to generate RatePAY order data.
 */
class pi_ratepay_DetailsViewData
{
    /**
     * oxid of order
     * @var string
     */
    private $_orderId;

    /**
     * Name of order details table
     * @var string
     */
    private $pi_ratepay_order_details = 'pi_ratepay_order_details';

    /**
     * Class constructor
     * @param string $orderId oxid of order
     */
    public function __construct($orderId)
    {
        $this->_orderId = $orderId;
    }

    /**
     * Gets all articles with additional informations
     *
     * @return array
     */
    public function getPreparedOrderArticles()
    {
        $orderId = $this->_orderId;

        $articleList = array();
        $sql = "SELECT oa.oxid,oa.oxartid,oa.oxartnum,oa.oxvat,oa.oxbprice,oa.oxnprice,oa.oxtitle, oa.oxbrutprice,oa.oxamount, prrod.ordered, prrod.cancelled, prrod.returned, prrod.shipped, if(oa.OXSELVARIANT != '',concat(oa.oxtitle,', ',oa.OXSELVARIANT),oa.oxtitle) as title
				FROM `oxorderarticles` oa, $this->pi_ratepay_order_details prrod
				WHERE prrod.order_number = '$orderId'
				AND prrod.order_number = oa.oxorderid
				AND oa.oxartid = prrod.article_number";
        $resultArticle = mysql_query($sql);
        $i = 0;

        while ($values = mysql_fetch_object($resultArticle)) {
            $articleList[$i]['oxid'] = $values->oxid;
            $articleList[$i]['artid'] = $values->oxartid;
            $articleList[$i]['arthash'] = md5($values->oxartid);
            $articleList[$i]['artnum'] = $values->oxartnum;
            $articleList[$i]['title'] = $values->title;
            $articleList[$i]['oxtitle'] = $values->oxtitle;
            $articleList[$i]['vat'] = $values->oxvat;
            $articleList[$i]['unitprice'] = number_format($values->oxbprice, 2);
            $articleList[$i]['unitPriceNetto'] = number_format($values->oxnprice, 2);
            $articleList[$i]['amount'] = $values->ordered - $values->shipped - $values->cancelled;
            $articleList[$i]['ordered'] = $values->ordered;
            $articleList[$i]['shipped'] = $values->shipped;
            $articleList[$i]['returned'] = $values->returned;
            $articleList[$i]['cancelled'] = $values->cancelled;

            if (($values->ordered - $values->returned - $values->cancelled) > 0) {
                $articleList[$i]['totalprice'] = number_format($values->oxbrutprice, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        $sql = "SELECT * from `oxorder` where oxid='$orderId'";

        $result = mysql_query($sql);
        $values = mysql_fetch_object($result);

        $sql2 = "SELECT * from `$this->pi_ratepay_order_details` where order_number='$orderId' and article_number='oxwrapping'";
        $result2 = mysql_query($sql2);

        if ($values2 = mysql_fetch_object($result2)) {
            $wrapprice = oxNew('oxprice');
            $wrapprice->setBruttopriceMode(true);
            $wrapprice->setVat($values->OXWRAPVAT);
            $wrapprice->setPrice($values->OXWRAPCOST);

            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = "oxwrapping";
            $articleList[$i]['arthash'] = md5("oxwrapping");
            $articleList[$i]['artnum'] = "oxwrapping";
            $articleList[$i]['title'] = "Wrapping Cost";
            $articleList[$i]['oxtitle'] = "Wrapping Cost";
            $articleList[$i]['vat'] = number_format($values->OXWRAPVAT, 0);
            $articleList[$i]['unitprice'] = number_format($values->OXWRAPCOST, 2);
            $articleList[$i]['unitPriceNetto'] = number_format($wrapprice->getNettoPrice(), 2);
            $articleList[$i]['amount'] = 1 - $values2->SHIPPED - $values2->CANCELLED;
            $articleList[$i]['ordered'] = $values2->ORDERED;
            $articleList[$i]['shipped'] = $values2->SHIPPED;
            $articleList[$i]['returned'] = $values2->RETURNED;
            $articleList[$i]['cancelled'] = $values2->CANCELLED;

            if (($values2->ORDERED - $values2->RETURNED - $values2->CANCELLED) > 0) {
                $articleList[$i]['totalprice'] = number_format($values->OXWRAPCOST, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        if ($values->OXPAYCOST != 0) {
            $sql2 = "SELECT * from `$this->pi_ratepay_order_details` where order_number='$orderId' and article_number='oxpayment'";
            $result2 = mysql_query($sql2);
            $values2 = mysql_fetch_object($result2);

            $payprice = oxNew('oxprice');
            $payprice->setBruttopriceMode(true);
            $payprice->setVat($values->OXPAYVAT);
            $payprice->setPrice($values->OXPAYCOST);

            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = "oxpayment";
            $articleList[$i]['arthash'] = md5($values->oxartid);
            $articleList[$i]['artnum'] = "oxpayment";
            $articleList[$i]['title'] = "Payment Cost";
            $articleList[$i]['oxtitle'] = "Payment Cost";
            $articleList[$i]['vat'] = number_format($values->OXPAYVAT, 0);
            $articleList[$i]['unitprice'] = number_format($values->OXPAYCOST, 2);
            $articleList[$i]['unitPriceNetto'] = number_format($payprice->getNettoPrice(), 2);
            $articleList[$i]['amount'] = 1 - $values2->SHIPPED - $values2->CANCELLED;
            $articleList[$i]['ordered'] = $values2->ORDERED;
            $articleList[$i]['shipped'] = $values2->SHIPPED;
            $articleList[$i]['returned'] = $values2->RETURNED;
            $articleList[$i]['cancelled'] = $values2->CANCELLED;

            if (($values2->ORDERED - $values2->RETURNED - $values2->CANCELLED) > 0) {
                $articleList[$i]['totalprice'] = number_format($values->OXPAYCOST, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        if ($values->OXDISCOUNT != 0) {
            $sql2 = "SELECT * from `$this->pi_ratepay_order_details` where order_number='$orderId' and article_number='Discount'";
            $result2 = mysql_query($sql2);
            $values2 = mysql_fetch_object($result2);

            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = "Discount";
            $articleList[$i]['arthash'] = md5($values->oxartid);
            $articleList[$i]['artnum'] = "Discount";
            $articleList[$i]['title'] = "Discount";
            $articleList[$i]['oxtitle'] = "Discount";
            $articleList[$i]['vat'] = "0";
            $articleList[$i]['unitprice'] = number_format($values->OXDISCOUNT, 2);
            $articleList[$i]['unitPriceNetto'] = number_format("-" . $values->OXDISCOUNT, 2);
            $articleList[$i]['amount'] = 1 - $values2->SHIPPED - $values2->CANCELLED;
            $articleList[$i]['ordered'] = $values2->ORDERED;
            $articleList[$i]['shipped'] = $values2->SHIPPED;
            $articleList[$i]['returned'] = $values2->RETURNED;
            $articleList[$i]['cancelled'] = $values2->CANCELLED;

            if (($values2->ORDERED - $values2->RETURNED - $values2->CANCELLED) > 0) {
                $articleList[$i]['totalprice'] = number_format("-" . $values->OXDISCOUNT, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        $sql2 = "SELECT * from `$this->pi_ratepay_order_details` where order_number='$orderId' and article_number='oxdelivery'";
        $result2 = mysql_query($sql2);

        if ($values2 = mysql_fetch_object($result2)) {

            $delprice = oxNew('oxprice');
            $delprice->setBruttopriceMode(true);
            $delprice->setVat($values->OXDELVAT);
            $delprice->setPrice($values->OXDELCOST);

            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = "oxdelivery";
            $articleList[$i]['arthash'] = md5('oxdelivery');
            $articleList[$i]['artnum'] = "oxdelivery";
            $articleList[$i]['title'] = "Delivery Cost";
            $articleList[$i]['oxtitle'] = "Delivery Cost";
            $articleList[$i]['vat'] = number_format($values->OXDELVAT, 0);
            $articleList[$i]['unitprice'] = number_format($values->OXDELCOST, 2);
            $articleList[$i]['unitPriceNetto'] = number_format($delprice->getNettoPrice(), 2);
            $articleList[$i]['amount'] = 1 - $values2->SHIPPED - $values2->CANCELLED;
            $articleList[$i]['ordered'] = $values2->ORDERED;
            $articleList[$i]['shipped'] = $values2->SHIPPED;
            $articleList[$i]['returned'] = $values2->RETURNED;
            $articleList[$i]['cancelled'] = $values2->CANCELLED;

            if (($values2->ORDERED - $values2->RETURNED - $values2->CANCELLED) > 0) {
                $articleList[$i]['totalprice'] = number_format($values->OXDELCOST, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        $sql2 = "SELECT * from `$this->pi_ratepay_order_details` where order_number='$orderId' and article_number='oxtsprotection'";
        $result2 = mysql_query($sql2);

        if ($values2 = mysql_fetch_object($result2)) {

            $tsprotectprice = oxNew('oxprice');
            $tsprotectprice->setBruttopriceMode(true);
            $tsprotectprice->setVat($values->OXTSPROTECTVAT);
            $tsprotectprice->setPrice($values->OXTSPROTECTCOST);

            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = "oxtsprotection";
            $articleList[$i]['arthash'] = md5('oxtsprotection');
            $articleList[$i]['artnum'] = "oxtsprotection";
            $articleList[$i]['title'] = "TS Protection Cost";
            $articleList[$i]['oxtitle'] = "TS Protection Cost";
            $articleList[$i]['vat'] = number_format($values->OXTSPROTECTVAT, 0);
            $articleList[$i]['unitprice'] = number_format($values->OXTSPROTECTCOST, 2);
            $articleList[$i]['unitPriceNetto'] = number_format($tsprotectprice->getNettoPrice(), 2);
            $articleList[$i]['amount'] = 1 - $values2->SHIPPED - $values2->CANCELLED;
            $articleList[$i]['ordered'] = $values2->ORDERED;
            $articleList[$i]['shipped'] = $values2->SHIPPED;
            $articleList[$i]['returned'] = $values2->RETURNED;
            $articleList[$i]['cancelled'] = $values2->CANCELLED;

            if (($values2->ORDERED - $values2->RETURNED - $values2->CANCELLED) > 0) {
                $articleList[$i]['totalprice'] = number_format($values->OXTSPROTECTCOST, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        $sql2 = "SELECT ov.oxdiscount AS price, prrod.article_number AS artnr, ov.oxvouchernr AS title, prrod.ordered, prrod.cancelled, prrod.returned, prrod.shipped, ovs.OXSERIENR as seriesTitle, ovs.OXSERIEDESCRIPTION as seriesDescription
		FROM `oxvouchers` ov, " . $this->pi_ratepay_order_details . " prrod, oxvoucherseries ovs
		WHERE prrod.order_number = '" . $orderId . "'
		AND ov.oxorderid = prrod.order_number
		AND prrod.article_number = ov.oxid
                AND ovs.oxid = ov.OXVOUCHERSERIEID";

        $result2 = mysql_query($sql2);

        while ($values2 = mysql_fetch_object($result2)) {
            $articleList[$i]['oxid'] = "";
            $articleList[$i]['artid'] = $values2->artnr;
            $articleList[$i]['arthash'] = md5($values2->artnr);
            $articleList[$i]['artnum'] = $values2->title;
            $articleList[$i]['title'] = $values2->seriesTitle;
            $articleList[$i]['oxtitle'] = $values2->seriesTitle;
            $articleList[$i]['vat'] = "0";
            $articleList[$i]['unitprice'] = "-" . number_format($values2->price, 2);
            $articleList[$i]['unitPriceNetto'] = "-" . number_format($values2->price, 2);
            $articleList[$i]['amount'] = 1 - $values2->shipped - $values2->cancelled;
            $articleList[$i]['ordered'] = $values2->ordered;
            $articleList[$i]['shipped'] = $values2->shipped;
            $articleList[$i]['returned'] = $values2->returned;
            $articleList[$i]['cancelled'] = $values2->cancelled;

            if (($values2->ordered - $values2->returned - $values2->cancelled) > 0) {
                $articleList[$i]['totalprice'] = "-" . number_format($values2->price, 2);
            } else {
                $articleList[$i]['totalprice'] = number_format(0, 2);
            }

            $i++;
        }

        return $articleList;
    }
}
