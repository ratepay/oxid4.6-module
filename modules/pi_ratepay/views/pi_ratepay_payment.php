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
 * {@inheritdoc}
 *
 * Additionaly checks if RatePAY constraints are met. And initiales RatePAY
 * specific template variables.
 *
 * @package   PayIntelligent_RatePAY
 * @extends Payment
 */
class pi_ratepay_payment extends pi_ratepay_payment_parent
{

    /**
     * Stores if the user is the first time on the payment view.
     * @var boolean
     */
    private $_firstTime = true;

    /**
     * Stores which payment method was selected by the user
     * @var string
     */
    private $_selectedPaymentMethod;

    /**
     * Validation Errors
     * @var array
     */
    private $_errors = array();
    private $_bankdata = null;

    /**
     * {@inheritdoc}
     *
     * Additionaly checks if RatePAY constraints are met, removes RatePAY
     * payment methods if check fails.
     * Also executes init of RatePAY specific template variables.
     *
     * @see Payment::getPaymentList()
     * @return array
     */
    public function getPaymentList()
    {
        $paymentList = $this->_modifyPaymentList(parent::getPaymentList());
        $this->_initRatepayTemplateVariables();
        return $paymentList;
    }

    /**
     * Check if RatePAY payment methodes are set in the $paymentList.
     * Checks if RatePAY payment requirements are meet,
     * if not unsets the RatePAY payment type from $paymentList.
     *
     * @param $paymentList
     * @return array
     */
    private function _modifyPaymentList($paymentList)
    {
        $ratePayAllowed = $this->_checkRatePAY();

        foreach (pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD as $paymentMethod) {
            if (array_key_exists($paymentMethod, $paymentList)) {
                if (!$ratePayAllowed) {
                    unset($paymentList[$paymentMethod]);
                }
            }
        }

        return $paymentList;
    }

    /**
     * Initialises smarty variables specific to RatePAY payment.
     *
     */
    private function _initRatepayTemplateVariables()
    {
        $settings = oxNew('pi_ratepay_settings');

        foreach (pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD as $paymentMethod) {

            if ($this->_firstTime) {
                $settings->loadByType(
                    pi_ratepay_util_utilities::getPaymentMethod($paymentMethod)
                );

                $customer = $this->getUser();

                if (empty($customer->oxuser__oxfon->value)
                    && empty($customer->oxuser__oxprivfon->value)
                    && empty($customer->oxuser__oxmobfon->value)
                ) {
                    $this->addTplParam($paymentMethod . '_fon_check', 'true');
                }

                if ($customer->oxuser__oxbirthdate->value == "0000-00-00") {
                    $this->addTplParam($paymentMethod
                        . '_birthdate_check', 'true');
                }

                if (empty($customer->oxuser__oxcompany->value)
                    xor empty($customer->oxuser__oxustid->value)
                ) {
                    if (empty($customer->oxuser__oxcompany->value)) {
                        $this->addTplParam($paymentMethod
                            . '_company_check', 'true');
                    } else if (empty($customer->oxuser__oxustid->value)) {
                        $this->addTplParam($paymentMethod
                            . '_ust_check', 'true');
                    }
                }

                $paymentMinimumAmount = oxDb::getDb()->getOne(
                    "SELECT OXFROMAMOUNT FROM `oxpayments` WHERE `OXID` = '"
                    . $paymentMethod . "'");
                $paymentMaximumAmount = oxDb::getDb()->getOne(
                    "SELECT OXTOAMOUNT FROM `oxpayments` WHERE `OXID` = '"
                    . $paymentMethod . "'");

                $this->addTplParam($paymentMethod
                    . '_minimumAmount', $paymentMinimumAmount);
                $this->addTplParam($paymentMethod
                    . '_maximumAmount', $paymentMaximumAmount);
                $this->addTplParam($paymentMethod
                    . '_duedays',
                    $settings->pi_ratepay_settings__duedate->rawValue);

                //$whitelabel = ($settings->pi_ratepay_settings__whitelabel->rawValue) ? true : false;
                if($settings->pi_ratepay_settings__whitelabel->rawValue == '1') {
                    $this->addTplParam($paymentMethod
                    . '_whitelabel', true);
                }

                if ($paymentMethod === 'pi_ratepay_rate') {
                    $this->addTplParam(
                        'pi_ratepay_rate_activateelv',
                        $settings->pi_ratepay_settings__activate_elv->rawValue
                    );
                }
                $ratepayUrl = $settings->pi_ratepay_settings__ratepay_url->rawValue;
                $this->addTplParam($paymentMethod . '_ratepayurl', $ratepayUrl);
            }


            // @todo here for compatibility reasons will be removed in the future.
            if ($this->getSession()->hasVar($paymentMethod . '_error_id')) {
                if ($this->getSession()->hasVar($paymentMethod . '_errors')) {
                    $sessionErrors = $this->getSession()->getVar($paymentMethod . '_errors');
                } else {
                    $sessionErrors = array();
                }
                $sessionErrors[] = $this->getSession()->getVar($paymentMethod . '_error_id');
                $this->getSession()->setVar($paymentMethod . '_errors', $sessionErrors);
                $this->getSession()->deleteVar($paymentMethod . '_error_id');
            }

            if ($this->getSession()->hasVar($paymentMethod . '_errors')) {
                $this->_sPaymentError = '-600';
                $this->_sPaymentErrorText = 'A RatePAY Error occurred';

                $this->addTplParam('piRatepayErrors',
                    $this->getSession()->getVar($paymentMethod . '_errors'));

                $this->getSession()->deleteVar($paymentMethod . '_errors');

                $settings = $this->_getRatePaySettings($paymentMethod);
            }
        }

        if ($paymentMethod === 'pi_ratepay_elv'
            || $paymentMethod === 'pi_ratepay_rate'
        ) {
            $this->_setBankdata();
        }

        $this->_firstTime = false;
    }

