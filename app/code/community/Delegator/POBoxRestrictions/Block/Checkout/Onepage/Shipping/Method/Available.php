<?php

class Delegator_POBoxRestrictions_Block_Checkout_Onepage_Shipping_Method_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
    public function getShippingRates()
    {
        $shippingAddress = $this->getQuote()->getShippingAddress();
        $groups = parent::getShippingRates();

        $validRates = Mage::helper('poboxrestrictions')->getValidRatesIfRestricted($shippingAddress, $groups);
        
        if ($validRates) {
            return $this->_rates = $validRates;
        }

        return $groups;
    }
}
