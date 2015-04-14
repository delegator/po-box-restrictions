<?php

class Delegator_POBoxRestrictions_Model_Source_Methods
{
    public function toOptionArray()
    {
        $allMethods = Mage::getSingleton('shipping/config')->getAllCarriers();

        $methods = array();

        foreach ($allMethods as $code => $method) {
            $methods[] = array(
                'value' => $code,
                'label' => Mage::getStoreConfig('carriers/' . $code . '/title')
            );
        }

        return $methods;
    }
}