    /**
     * Get RatePAY Settings Model for rate or rechnung.
     *
     * @param string $paymentMethod
     * @return pi_ratepay_Settings
     */
    private function _getRatePaySettings($paymentMethod)
    {
        $settings = oxNew('pi_ratepay_settings');
        switch ($paymentMethod) {
            case 'pi_ratepay_rechnung':
                $settings->loadByType('invoice');
                break;
            case 'pi_ratepay_rate':
                $settings->loadByType('installment');
                break;
            case 'pi_ratepay_elv':
                $settings->loadByType('elv');
                break;
        }

        return $settings;
    }

    /**
     * {@inheritdoc}
     *
     * In Additon:
     * Checks for user data which are required by RatePAY but not by oxid.
     * The data in question are contact details (phone and/or mobile number),
     * the birthdate of the user, and if it's a business or a person tax number.
     * Validates only if all data is set (tax only if it's a business).
     * @see Payment::validatePayment()
     * @return string
     */
    public function validatePayment()
    {
        if (!($paymentId = oxConfig::getParameter('paymentid'))) {
            $paymentId = oxSession::getVar('paymentid');
        }

        $this->_selectedPaymentMethod = $paymentId;

        $nextStep = parent::validatePayment();

        if ($nextStep == 'order' && in_array($paymentId, pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD)) {
            $isValid = array(
                $this->_checkFon(),
                $this->_checkBirthdate(),
                $this->_checkCompanyData(),
                $this->_checkBankData(),
                $this->_checkPrivacy(),
                $this->_ratepayInitRequest()
            );

            foreach ($isValid as $validationValue) {
                if (!$validationValue) {
                    $this->getSession()->setVar($paymentId . '_errors', array_unique($this->_errors));
                    oxUtils::getInstance()->redirect($this->getConfig()->getSslShopUrl() . 'index.php?cl=payment', false);
                }
            }

            if ($this->_selectedPaymentMethod === 'pi_ratepay_rate') {
                $nextStep = 'pi_ratepay_rate_calc';
            }
        }

        return $nextStep;
    }

