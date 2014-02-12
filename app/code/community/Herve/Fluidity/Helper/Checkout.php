<?php
/**
 * @category    Herve
 * @package     Herve_Fluidity
 * @copyright   Copyright (c) 2013 Hervé Guétin (http://www.herveguetin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Herve_Fluidity_Helper_Checkout extends Mage_Checkout_Helper_Data
{
    /**
     * Updated Mage_Checkout_Helper_Data::formatPrice()
     * This allows to pass price box formatting arguments
     *
     * @param bool $includeContainer
     * @param int $price
     * @return string
     */
    public function formatPrice($price, $includeContainer = true)
    {
        return $this->getQuote()->getStore()->formatPrice($price, $includeContainer);
    }
}