<?php

/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package pi_ratepay_rate_calculator
 * Code by PayIntelligent GmbH  <http://www.payintelligent.de/>
 */

/**
 * RatePAY Rate model class and references PiRateRatepayCalcData for shop
 * specific data.
 * @see PiRatepayRateCalcData
 */
class PiRatepayRateCalcBase
{

    /**
     * Merchant profile id
     * @var string
     */
    private $request_profile_id;

    /**
     * Merchant security code
     * @var string
     */
    private $request_security_code;

    /**
     * Order transaction id
     * @var string
     */
    private $request_transaction_id;

    /**
     * Order transaction short id
     * @var string
     */
    private $request_transaction_short_id;

    /**
     * Order id
     * @var string
     */
    private $request_order_id;

    /**
     * Merchant consumer id
     * @var string
     */
    private $request_merchant_consumer_id;

    /**
     * Merchant consumer classification
     * @var string
     */
    private $request_merchant_consumer_classification;

    /**
     * Request operation
     * @var string
     */
    private $request_operation;

    /**
     * Request operation subtype
     * @var string
     */
    private $request_operation_subtype;

    /**
     * Amount
     * @var string
     */
    private $request_amount;

    /**
     * Due date
     * @var string
     */
    private $request_due_date;

    /**
     * Calculation value
     * @var string
     */
    private $request_calculation_value;

    /**
     * Interest rate
     * @var string
     */
    private $request_interest_rate;

    /**
     * Payment first day
     * @var string
     */
    private $request_payment_firstday;

    /**
     * Define if requests should get to live or test system.
     * @var boolean
     */
    private $request_live;

    /**
     * Interestrate minimum
     * @var string
     */
    private $config_interestrate_min;

    /**
     * Interestrate default
     * @var string
     */
    private $config_interestrate_default;

    /**
     * Interestrate maximum
     * @var string
     */
    private $config_interestrate_max;

    /**
     * Minimum number of months
     * @var string
     */
    private $config_month_number_min;

    /**
     * Maximum number of months
     * @var string
     */
    private $config_month_number_max;

    /**
     * Months longrun
     * @var string
     */
    private $config_month_longrun;

    /**
     * Months allowed
     * @var string
     */
    private $config_month_allowed;

    /**
     * Config first day
     * @var string
     */
    private $config_payment_firstday;

    /**
     * Config payment amount
     * @var string
     */
    private $config_payment_amount;

    /**
     * Config payment last rate
     * @var string
     */
    private $config_payment_lastrate;

    /**
     * Config minimum
     * @var string
     */
    private $config_rate_min_normal;

    /**
     * Config minimum longrun
     * @var string
     */
    private $config_rate_min_longrun;

    /**
     * Service charge
     * @var string
     */
    private $config_service_charge;

    /**
     * Details total amount
     * @var string
     */
    private $details_total_amount;

    /**
     * Details amount
     * @var string
     */
    private $details_amount;

    /**
     * Details interest amount
     * @var string
     */
    private $details_interest_amount;

    /**
     * Details service charge
     * @var string
     */
    private $details_service_charge;

    /**
     * Details annual percentage rate
     * @var string
     */
    private $details_annual_percentage_rate;

    /**
     * Details monthly debit interest
     * @var string
     */
    private $details_monthly_debit_interest;

    /**
     * Details number of rates
     * @var string
     */
    private $details_number_of_rates;

    /**
     * Details rate
     * @var string
     */
    private $details_rate;

    /**
     * Details last rate
     * @var string
     */
    private $details_last_rate;

    /**
     * Details payment first day
     * @var string
     */
    private $details_payment_firstday;

    /**
     * Language
     * @var string
     */
    private $language;

    /**
     * Request error message
     * @var string
     */
    private $request_error_msg;

    /**
     * Request message
     * @var string
     */
    private $request_msg;

    /**
     * Request Code
     * @var string
     */
    private $request_code;

