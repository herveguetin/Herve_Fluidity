<?php
/**
 * @category    Herve
 * @package     Herve_Fluidity
 * @copyright   Copyright (c) 2013 Hervé Guétin (http://www.herveguetin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Herve_Fluidity_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Retrieve installed Foundation version from module config
     *
     * @return string
     */
    public function getFoundationVersion()
    {
        return Mage::getStoreConfig('fluidity/foundation_version');
    }

    /**
     * Retrieve full URL path for foundation JS file
     *
     * @param string $path
     * @return string
     */
    public function getFoundationJs($path)
    {
        return Mage::getBaseUrl('js') . 'herve/fluidity/foundation-' . $this->getFoundationVersion() . DS . $path;
    }

    /**
     * Check if a block is fluid which may imply specific show/hide depending on screen size
     *
     * @param Mage_Core_Block_Abstract $block
     * @return bool
     */
    public function isFluid(Mage_Core_Block_Abstract $block)
    {
        $parentBlock = $block->getParentBlock();
        $parentBlockName = $parentBlock->getNameInLayout();

        if($parentBlockName == 'root') {
            return false;
        }
        if($parentBlock->getIsFluid() || $block->getIsFluid()) { // 'is_fluid' attribute is set via layout files: <action method="setIsFluid"><flag>true</flag></action>
            return true;
        }

        return $this->isFluid($parentBlock);
    }

    /**
     * Build an object with properties used for show / hide depending on screen size
     *
     * @param Mage_Core_Block_Abstract $block
     * @return Varien_Object
     */
    public function getFluidItem(Mage_Core_Block_Abstract $block)
    {
        $isFluid = $this->isFluid($block);
        $uniqId = uniqid();

        $data = array(
            'class'         => ($isFluid) ? 'show-for-small' : 'hide-for-small',
            'id_suffix'     => ($isFluid) ? '_small_' . $uniqId : '_large_' . $uniqId, // Used for form and any tag id that are replicated in several places
        );

        $fluidItem = new Varien_Object();
        $fluidItem->setData($data);

        return $fluidItem;
    }
}