<?php

class Delegator_POBoxRestrictions_Model_Observer
{
    public function checkRestrictions(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $shippingAddress = $quote->getShippingAddress();

        $restricted = Mage::helper('poboxrestrictions')->isAddressRestricted($shippingAddress);

        if ($restricted) {
            // Prune all shipping rates except for USPS.
            $rates = $shippingAddress->getShippingRatesCollection();
            foreach ($rates as $rate) {
                Mage::log($rate->getData());
            }

            Mage::log('remove the shipping methods not allowed');
        }

        return true;
    }
}
