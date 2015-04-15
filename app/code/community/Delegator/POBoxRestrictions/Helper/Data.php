<?php

class Delegator_POBoxRestrictions_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_POBoxRegex = '/p\.*o\.* *box/i';

    public function isAddressRestricted(Mage_Sales_Model_Quote_Address $address)
    {
        $streetAddress = $address->getStreetFull();

        if (preg_match($this->getPOBoxRegex(), $streetAddress)) {
            return true;
        }

        return false;
    }

    public function getAllowedMethods()
    {
        $allowedMethods = Mage::getStoreConfig('poboxrestrictions/allowed/methods');
        return preg_split('/,/', $allowedMethods);
    }

    public function getPOBoxRegex()
    {
        return $this->_POBoxRegex;
    }

    // If this is a restricted address, return valid rates.
    // Otherwise, return false.
    public function getValidRatesIfRestricted($address, $groups)
    {
        $restricted = $this->isAddressRestricted($address);

        if (Mage::getStoreConfig('poboxrestrictions/general/enabled') && $restricted) {
            $allowedMethods = $this->getAllowedMethods();
            $valid = array();

            foreach ($groups as $code => $_rates) {
                foreach ($_rates as $_rate) {
                    if (in_array($_rate['carrier'], $allowedMethods)) {
                        $valid[$code] = $_rates;
                    }
                }
            }
            return $valid;
        }

        return false;
    }
}