    /**
     * Checks if user aggreed
     * @return bool
     */
    private function _checkPrivacy()
    {
        $privacyParameter = oxConfig::getParameter($this->_selectedPaymentMethod . '_privacy');
        $isPrivacyChecked = isset($privacyParameter) && $privacyParameter === '1';

        if (!$isPrivacyChecked) {
            $this->_errors[] = '-461';
        }

        return $isPrivacyChecked;
    }

    /**
     *
     * @return boolean
     */
    private function _checkCompanyData()
    {
        $isCompanyDataValid = false;
        $user = $this->getUser();

        $companySet = !empty($user->oxuser__oxcompany->value) && !empty($user->oxuser__oxustid->value);
        $companyNotSet = empty($user->oxuser__oxcompany->value) && empty($user->oxuser__oxustid->value);

        if ($companySet || $companyNotSet) {
            return true;
        }

        $ustId = oxConfig::getParameter($this->_selectedPaymentMethod . '_ust');
        if (!empty($ustId)) {
            $user->oxuser__oxustid->value = $ustId;
            $isCompanyDataValid = true;
        }

        $company = oxConfig::getParameter($this->_selectedPaymentMethod . '_company');
        if (!empty($company)) {
            $user->oxuser__oxcompany->value = $company;
            $isCompanyDataValid = true;
        }

        if (!$isCompanyDataValid) {
            $this->_errors[] = '-416';
        } else {
            $user->save();
            $this->setUser($user);
        }

        return $isCompanyDataValid;
    }

    /**
     *
     * @return boolean
     */
    private function _checkBirthdate()
    {
        $isBirthdateValid = false;
        $user = $this->getUser();
        $birthdate = $user->oxuser__oxbirthdate->value;

        if (!empty($birthdate) && $birthdate != '0000-00-00') {
            return true;
        }

        $day = oxConfig::getParameter($this->_selectedPaymentMethod . '_birthdate_day');
        $month = oxConfig::getParameter($this->_selectedPaymentMethod . '_birthdate_month');
        $year = oxConfig::getParameter($this->_selectedPaymentMethod . '_birthdate_year');

        if ($this->_checkBirthdateValues($day, $month, $year)) {
            $user->oxuser__oxbirthdate->value = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
            $user->save();
            $this->setUser($user);

            if ($this->_checkAge()) {
                $isBirthdateValid = true;
            } else {
                switch ($this->_selectedPaymentMethod) {
                    case 'pi_ratepay_rechnung':
                        $this->_errors[] = '-414';
                        break;
                    case 'pi_ratepay_rate':
                        $this->_errors[] = '-415';
                        break;
                    case 'pi_ratepay_elv':
                        $this->_errors[] = '-507';
                        break;
                    default:
                        break;
                }
            }
        }

        return $isBirthdateValid;
    }

    /**
     *
     * @param string $day
     * @param string $month
     * @param string $year
     * @return boolean
     */
    private function _checkBirthdateValues($day, $month, $year)
    {
        $areBirthdateValuesValid = false;

        if (is_numeric($day) && is_numeric($month) && is_numeric($year)) {
            if (preg_match('/[0-9]{4}/', (string) $year) > 0) {
                if (checkdate($month, $day, $year)) {
                    $areBirthdateValuesValid = true;
                } else {
                    switch ($this->_selectedPaymentMethod) {
                        case 'pi_ratepay_rechnung':
                            $this->_errors[] = '-401';
                            break;
                        case 'pi_ratepay_rate':
                            $this->_errors[] = '-408';
                            break;
                        case 'pi_ratepay_elv':
                            $this->_errors[] = '-505';
                            break;
                        default:
                            break;
                    }
                }
            } else {
                $this->_errors[] = '-419';
            }
        } else {
            switch ($this->_selectedPaymentMethod) {
                case 'pi_ratepay_rechnung':
                    $this->_errors[] = '-401';
                    break;
                case 'pi_ratepay_rate':
                    $this->_errors[] = '-408';
                    break;
                case 'pi_ratepay_elv':
                    $this->_errors[] = '-505';
                    break;
                default:
                    break;
            }
        }

        return $areBirthdateValuesValid;
    }