    /**
     * Calculation date, data from shops (shop specific)
     * @var PiRatepayRateCalcData
     */
    private $picalcdata;

    /**
     * Constructer of PiRatepayRateCalcBase, assigns PiRatepayRateCalcData
     * Object to $this->picalcdata. Sets shop specific data, clears rate
     * config and rate details with empty string.
     */
    public function __construct($picalcdata = null)
    {
        if (!isset($picalcdata)) {
            require_once 'PiRatepayRateCalcData.php';
            $picalcdata = new PiRatepayRateCalcData();
        }

        $this->picalcdata = $picalcdata;

        $this->request_profile_id = $this->picalcdata->getProfileId();

        $this->request_security_code = $this->picalcdata->getSecurityCode();

        $this->request_transaction_id = $this->picalcdata->getTransactionId();
        $this->request_transaction_short_id = $this->picalcdata->getTransactionShortId();
        $this->request_order_id = $this->picalcdata->getOrderId();
        $this->request_merchant_consumer_id = $this->picalcdata->getMerchantConsumerId();
        $this->request_merchant_consumer_classification = $this->picalcdata->getMerchantConsumerClassification();
        $this->request_amount = $this->picalcdata->getAmount();
        $this->request_live = $this->picalcdata->isLive();

        $this->language = $this->picalcdata->getLanguage();

        $this->request_operation = '';
        $this->request_operation_subtype = '';
        $this->request_calculation_value = '';
        $this->request_due_date = '';
        $this->request_payment_firstday = $this->picalcdata->getPaymentFirstdayConfig();
        $this->request_interest_rate = $this->picalcdata->getInterestRate();

        $this->config_interestrate_min = '';
        $this->config_intrestrate_default = '';
        $this->config_intrestrate_max = '';
        $this->config_month_number_min = '';
        $this->config_month_number_max = '';
        $this->config_month_longrun = '';
        $this->config_month_allowed = '';
        $this->config_payment_firstday = '';
        $this->config_payment_amount = '';
        $this->config_payment_lastrate = '';
        $this->config_rate_min_normal = '';
        $this->config_rate_min_longrun = '';
        $this->config_service_charge = '';

        $this->details_total_amount = '';
        $this->details_amount = '';
        $this->details_interest_rate = '';
        $this->details_interest_amount = '';
        $this->details_service_charge = '';
        $this->details_annual_percentage_rate = '';
        $this->details_monthly_debit_interest = '';
        $this->details_number_of_rates = '';
        $this->details_rate = '';
        $this->details_last_rate = '';
    }

    /**
     * Set the request operation
     *
     * @param string $operation
     */
    public function setRequestOperation($operation)
    {
        $this->request_operation = $operation;
    }

    /**
     * Set the request operation-subtype
     *
     * @param string $operation_subtype
     */
    public function setRequestOperationSubtype($operation_subtype)
    {
        $this->request_operation_subtype = $operation_subtype;
    }

    /**
     * Set the request calculation-value
     *
     * @param string $calculation_value
     */
    public function setRequestCalculationValue($calculation_value)
    {
        $this->request_calculation_value = $calculation_value;
    }

    /**
     * Set the request due day
     *
     * @param string $due_day
     */
    public function setRequestDueDay($due_day)
    {
        $this->request_due_date = $due_day;
    }

    /**
     * Set the request interest-rate
     *
     * @param string $interest_rate
     */
    public function setRequestInterestRate($interest_rate)
    {
        $this->request_interest_rate = $interest_rate;
    }

    /**
     * Set the config interest-rate-mim
     *
     * @param string $interest_rate_min
     */
    protected function setConfigInterestRateMin($interest_rate_min)
    {
        $this->config_interestrate_min = $interest_rate_min;
    }

    /**
     * Set the config interest-rate-default
     *
     * @param string $interest_rate_default
     */
    protected function setConfigInterestRateDefault($interest_rate_default)
    {
        $this->config_interestrate_default = $interest_rate_default;
    }

