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
 * RatePAY Rechnung Settings View
 *
 * View and edit RatePAY module settings for RatePAY Rechnung (invoice)
 *
 * Also:
 * {@inheritdoc}
 *
 * @package PayIntelligent_RatePAY
 * @extends oxAdminView
 */
class pi_ratepay_elv_Settings extends pi_ratepay_admin_SettingsAbstract
{

    /**
     * Render rechnung settings form. Adds settings from db to template.
     *
     * Also:
     * {@inheritdoc}
     *
     * @see oxAdminView::render()
     * @return string
     */
    function render()
    {
        parent::render();

        $settings = oxNew('pi_ratepay_Settings');
        $settings->loadByType('elv');

        $this->addTplParam('settings', $settings);

        return "pi_ratepay_elv_settings.tpl";
    }

    /*
     * Insert or update settings to db.
     */

    function saveRatepaySettings()
    {
        $sandbox = $this->_isParameterCheckedOn(oxConfig::getParameter('sandbox'));
        $logging = $this->_isParameterCheckedOn(oxConfig::getParameter('logging'));
        $whitelabel = $this->_isParameterCheckedOn(oxConfig::getParameter('whitelabel'));
        $saveBankData = $this->_isParameterCheckedOn(oxConfig::getParameter('savebankdata'));

        $settings = oxNew('pi_ratepay_Settings');
        $settings->load($this->getEditObjectId());

        $settings->assign(array(
            'profile_id'              => oxConfig::getParameter('profile_id'),
            'security_code'           => oxConfig::getParameter('security_code'),
            'sandbox'                 => $sandbox,
            'logging'                 => $logging,
            'whitelabel'              => $whitelabel,
            'savebankdata'            => $saveBankData,
            'duedate'                 => oxConfig::getParameter('duedate')            
        ));

        $settings->save();
    }

}