    /**
     *
     * @return boolean
     */
    private function _checkFon()
    {
        $isFonValid = false;
        $user = $this->getUser();
        $fon = $user->oxuser__oxfon->value;
        $mobil = $user->oxuser__oxmobfon->value;
        $phoneNumbers = array($fon, $user->oxuser__oxprivfon->value, $mobil);

        foreach ($phoneNumbers as $phoneNumber) {
            if (!empty($phoneNumber)) {
                return true;
            }
        }

        $phoneNumbers = array(
            'fon'   => oxConfig::getParameter($this->_selectedPaymentMethod . '_fon'),
            'mobil' => oxConfig::getParameter($this->_selectedPaymentMethod . '_mobilfon')
        );

        foreach ($phoneNumbers as $type => $phoneNumber) {
            if (!empty($phoneNumber)) {
                $isFonValid = true;
                if ($type == 'fon') {
                    $user->oxuser__oxfon = new oxField($phoneNumber);
                }
                if ($type == 'mobil') {
                    $user->oxuser__oxmobfon = new oxField($phoneNumber);
                }
            }
        }

        if ($isFonValid) {
            $user->save();
            $this->setUser($user);
        } else {
            switch ($this->_selectedPaymentMethod) {
                case 'pi_ratepay_rechnung':
                    $this->_errors[] = '-404';
                    break;
                case 'pi_ratepay_rate':
                    $this->_errors[] = '-460';
                    break;
                case 'pi_ratepay_elv':
                    $this->_errors[] = '-508';
                    break;
                default:
                    break;
            }
        }

        return $isFonValid;
    }

    private function _checkBankData()
    {
        if ($this->_selectedPaymentMethod != 'pi_ratepay_elv'
            && $this->_selectedPaymentMethod != 'pi_ratepay_rate'
        ) {
            return true;
        }

        if (!$this->_isRateElv()
            && $this->_selectedPaymentMethod != 'pi_ratepay_elv'
        ) {
            $this->getSession()->setVar(
                'pi_rp_rate_pay_method',
                'noelv'
            );
            return true;
        }

        if ($this->_isRateElv()) {
            $this->getSession()->setVar(
                'pi_rp_rate_pay_method',
                'pi_ratepay_rate_radio_elv'
            );
        }

        $isBankDataValid = true;

        $ownerKey = $this->_selectedPaymentMethod . '_bank_owner';
        $accountNumberKey =
            $this->_selectedPaymentMethod
            . '_bank_account_number';
        $codeKey = $this->_selectedPaymentMethod . '_bank_code';
        $nameKey = $this->_selectedPaymentMethod . '_bank_name';

        $bankData = array(
            $ownerKey         => oxConfig::getParameter($ownerKey),
            $accountNumberKey => oxConfig::getParameter($accountNumberKey),
            $codeKey          => oxConfig::getParameter($codeKey),
            $nameKey          => oxConfig::getParameter($nameKey)
        );

        $bankErrors = array(
            $ownerKey         => '-500',
            $accountNumberKey => '-501',
            $codeKey          => '-502',
            $nameKey          => '-503',
            'codekeyinvalid'  => '-509'
        );

        if (!empty($bankData[$codeKey]) && strlen(trim($bankData[$codeKey])) != 8) {
            $this->_errors[] = $bankErrors['codekeyinvalid'];
            $isBankDataValid = false;
        }

        foreach ($bankData as $bankDatumKey => $bankDatumValue) {
            if (empty($bankDatumValue)) {
                $isBankDataValid = false;
                $this->_errors[] = $bankErrors[$bankDatumKey];
            }
        }

        if ($isBankDataValid) {
            foreach ($bankData as $bankDatumKey => $bankDatumValue) {
                $this->getSession()->setVar($bankDatumKey, $bankDatumValue);
            }

            if ($this->_isSaveBankDataSet()) {
                $encryptionService = new Pi_Util_Encryption_OxEncryption();

                $insertArray = array(
                    'owner'         => $bankData[$ownerKey],
                    'accountnumber' => $bankData[$accountNumberKey],
                    'bankcode'      => $bankData[$codeKey],
                    'bankname'      => $bankData[$nameKey]
                );

                if (!isset($this->_bankdata)
                    || $this->_bankdata != $insertArray
                ) {
                    $userOxid = $this->getUser()->getId();
                    $encryptionService->saveBankdata(
                        $userOxid, $insertArray
                    );
                }
            }
        }

        return $isBankDataValid;
    }

