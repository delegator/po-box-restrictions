<?php

class Delegator_POBoxRestrictions_Model_Observer
{
    public function checkRestrictions(Varien_Event_Observer $observer)
    {
        $enabled = Mage::getStoreConfig('poboxrestrictions/general/enabled');
        if (!$enabled) {
            return true;
        }

        $quote = $observer->getEvent()->getQuote();
        $shippingAddress = $quote->getShippingAddress();

        $restricted = Mage::helper('poboxrestrictions')->isAddressRestricted($shippingAddress);

        if ($restricted) {
            // Prune all shipping rates except for USPS.
            $rates = $shippingAddress->getShippingRatesCollection();
            $allowedMethods = Mage::helper('poboxrestrictions')->getAllowedMethods();
            foreach ($rates as $key => $rate) {
                if (!in_array($rate['carrier'], $allowedMethods)) {
                    $rates->removeItemByKey($key);
                }
            }

            $shippingAddress->setShippingRatesCollection($rates);
        }

        return true;
    }
}