    /**
     * Set the config interest-rate-max
     *
     * @param string $interest_rate_max
     */
    protected function setConfigInterestRateMax($interest_rate_max)
    {
        $this->config_interestrate_max = $interest_rate_max;
    }

    /**
     * Set the config month-number-min
     *
     * @param string $month_number_min
     */
    protected function setConfigMonthNumberMin($month_number_min)
    {
        $this->config_month_number_min = $month_number_min;
    }

    /**
     * Set the config month-number-max
     *
     * @param string $month_number_max
     */
    protected function setConfigMonthNumberMax($month_number_max)
    {
        $this->config_month_number_max = $month_number_max;
    }

    /**
     * Set the config month-longrun
     *
     * @param string $month_longrun
     */
    protected function setConfigMonthLongrun($month_longrun)
    {
        $this->config_month_longrun = $month_longrun;
    }

    /**
     * Set the config month-allowed
     *
     * @param string $month_allowed
     */
    protected function setConfigMonthAllowed($month_allowed)
    {
        $this->config_month_allowed = $month_allowed;
    }

    /**
     * Set the config payment-firstday
     *
     * @param string $payment_firstday
     */
    protected function setConfigPaymentFirstday($payment_firstday)
    {
        $this->config_payment_firstday = $payment_firstday;
    }

    /**
     * Set the config payment-amount
     *
     * @param string $payment_amount
     */
    protected function setConfigPaymentAmount($payment_amount)
    {
        $this->config_payment_amount = $payment_amount;
    }

    /**
     * Set the config payment-lastrate
     *
     * @param string $payment_lastrate
     */
    protected function setConfigPaymentLastrate($payment_lastrate)
    {
        $this->config_payment_lastrate = $payment_lastrate;
    }

    /**
     * Set the config rate-min-normal
     *
     * @param string $rate_min_normal
     */
    protected function setConfigRateMinNormal($rate_min_normal)
    {
        $this->config_rate_min_normal = $rate_min_normal;
    }

    /**
     * Set the config rate-min-longrun
     *
     * @param string $rate_min_longrun
     */
    protected function setConfigRateMinLongrun($rate_min_longrun)
    {
        $this->config_rate_min_longrun = $rate_min_longrun;
    }

    /**
     * Set the config service-charge
     *
     * @param string $service_charge
     */
    protected function setConfigServiceCharge($service_charge)
    {
        $this->config_service_charge = $service_charge;
    }

    /**
     * Set the details total-amount
     *
     * @param string $total_amount
     */
    protected function setDetailsTotalAmount($total_amount)
    {
        $this->details_total_amount = $total_amount;
    }

    /**
     * Set the details amount
     *
     * @param string $amount
     */
    protected function setDetailsAmount($amount)
    {
        $this->details_amount = $amount;
    }

    /**
     * Set the details interest-amount
     *
     * @param string $interest_amount
     */
    protected function setDetailsInterestAmount($interest_amount)
    {
        $this->details_interest_amount = $interest_amount;
    }

    /**
     * Set the details service-charge
     *
     * @param string $service_charge
     */
    protected function setDetailsServiceCharge($service_charge)
    {
        $this->details_service_charge = $service_charge;
    }

    /**
     * Set the details annual-percentage-rate
     *
     * @param string $annual_percentage_rate
     */
    protected function setDetailsAnnualPercentageRate($annual_percentage_rate)
    {
        $this->details_annual_percentage_rate = $annual_percentage_rate;
    }

    /**
     * Set the details monthly-debit-interest
     *
     * @param string $monthly_debit_interest
     */
    protected function setDetailsMonthlyDebitInterest($monthly_debit_interest)
    {
        $this->details_monthly_debit_interest = $monthly_debit_interest;
    }

    /**
     * Set the details number-of-rates
     *
     * @param string $number_of_rates
     */
    protected function setDetailsNumberOfRates($number_of_rates)
    {
        $this->details_number_of_rates = $number_of_rates;
    }

