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
abstract class pi_ratepay_admin_SettingsAbstract extends oxAdminView
{

    public function render()
    {
        $sReturn = parent::render();

        if (oxConfig::getParameter('stoken') != null) {
            $this->addTplParam('stoken', oxConfig::getParameter('stoken'));
        } else {
            $this->addTplParam('stoken', '');
        }

        $this->addTplParam('moduleVersion', pi_ratepay_util_utilities::PI_MODULE_VERSION);

        return $sReturn;
    }

    /**
     * Check if checkbox has been set to on for given parameter.
     *
     * @param string $parameter
     * @return int 0 for false and 1 for true
     */
    protected function _isParameterCheckedOn($parameter)
    {
        $checked = 0;

        if ($parameter != null && $parameter == 'on') {
            $checked = 1;
        }

        return $checked;
    }

}
