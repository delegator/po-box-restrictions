<?php

class Delegator_POBoxRestrictions_Model_Quote_Address extends Mage_Sales_Model_Quote_Address
{
    protected $_rates = null;

    public function setShippingRatesCollection($ratesCollection)
    {
        $this->_rates = $ratesCollection;

        return true;
    }
}