    /**
     * Set the details rates
     *
     * @param string $rate
     */
    protected function setDetailsRate($rate)
    {
        $this->details_rate = $rate;
    }

    /**
     * Set the details last-rates
     *
     * @param string $last_rate
     */
    protected function setDetailsLastRate($last_rate)
    {
        $this->details_last_rate = $last_rate;
    }

    /**
     * Set the details payment-firstday
     *
     * @param string $payment_firstday
     */
    protected function setDetailsPaymentFirstday($payment_firstday)
    {
        $this->details_payment_firstday = $payment_firstday;
    }

    /**
     * Set the details interest-rates
     *
     * @param string $interest_rate
     */
    protected function setDetailsInterestRate($interest_rate)
    {
        $this->details_interest_rate = $interest_rate;
    }

    /**
     * Set a error message
     *
     * @param string $request_error_msg
     */
    public function setErrorMsg($request_error_msg)
    {
        $this->request_error_msg = $request_error_msg;
    }

    /**
     * Set a message
     *
     * @param string $request_msg
     */
    public function setMsg($request_msg)
    {
        $this->request_msg = $request_msg;
    }

    /**
     * Set a code
     *
     * @param string $request_code
     */
    public function setCode($request_code)
    {
        $this->request_code = $request_code;
    }

    /**
     * Get the system-id
     *
     * @return string $systemId
     */
    public function getRequestSystemID()
    {
        $systemId = $_SERVER['SERVER_ADDR'];
        return $systemId;
    }

    /**
     * Get the request profile-id
     *
     * @return string $this->request_profile_id
     */
    public function getRequestProfileId()
    {
        return $this->request_profile_id;
    }

    /**
     * Get the request security-code
     *
     * @return string $this->request_security_code
     */
    public function getRequestSecurityCode()
    {
        return $this->request_security_code;
    }

    /**
     * Get the request transaction-id
     *
     * @return string $this->request_transaction_id
     */
    public function getRequestTransactionId()
    {
        return $this->request_transaction_id;
    }

    /**
     * Get the request transaction-short-id
     *
     * @return string $this->request_transaction_short_id
     */
    public function getRequestTransactionShortId()
    {
        return $this->request_transaction_short_id;
    }

    /**
     * Get the config for payment firstday
     *
     * @return string $this->request_payment_firstday
     */
    public function getRequestFirstday()
    {
        return $this->request_payment_firstday;
    }

    /**
     * Get the request order-id
     *
     * @return string $this->request_order_id
     */
    public function getRequestOrderId()
    {
        return $this->request_order_id;
    }

    /**
     * Get the request merchant-consumer-id
     *
     * @return string $this->request_merchant_consumer_id
     */
    public function getRequestMerchantConsumerId()
    {
        return $this->request_merchant_consumer_id;
    }

    /**
     * Get the request merchant-consumer-classification
     *
     * @return string $this->request_merchant_consumer_classification
     */
    public function getRequestMerchantConsumerClassification()
    {
        return $this->request_merchant_consumer_classification;
    }

    /**
     * Get the request operation
     *
     * @return string $this->request_operation
     */
    public function getRequestOperation()
    {
        return $this->request_operation;
    }

    /**
     * Get the request operation-subtype
     *
     * @return string $this->request_operation_subtype
     */
    public function getRequestOperationSubtype()
    {
        return $this->request_operation_subtype;
    }

    /**
     * Get the request amount
     *
     * @return string $this->request_amount
     */
    public function getRequestAmount()
    {
        return $this->request_amount;
    }

    /**
     * Get the request calculation value
     *
     * @return string $this->request_calculation_value
     */
    public function getRequestCalculationValue()
    {
        return $this->request_calculation_value;
    }

    /**
     * Get the request calculation value
     *
     * @return string $this->request_calculation_value
     */
    public function getRequestDueDate()
    {
        return $this->request_due_date;
    }