    /**
     * Do init payment request redirect to order on succes, on failure redirect back to payment.
     */
    private function _ratepayInitRequest()
    {
        $isInitSuccessful = false;
        $paymentMethod = pi_ratepay_util_utilities::getPaymentMethod($this->_selectedPaymentMethod);

        $name = $this->getUser()->oxuser__oxfname->value;
        $surname = $this->getUser()->oxuser__oxlname->value;

        $ratepayRequest = $this->_getRatepayRequest();
        $initPayment = $ratepayRequest->initPayment();

        $transactionId = '';

        if ($initPayment['response']) {
            if ((string) $initPayment['response']->head->processing->status->attributes()->code == "OK" && (string) $initPayment['response']->head->processing->result->attributes()->code == "350") {
                $transactionId = (string) $initPayment['response']->head->{'transaction-id'};
                $this->getSession()->setVar($this->_selectedPaymentMethod . '_trans_id', (string) $initPayment['response']->head->{'transaction-id'});
                $this->getSession()->setVar($this->_selectedPaymentMethod . '_trans_short_id', (string) $initPayment['response']->head->{'transaction-short-id'});
                $isInitSuccessful = true;
            } else {
                $this->_errors[] = '-400';
            }
        } else {
            $this->_errors[] = '-418';
        }

        pi_ratepay_LogsService::getInstance()->logRatepayTransaction('', $transactionId, $paymentMethod, 'PAYMENT_INIT', '', $initPayment['request'], $name, $surname, $initPayment['response']);

        return $isInitSuccessful;
    }

    /**
     * Checks if RatePAY constraints are met.
     *
     * @return boolean
     */
    private function _checkRatePAY()
    {
        return $this->_checkCurrency() && $this->_checkCountry() && !$this->_checkDenied() && $this->_checkAge() && $this->_checkAddress();
    }

    /**
     * Checks if user is >= 18 years old.
     *
     * @return boolean
     */
    private function _checkAge()
    {
        $dob = $this->getUser()->oxuser__oxbirthdate->value;

        // check age if birthdate is set
        if ($dob != "0000-00-00") {
            $geb = strval($dob);
            $gebtag = explode("-", $geb);

            // explode day form time (14 00:00:00)
            $birthDay = explode(" ", $gebtag[2]);

            $stampBirth = mktime(0, 0, 0, $gebtag[1], $birthDay[0], $gebtag[0]);
            $result['stampBirth'] = $stampBirth;

            // fetch the current date (minus 18 years)
            $today['day'] = date('d');
            $today['month'] = date('m');
            $today['year'] = date('Y') - 18;

            // generates current day timestamp - 18 years
            $stampToday = mktime(0, 0, 0, $today['month'], $today['day'], $today['year']);
            $result['$stampToday'] = $stampToday;

            return $stampBirth <= $stampToday;
        }

        // still return true if birthdate is not set, this case is checked in validatePayment
        return true;
    }

    /**
     * Checks if 'pi_ratepay_denied' session variable is set to 'denied'. This variable gets set in order execute.
     * Which means if a order request is denied by RatePAY no other PAYMENT_INIT should be executed for the lifetime
     * of the session.
     *
     * @return boolean
     */
    private function _checkDenied()
    {
        $session = $this->getSession();
        return $session->hasVar('pi_ratepay_denied') && $session->getVar('pi_ratepay_denied') == 'denied';
    }

