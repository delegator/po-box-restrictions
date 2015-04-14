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
}
