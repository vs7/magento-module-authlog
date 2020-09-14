<?php

class VS7_AuthLog_Model_Resource_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('vs7_authlog/log');
    }
}