    /**
     * Checks if currency is set to euro. No other currencies are allowed.
     *
     * @return boolean
     */
    private function _checkCurrency()
    {
        return $this->getActCurrency()->name == "EUR";
    }

    /**
     * Checks if user is from Germany. No other countries are allowed.
     *
     * @return boolean
     */
    private function _checkCountry()
    {
        return oxDb::getDb()->getOne("SELECT OXISOALPHA2 FROM oxcountry WHERE OXID = '" . $this->getUser()->oxuser__oxcountryid->value . "'") == "DE";
    }

    /**
     * Checks if delivery address is the same as invoice address.
     *
     * @return boolean
     */
    private function _checkAddress()
    {
        $oUser = $this->getUser();
        $oDelAddress = $this->getDelAddress();

        if ($oDelAddress != "") {
            if ($oUser->oxuser__oxfname->value != $oDelAddress->oxaddress__oxfname->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxlname->value != $oDelAddress->oxaddress__oxlname->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxstreet->value != $oDelAddress->oxaddress__oxstreet->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxstreetnr->value != $oDelAddress->oxaddress__oxstreetnr->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxzip->value != $oDelAddress->oxaddress__oxzip->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxcity->value != $oDelAddress->oxaddress__oxcity->rawValue) {
                return false;
            }
            if ($oUser->oxuser__oxcountryid->value != $oDelAddress->oxaddress__oxcountryid->value) {
                return false;
            }
            if ($oUser->oxuser__oxsal->value != $oDelAddress->oxaddress__oxsal->rawValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns delivery address information from db if $this->_oDelAddress is null.
     *
     * @return oxaddress
     */
    public function getDelAddress()
    {
        if ($this->_oDelAddress === null) {
            $this->_oDelAddress = false;
            $oOrder = oxNew('oxorder');
            $this->_oDelAddress = $oOrder->getDelAddressInfo();
        }
        return $this->_oDelAddress;
    }

    private function _setBankdata()
    {
        $owner = '';
        $accountnumber = '';
        $bankcode = '';
        $bankname = '';

        $encryptService = new Pi_Util_Encryption_OxEncryption();
        if ($encryptService->isBankdataSetForUser($this->getUser()->getId())) {
            $this->_bankdata = $encryptService->loadBankdata($this->getUser()->getId());

            $owner = $this->_bankdata['owner'];
            $accountnumber = $this->_bankdata['accountnumber'];
            $bankcode = $this->_bankdata['bankcode'];
            $bankname = $this->_bankdata['bankname'];
        }

        $this->addTplParam('piDbBankowner', $owner);
        $this->addTplParam('piDbBankaccountnumber', $accountnumber);
        $this->addTplParam('piDbBankcode', $bankcode);
        $this->addTplParam('piDbBankname', $bankname);
    }

    private function _isSaveBankDataSet()
    {
        $elvSettings = $this->_getRatePaySettings($this->_selectedPaymentMethod);
        $saveBankData = $elvSettings->pi_ratepay_settings__savebankdata->rawValue;

        return $saveBankData != 0;
    }

    /**
     * Get RatePAY Request object.
     * @return  pi_ratepay_ratepayrequest
     */
    protected function _getRatepayRequest()
    {
        $requestDataProvider = oxNew('pi_ratepay_requestdatafrontend', $this->_selectedPaymentMethod);
        $ratepayRequest = oxNew('pi_ratepay_ratepayrequest', $this->_selectedPaymentMethod, $requestDataProvider);

        return $ratepayRequest;
    }

    private function _isRateElv()
    {
        $rateSettings = $this->_getRatePaySettings('pi_ratepay_rate');
        return $this->_selectedPaymentMethod === 'pi_ratepay_rate'
                && oxConfig::getParameter('pi_rp_rate_pay_method') === 'pi_ratepay_rate_radio_elv'
                && $rateSettings->pi_ratepay_settings__activate_elv->rawValue == 1;
    }

}
