<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pi_ratepay_util
 *
 * @author enes
 */
class pi_ratepay_util_Utilities
{

    /**
     * Static array of RatePAY payment methods.
     * @var array
     */
    public static $_RATEPAY_PAYMENT_METHOD = array('pi_ratepay_rechnung', 'pi_ratepay_rate', 'pi_ratepay_elv');

    const PI_MODULE_VERSION = '2.5.0.6';

    public static function getPaymentMethod($paymentType)
    {
        $paymentMethod = null;
        switch ($paymentType) {
            case 'pi_ratepay_rechnung':
                $paymentMethod = 'INVOICE';
                break;
            case 'pi_ratepay_rate':
                $paymentMethod = 'INSTALLMENT';
                break;
            case 'pi_ratepay_elv':
                $paymentMethod = 'ELV';
                break;
            default:
                break;
        }

        return $paymentMethod;
    }

}
