<?php
/**
 * @category    Herve
 * @package     Herve_Fluidity
 * @copyright   Copyright (c) 2013 Hervé Guétin (http://www.herveguetin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Herve_Fluidity_Block_Core_Messages extends Mage_Core_Block_Messages
{

    /**
     * Retrieve Foundation's Alert Box classes fitting to Magento message type
     *
     * @param $type
     * @return string
     */
    protected function _getFoundationAlertClass($type)
    {
        $alertClasses = array(
            Mage_Core_Model_Message::ERROR      => 'alert',
            Mage_Core_Model_Message::WARNING    => 'alert',
            Mage_Core_Model_Message::NOTICE     => 'secondary',
            Mage_Core_Model_Message::SUCCESS    => 'success',
        );

        return $alertClasses[$type];
    }

    /**
     * Retrieve messages in HTML format
     *
     * @param   string $type
     * @return  string
     */
    public function getHtml($type=null)
    {
        $html = '<div class="row"><div class="small-12 columns">';
        foreach ($this->getMessages($type) as $message) {
            $html.= '<div data-alert class="alert-box '.$this->_getFoundationAlertClass($message->getType()). ' ' .$message->getType().'-msg">'
                . $message->getText()
                . '<a href="#" class="close">&times;</a>'
                . '</div>';
        }
        $html .= '</div></div>';
        return $html;
    }

    /**
     * Retrieve messages in HTML format grouped by type
     *
     * @param   string $type
     * @return  string
     */
    public function getGroupedHtml()
    {
        return $this->getHtml();
    }
}
