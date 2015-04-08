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
            $restrictedMethods = Mage::helper('poboxrestrictions')->getRestrictedMethods();
            foreach ($rates as $rate) {
                if (in_array($rate['method'], $restrictedMethods)) {
                    Mage::log("------");
                    Mage::log("method: " . $rate['method']);
                    Mage::log("ID: " . $rate->getId());
                    $rates->removeItemByKey($rate->getId());
                }
            }

            $shippingAddress->setShippingRatesCollection($rates);

            Mage::log('---');
            $rates = $shippingAddress->getShippingRatesCollection();
            foreach ($rates as $rate) { Mage::log($rate->getData()); }
            Mage::log('---');
        }

        return true;
    }
}