    /**
     * Get the request interest rate
     *
     * @return string $this->request_interest_rate
     */
    public function getRequestInterestRate()
    {
        return $this->request_interest_rate;
    }

    /**
     * Get the status live or sandbox
     *
     * @return boolean $this->request_live
     */
    public function isLive()
    {
        return $this->request_live;
    }

    /**
     * Get the config interest-rate-min
     *
     * @return string $this->config_interestrate_min
     */
    public function getConfigInterestRateMin()
    {
        return $this->config_interestrate_min;
    }

    /**
     * Get the config interest-rate-default
     *
     * @return string $this->config_interestrate_default
     */
    public function getConfigInterestRateDefault()
    {
        return $this->config_interestrate_default;
    }

    /**
     * Get the config interest-rate-max
     *
     * @return string $this->config_interestrate_max
     */
    public function getConfigInterestRateMax()
    {
        return $this->config_interestrate_max;
    }

    /**
     * Get the config month-number-min
     *
     * @return string $this->config_month_number_min
     */
    public function getConfigMonthNumberMin()
    {
        return $this->config_month_number_min;
    }

    /**
     * Get the config interest-rate-max
     *
     * @return string $this->config_month_number_max
     */
    public function getConfigMonthNumberMax()
    {
        return $this->config_month_number_max;
    }

    /**
     * Get the config config-month-longrun
     *
     * @return string $this->config_month_longrun
     */
    public function getConfigMonthLongrun()
    {
        return $this->config_month_longrun;
    }

    /**
     * Get the config config-month-allowed
     *
     * @return string $this->config_month_allowed
     */
    public function getConfigMonthAllowed()
    {
        return $this->config_month_allowed;
    }

    /**
     * Get the config config-payment-firstday
     *
     * @return string $this->config_payment_firstday
     */
    public function getConfigPaymentFirstday()
    {
        return $this->config_payment_firstday;
    }

    /**
     * Get the config config-payment-amount
     *
     * @return string $this->config_payment_amount
     */
    public function getConfigPaymentAmount()
    {
        return $this->config_payment_amount;
    }

    /**
     * Get the config config-payment-lastrate
     *
     * @return string $this->config_payment_lastrate
     */
    public function getConfigPaymentLastrate()
    {
        return $this->config_payment_lastrate;
    }

    /**
     * Get the config rate-min-normal
     *
     * @return string $this->config_rate_min_normal
     */
    public function getConfigRateMinNormal()
    {
        return $this->config_rate_min_normal;
    }

    /**
     * Get the config rate-min-longrun
     *
     * @return string $this->config_rate_min_longrun
     */
    public function getConfigRateMinLongrun()
    {
        return $this->config_rate_min_longrun;
    }

    /**
     * Get the config service-charge
     *
     * @return string $this->config_service_charge
     */
    public function getConfigServiceCharge()
    {
        return $this->config_service_charge;
    }

    /**
     * Get the details total-amount
     *
     * @return string $this->details_total_amount
     */
    public function getDetailsTotalAmount()
    {
        return $this->details_total_amount;
    }

    /**
     * Get the details details-amount
     *
     * @return string $this->details_amount
     */
    public function getDetailsAmount()
    {
        return $this->details_amount;
    }

    /**
     * Get the details details interest-amount
     *
     * @return string $this->details_interest_amount
     */
    public function getDetailsInterestAmount()
    {
        return $this->details_interest_amount;
    }

    /**
     * Get the details details-service-charge
     *
     * @return string $this->details_service_charge
     */
    public function getDetailsServiceCharge()
    {
        return $this->details_service_charge;
    }

    /**
     * Get the details details annual-percentage-rate
     *
     * @return string $this->details_annual_percentage_rate
     */
    public function getDetailsAnnualPercentageRate()
    {
        return $this->details_annual_percentage_rate;
    }

