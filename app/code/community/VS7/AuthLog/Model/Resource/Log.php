<?php

class VS7_AuthLog_Model_Resource_Log extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('vs7_authlog/log', 'id');
    }
}