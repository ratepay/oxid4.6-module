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
 * @license http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * Module information
 */
$aModule = array(
    'id'           => 'pi_ratepay',
    'title'        => 'RatePAY',
    'description'  => array(
        'de' => 'Bezahlung mit RatePAY.',
        'en' => 'Payment with RatePAY.'
    ),
    'thumbnail'    => 'picture.png',
    'lang'         => 'en',
    'version'      => '2.5.0.5',
    'author'       => 'PayIntelligent GmbH',
    'url'          => 'http://www.payintelligent.de/',
    'extend'       => array(
        'payment'           => 'pi_ratepay/views/pi_ratepay_payment',
        'order'             => 'pi_ratepay/views/pi_ratepay_order',
        'thankyou'          => 'pi_ratepay/views/pi_ratepay_thankyou',
    ),
    'blocks' => array(
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'checkout_payment_errors',
            'file'     => 'payment_pi_ratepay_error.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_rechnung.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_rate.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'select_payment',
            'file'     => 'payment_pi_ratepay_elv.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block'    => 'checkout_order_main',
            'file'     => 'order_pi_ratepay_waitingwheel.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block'    => 'shippingAndPayment',
            'file'     => 'order_pi_ratepay_rate.tpl'
        ),
        array(
            'template' => 'page/checkout/',
            'block'    => 'checkout_order_btn_confirm_bottom',
            'file'     => 'order_pi_ratepay_checkout_order.tpl'
        )
    ),
    'templates' => array(
        'pi_ratepay_rechnung_settings.tpl' => 'pi_ratepay/out/admin/tpl/pi_ratepay_rechnung_settings.tpl',
        'pi_ratepay_rate_settings.tpl'     => 'pi_ratepay/out/admin/tpl/pi_ratepay_rate_settings.tpl',
        'pi_ratepay_elv_settings.tpl'      => 'pi_ratepay/out/admin/tpl/pi_ratepay_elv_settings.tpl',
        'pi_ratepay_log.tpl'               => 'pi_ratepay/out/admin/tpl/pi_ratepay_log.tpl',
        'pi_ratepay_details.tpl'           => 'pi_ratepay/out/admin/tpl/pi_ratepay_details.tpl',
        'pi_ratepay_no_details.tpl'        => 'pi_ratepay/out/admin/tpl/pi_ratepay_no_details.tpl',
        'pi_ratepay_configuration.tpl'     => 'pi_ratepay/out/admin/tpl/pi_ratepay_configuration.tpl',
        'pi_ratepay_profile.tpl'           => 'pi_ratepay/out/admin/tpl/pi_ratepay_profile.tpl',
        'pi_ratepay_rate_calc.tpl'         => 'pi_ratepay/out/azure/tpl/pi_ratepay_rate_calc.tpl'
    ),
    'files' => array(
        'pi_ratepay_admin_SettingsAbstract'     => 'pi_ratepay/admin/pi_ratepay_admin_settingsabstract.php',
        'pi_ratepay_rechnung_Settings'          => 'pi_ratepay/admin/pi_ratepay_rechnung_settings.php',
        'pi_ratepay_rate_Settings'              => 'pi_ratepay/admin/pi_ratepay_rate_settings.php',
        'pi_ratepay_elv_Settings'               => 'pi_ratepay/admin/pi_ratepay_elv_settings.php',
        'pi_ratepay_Log'                        => 'pi_ratepay/admin/pi_ratepay_log.php',
        'pi_ratepay_Details'                    => 'pi_ratepay/admin/pi_ratepay_details.php',
        'pi_ratepay_Configuration'              => 'pi_ratepay/admin/pi_ratepay_configuration.php',
        'pi_ratepay_Profile'                    => 'pi_ratepay/admin/pi_ratepay_profile.php',
        'pi_ratepay_DetailsViewData'            => 'pi_ratepay/core/pi_ratepay_detailsviewdata.php',
        'pi_ratepay_History'                    => 'pi_ratepay/core/pi_ratepay_history.php',
        'pi_ratepay_HistoryList'                => 'pi_ratepay/core/pi_ratepay_historylist.php',
        'pi_ratepay_Logs'                       => 'pi_ratepay/core/pi_ratepay_logs.php',
        'pi_ratepay_LogsList'                   => 'pi_ratepay/core/pi_ratepay_logslist.php',
        'pi_ratepay_LogsService'                => 'pi_ratepay/core/pi_ratepay_logsservice.php',
        'pi_ratepay_OrderDetails'               => 'pi_ratepay/core/pi_ratepay_orderdetails.php',
        'pi_ratepay_Orders'                     => 'pi_ratepay/core/pi_ratepay_orders.php',
        'pi_ratepay_RateDetails'                => 'pi_ratepay/core/pi_ratepay_ratedetails.php',
        'pi_ratepay_RatepayRequest'             => 'pi_ratepay/core/pi_ratepay_ratepayrequest.php',
        'pi_ratepay_RequestAbstract'            => 'pi_ratepay/core/pi_ratepay_requestabstract.php',
        'pi_ratepay_RequestDataBackend'         => 'pi_ratepay/core/pi_ratepay_requestdatabackend.php',
        'pi_ratepay_RequestDataFrontend'        => 'pi_ratepay/core/pi_ratepay_requestdatafrontend.php',
        'pi_ratepay_RequestOrderArticle'        => 'pi_ratepay/core/pi_ratepay_requestorderarticle.php',
        'pi_ratepay_Settings'                   => 'pi_ratepay/core/pi_ratepay_settings.php',
        'pi_ratepay_util_Utilities'             => 'pi_ratepay/core/pi_ratepay_util_utilities.php',
        'pi_ratepay_XmlService'                 => 'pi_ratepay/core/pi_ratepay_xmlservice.php',
        'SimpleXMLExtended'                     => 'pi_ratepay/core/SimpleXMLExtended.php',
        'pi_ratepay_rate_Calc'                  => 'pi_ratepay/views/pi_ratepay_rate_calc.php',
        'Pi_Util_Encryption_EncryptionAbstract' => 'pi_ratepay/Pi/Util/Encryption/EncryptionAbstract.php',
        'Pi_Util_Encryption_OxEncryption'       => 'pi_ratepay/Pi/Util/Encryption/OxEncryption.php',
        'Pi_Util_Encryption_PrivateKey'         => 'pi_ratepay/Pi/Util/Encryption/PrivateKey.php'
    )
);
