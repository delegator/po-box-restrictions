<?php

class Delegator_POBoxRestrictions_Block_Checkout_Onepage_Shipping_Method_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
    public function getShippingRates()
    {
        $shippingAddress = $this->getQuote()->getShippingAddress();
        $restricted = Mage::helper('poboxrestrictions')->isAddressRestricted($shippingAddress);

        if (Mage::getStoreConfig('poboxrestrictions/general/enabled') && $restricted) {
            $groups = parent::getShippingRates();
            $allowedMethods = Mage::helper('poboxrestrictions')->getAllowedMethods();
            $valid = array();

            foreach ($groups as $code => $_rates) {
                foreach ($_rates as $_rate) {
                    if (in_array($_rate['carrier'], $allowedMethods)) {
                        $valid[$code] = $_rates;
                    }
                }
            }

            return $this->_rates = $valid;
        } else {
            return parent::getShippingRates();
        }
    }
}
