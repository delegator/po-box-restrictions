<?php

class Delegator_POBoxRestrictions_Helper_Data extends Mage_Core_Helper_Abstract
{

    private $_restrictedMethods = array('freeshipping');

    public function isAddressRestricted(Mage_Sales_Model_Quote_Address $address)
    {
        $streetAddress = $address->getStreetFull();

        if (preg_match('/p\.*o\.* *box/i', $streetAddress)) {
            return true;
        }

        return false;
    }

    public function getRestrictedMethods()
    {
        return $this->_restrictedMethods;
    }
}
