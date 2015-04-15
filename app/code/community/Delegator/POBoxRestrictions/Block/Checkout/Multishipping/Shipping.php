<?php

class Delegator_POBoxRestrictions_Block_Checkout_Multishipping_Shipping extends Mage_Checkout_Block_Multishipping_Shipping
{
    public function getShippingRates($address)
    {
       $groups = parent::getShippingRates($address); 

       $validRates = Mage::helper('poboxrestrictions')->getValidRatesIfRestricted($address, $groups);

       if ($validRates) {
           return $validRates;
       }

       return $groups;
    }
}