    /**
     * Get the details details monthly-debit-interest
     *
     * @return string $this->details_monthly_debit_interest
     */
    public function getDetailsMonthlyDebitInterest()
    {
        return $this->details_monthly_debit_interest;
    }

    /**
     * Get the details details number-of-rate
     *
     * @return string $this->details_number_of_rates
     */
    public function getDetailsNumberOfRates()
    {
        return $this->details_number_of_rates;
    }

    /**
     * Get the details details rate
     *
     * @return string $this->details_rate
     */
    public function getDetailsRate()
    {
        return $this->details_rate;
    }

    /**
     * Get the details details last-rate
     *
     * @return string $this->details_last_rate
     */
    public function getDetailsLastRate()
    {
        return $this->details_last_rate;
    }

    /**
     * Get the details details interest-rate
     *
     * @return string $this->details_interest_rate
     */
    public function getDetailsInterestRate()
    {
        return $this->details_interest_rate;
    }

    /**
     * Gets the details payment-firstday
     *
     * @return string $this->details_payment_firstday
     */
    public function getDetailsPaymentFirstday()
    {
        return $this->details_payment_firstday;
    }

    /**
     * Get the selected languange
     *
     * @return string $this->language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the error message
     *
     * @return string $this->request_error_msg
     */
    public function getErrorMsg()
    {
        return $this->request_error_msg;
    }

    /**
     * Get the  message
     *
     * @return string $this->request_msg
     */
    public function getMsg()
    {
        return $this->request_msg;
    }

    /**
     * Get the code
     *
     * @return string $this->request_code
     */
    public function getCode()
    {
        return $this->request_code;
    }

    /**
     * Set all needed data
     *
     * @param string $total_amount
     * @param string $amount
     * @param string $interest_amount
     * @param string $service_charge
     * @param string $annual_percentage_rate
     * @param string $monthly_debit_interest
     * @param string $number_of_rates
     * @param string $rate
     * @param string $last_rate
     */
    public function setData(
    $total_amount, $amount, $interest_rate, $interest_amount, $service_charge, $annual_percentage_rate, $monthly_debit_interest, $number_of_rates, $rate, $last_rate, $payment_firstday
    )
    {
        $this->picalcdata->setData(
                $total_amount, $amount, $interest_rate, $interest_amount, $service_charge, $annual_percentage_rate, $monthly_debit_interest, $number_of_rates, $rate, $last_rate, $payment_firstday
        );
    }

    /**
     * Preparing data for rate details result.
     */
    public function prepareDetailsData()
    {
        $array = $this->picalcdata->getData();
        $this->setDetailsTotalAmount($array['total_amount']);
        $this->setDetailsAmount($array['amount']);
        $this->setDetailsInterestRate($array['interest_rate']);
        $this->setDetailsInterestAmount($array['interest_amount']);
        $this->setDetailsServiceCharge($array['service_charge']);
        $this->setDetailsAnnualPercentageRate($array['annual_percentage_rate']);
        $this->setDetailsMonthlyDebitInterest($array['monthly_debit_interest']);
        $this->setDetailsNumberOfRates($array['number_of_rates']);
        $this->setDetailsRate($array['rate']);
        $this->setDetailsLastRate($array['last_rate']);
    }

    /**
     * Unset all session data
     */
    public function unsetData()
    {
        $this->picalcdata->unsetData();
    }

    /**
     * Wrapper method for shop specific methods to get request parameters (GET).
     *
     * @see PiRatepayRateCalcData::getGetParameter()
     * @param string $var
     * @return string
     */
    public function getGetParameter($var)
    {
        return $this->picalcdata->getGetParameter($var);
    }

    /**
     * Wrapper method for shop specific methods to get request parameters
     * (POST).
     *
     * @see PiRatepayRateCalcData::getPostParameter()
     * @param string $var
     * @return string
     */
    public function getPostParameter($var)
    {
        return $this->picalcdata->getPostParameter($var);
    }

}
