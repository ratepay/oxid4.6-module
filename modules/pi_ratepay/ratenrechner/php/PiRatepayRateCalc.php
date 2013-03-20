<?php

/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package pi_ratepay_rate_calculator
 * Code by PayIntelligent GmbH  <http://www.payintelligent.de/>
 */
require_once 'PiRatepayRateCalcBase.php';

/**
 * {@inheritdoc}
 *
 * Is also responsible for creating the RatePAY request and setting of the data.
 */
class PiRatepayRateCalc extends PiRatepayRateCalcBase
{

    /**
     * Service Class responsible for createing SimpleXML Objects
     * and sending requests to RatePAY.
     * @var pi_ratepay_xmlservice
     */
    private $ratepay;

    /**
     * Method name of RatePAY Installment
     * @var string
     */
    private $_paymentMethod = 'INSTALLMENT';

    /**
     * Optional parameters: RatePAY XML service and any implementation of
     * PiRatepayCalcDataInterface.
     * @param pi_ratepay_xmlService $xmlService
     * @param PiRatepayCalcDataInterface $piCalcData
     */
    public function __construct(
    pi_ratepay_xmlService $xmlService = null, PiRatepayCalcDataInterface $piCalcData = null
    )
    {
        if (isset($piCalcData)) {
            parent::__construct($piCalcData);
        } else {
            parent::__construct();
        }

        $this->ratepay = isset($xmlService) ?
                $xmlService : pi_ratepay_xmlService::getInstance();
    }

    /**
     * Get RatePAY config, if not successful also set error message.
     * @see requestRateConfig()
     * @see setErroMsg()
     * @return array $installmentConfigArray
     */
    public function getRatepayRateConfig()
    {
        try {
            $this->requestRateConfig();
        } catch (Exception $e) {
            $this->setErrorMsg($e->getMessage());
        }

        $installmentConfigArray = array(
            'month_allowed' => $this->getConfigMonthAllowed()
        );

        return $installmentConfigArray;
    }

    /**
     * Get RatePAY rate details and set data. If not successful also set
     * error message and unset data.
     * @see requestRateDetails()
     * @see setData()
     * @see setErrorMsg()
     * @return array $resultArray
     */
    public function getRatepayRateDetails($subtype)
    {
        try {
            $this->requestRateDetails($subtype);
            $this->setData(
                    $this->getDetailsTotalAmount(), $this->getDetailsAmount(), $this->getDetailsInterestRate(), $this->getDetailsInterestAmount(), $this->getDetailsServiceCharge(), $this->getDetailsAnnualPercentageRate(), $this->getDetailsMonthlyDebitInterest(), $this->getDetailsNumberOfRates(), $this->getDetailsRate(), $this->getDetailsLastRate(), $this->getDetailsPaymentFirstday()
            );
        } catch (Exception $e) {
            $this->unsetData();
            $this->setErrorMsg($e->getMessage());
        }
        return $this->createFormattedResult();
    }

    /**
     * Create an assoc array of formated RatePAY rate details.
     *
     * @return array $resultArray
     */
    public function createFormattedResult()
    {
        if ($this->getLanguage() == 'DE') {
            $currency = '&euro;';
            $decimalSeperator = ',';
            $thousandSepeartor = '.';
        } else {
            $currency = '&euro;';
            $decimalSeperator = '.';
            $thousandSepeartor = ',';
        }

        $resultArray = array();
        $resultArray['totalAmount'] = number_format((double) $this->getDetailsTotalAmount(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['amount'] = number_format((double) $this->getDetailsAmount(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['interestAmount'] = number_format((double) $this->getDetailsInterestAmount(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['serviceCharge'] = number_format((double) $this->getDetailsServiceCharge(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['annualPercentageRate'] = number_format((double) $this->getDetailsAnnualPercentageRate(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['monthlyDebitInterest'] = number_format((double) $this->getDetailsMonthlyDebitInterest(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['numberOfRatesFull'] = (int) $this->getDetailsNumberOfRates();
        $resultArray['numberOfRates'] = (int) $this->getDetailsNumberOfRates() - 1;
        $resultArray['rate'] = number_format((double) $this->getDetailsRate(), 2, $decimalSeperator, $thousandSepeartor);
        $resultArray['lastRate'] = number_format((double) $this->getDetailsLastRate(), 2, $decimalSeperator, $thousandSepeartor);

        return $resultArray;
    }

    /**
     * Creates, sends and validates the response of the config request. Sets
     * Data on success.
     * @throws Exception Throws exception on connection error or negative response.
     */
    private function requestRateConfig()
    {
        $this->setRequestOperation('CONFIGURATION_REQUEST');
        $this->setRequestOperationSubtype('');
        $request = $this->ratepay->getXMLObject();

        $this->setRatepayHead($request);

        $response = $this->ratepay->paymentOperation($request, $this->_paymentMethod);
        $request_reason_msg = 'serveroff';

        if ($response) {

            $response_result_code = (string) $response->head->processing->result->attributes()->code;
            $response_reason_code = (string) $response->head->processing->reason->attributes()->code;
            $response_status_code = (string) $response->head->processing->status->attributes()->code;

            if ($response_result_code == '500' && $response_reason_code == '306' && $response_status_code == 'OK') {

                $interest_rate_min = (string) $response->content->{'installment-configuration-result'}->{'interestrate-min'};
                $interest_rate_default = (string) $response->content->{'installment-configuration-result'}->{'interestrate-default'};
                $interest_rate_max = (string) $response->content->{'installment-configuration-result'}->{'interestrate-max'};
                $month_number_min = (string) $response->content->{'installment-configuration-result'}->{'month-number-min'};
                $month_number_max = (string) $response->content->{'installment-configuration-result'}->{'month-number-max'};
                $month_longrun = (string) $response->content->{'installment-configuration-result'}->{'month-longrun'};
                $month_allowed = (string) $response->content->{'installment-configuration-result'}->{'month-allowed'};
                $payment_firstday = (string) $response->content->{'installment-configuration-result'}->{'payment-firstday'};
                $payment_amount = (string) $response->content->{'installment-configuration-result'}->{'payment-amount'};
                $payment_lastrate = (string) $response->content->{'installment-configuration-result'}->{'payment-lastrate'};
                $rate_min_normal = (string) $response->content->{'installment-configuration-result'}->{'rate-min-normal'};
                $rate_min_longrun = (string) $response->content->{'installment-configuration-result'}->{'rate-min-longrun'};
                $service_charge = (string) $response->content->{'installment-configuration-result'}->{'service-charge'};

                $this->setConfigInterestRateMin($interest_rate_min);
                $this->setConfigInterestRateDefault($interest_rate_default);
                $this->setConfigInterestRateMax($interest_rate_max);
                $this->setConfigMonthNumberMin($month_number_min);
                $this->setConfigMonthNumberMax($month_number_max);
                $this->setConfigMonthLongrun($month_longrun);
                $this->setConfigMonthAllowed($month_allowed);
                $this->setConfigPaymentFirstday($payment_firstday);
                $this->setConfigPaymentAmount($payment_amount);
                $this->setConfigPaymentLastrate($payment_lastrate);
                $this->setConfigRateMinNormal($rate_min_normal);
                $this->setConfigRateMinLongrun($rate_min_longrun);
                $this->setConfigServiceCharge($service_charge);
            } else {
                $this->emptyConfigs();
                $request_reason_msg = (string) $response->head->processing->reason;
                throw new Exception($request_reason_msg);
            }
        } else {
            $this->emptyConfigs();
            throw new Exception($request_reason_msg);
        }
    }

    /**
     * Creates, sends and validates the response of the rate details request.
     * Sets Data on success.
     * @param string $subtype
     * @throws Exception Throws exception on connection error or negative response.
     */
    private function requestRateDetails($subtype)
    {
        $this->setRequestOperation('CALCULATION_REQUEST');
        $this->setRequestOperationSubtype($subtype);
        $request = $this->ratepay->getXMLObject();

        $this->setRatepayHead($request);
        $this->setRatepayContentCalculation($request);
        $response = $this->ratepay->paymentOperation($request, $this->_paymentMethod);
        $request_reason_msg = 'serveroff';

        if ($response) {

            $response_result_code = (string) $response->head->processing->result->attributes()->code;
            $response_reason_code = (string) $response->head->processing->reason->attributes()->code;
            $response_status_code = (string) $response->head->processing->status->attributes()->code;
            $success_codes = array('603', '671', '688', '689', '695', '696', '697', '698', '699');
            if ($response_result_code == '502' && in_array($response_reason_code, $success_codes) && $response_status_code == 'OK') {

                $total_amount = (string) $response->content->{'installment-calculation-result'}->{'total-amount'};
                $amount = (string) $response->content->{'installment-calculation-result'}->{'amount'};
                $interest_rate = (string) $response->content->{'installment-calculation-result'}->{'interest-rate'};
                $interest_amount = (string) $response->content->{'installment-calculation-result'}->{'interest-amount'};
                $service_charge = (string) $response->content->{'installment-calculation-result'}->{'service-charge'};
                $annual_percentage_rate = (string) $response->content->{'installment-calculation-result'}->{'annual-percentage-rate'};
                $monthly_debit_interest = (string) $response->content->{'installment-calculation-result'}->{'monthly-debit-interest'};
                $number_of_rates = (string) $response->content->{'installment-calculation-result'}->{'number-of-rates'};
                $rate = (string) $response->content->{'installment-calculation-result'}->{'rate'};
                $last_rate = (string) $response->content->{'installment-calculation-result'}->{'last-rate'};
                $payment_firstday = (string) $response->content->{'installment-calculation-result'}->{'payment-firstday'};

                $this->setDetailsTotalAmount($total_amount);
                $this->setDetailsAmount($amount);
                $this->setDetailsInterestRate($interest_rate);
                $this->setDetailsInterestAmount($interest_amount);
                $this->setDetailsServiceCharge($service_charge);
                $this->setDetailsAnnualPercentageRate($annual_percentage_rate);
                $this->setDetailsMonthlyDebitInterest($monthly_debit_interest);
                $this->setDetailsNumberOfRates($number_of_rates);
                $this->setDetailsRate($rate);
                $this->setDetailsLastRate($last_rate);
                $this->setDetailsPaymentFirstday($payment_firstday);

                $request_reason_msg = (string) $response->head->processing->reason;
                $this->setMsg($request_reason_msg);
                $this->setCode($response_reason_code);
                $this->setErrorMsg('');
            } else {
                $this->setMsg('');
                $request_reason_msg = (string) $response->head->processing->reason;
                $this->emptyDetails();
                throw new Exception($request_reason_msg);
            }
        } else {
            $this->setMsg('');
            $this->emptyDetails();
            throw new Exception($request_reason_msg);
        }
    }

    /**
     * Creates the head element of the request xml.
     */
    private function setRatepayHead($request)
    {
        $head = $request->addChild('head');

        $head->addChild('system-id', $this->getRequestSystemId());

        if ($this->getRequestTransactionId() != "")
            $head->addChild('transaction-id', $this->getRequestTransactionId());
        if ($this->getRequestTransactionShortId() != "")
            $head->addChild('transaction-short-id', $this->getRequestTransactionShortId());

        $operation = $head->addChild('operation', $this->getRequestOperation());

        if ($this->getRequestOperationSubtype() != "")
            $operation->addAttribute('subtype', $this->getRequestOperationSubtype());

        $this->setRatepayHeadCredentials($head);
        $this->setRatepayHeadExternal($head);
    }

    /**
     * Creates the credential element of the request xml.
     */
    private function setRatepayHeadCredentials($head)
    {
        $credential = $head->addChild('credential');

        $credential->addChild('profile-id', $this->getRequestProfileId());
        $credential->addChild('securitycode', $this->getRequestSecurityCode());
    }

    /**
     * Creates the external element of the request xml.
     */
    private function setRatepayHeadExternal($head)
    {
        if ($this->getRequestOrderId() != "" || $this->getRequestMerchantConsumerId() != "" || $this->getRequestMerchantConsumerClassification() != "") {
            $external = $head->addChild('external');

            if ($this->getRequestOrderId() != "")
                $external->addChild('order-id', $this->getRequestOrderId());
            if ($this->getRequestMerchantConsumerId() != "")
                $external->addChild('merchant-consumer-id', $this->getRequestMerchantConsumerId());
            if ($this->getRequestMerchantConsumerClassification() != "")
                $external->addChild('merchant-consumer-classification', $this->getRequestMerchantConsumerClassification());
        }
    }

    /**
     * Creates the installment-calculation element of the request xml.
     */
    private function setRatepayContentCalculation($request)
    {
        $content = $request->addChild('content');
        $installment = $content->addChild('installment-calculation');

        if ($this->getRequestInterestRate() != "") {
            $configuration = $installment->addChild('configuration');
            $configuration->addChild('interest-rate', $this->getRequestInterestRate());
        }

        $installment->addChild('amount', $this->getRequestAmount());
        if ($this->getRequestDueDate()) {
            $installment->addChild('payment-firstday', $this->getRequestDueDate());
        }

        if ($this->getRequestOperationSubtype() == 'calculation-by-rate') {
            $calc_rate = $installment->addChild('calculation-rate');
            $calc_rate->addChild('rate', $this->getRequestCalculationValue());
        } else if ($this->getRequestOperationSubtype() == 'calculation-by-time') {
            $calc_time = $installment->addChild('calculation-time');
            $calc_time->addChild('month', $this->getRequestCalculationValue());
        }
    }

    /**
     * Clear rate details with empty string
     */
    private function emptyDetails()
    {
        $this->setDetailsTotalAmount('');
        $this->setDetailsAmount('');
        $this->setDetailsInterestAmount('');
        $this->setDetailsServiceCharge('');
        $this->setDetailsAnnualPercentageRate('');
        $this->setDetailsMonthlyDebitInterest('');
        $this->setDetailsNumberOfRates('');
        $this->setDetailsRate('');
        $this->setDetailsLastRate('');
        $this->setDetailsPaymentFirstday('');
    }

    /**
     * Clear rate config with empty string
     */
    private function emptyConfigs()
    {
        $this->setConfigInterestRateMin('');
        $this->setConfigInterestRateDefault('');
        $this->setConfigInterestRateMax('');
        $this->setConfigMonthNumberMin('');
        $this->setConfigMonthNumberMax('');
        $this->setConfigMonthLongrun('');
        $this->setConfigMonthAllowed('');
        $this->setConfigPaymentFirstday('');
        $this->setConfigPaymentAmount('');
        $this->setConfigPaymentLastrate('');
        $this->setConfigRateMinNormal('');
        $this->setConfigRateMinLongrun('');
        $this->setConfigServiceCharge('');
    }

}
