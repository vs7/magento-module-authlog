<?php

class VS7_AuthLog_Model_Observer
{
    public function authLog($observer)
    {
        $event = $observer->getEvent();
        $eventName = $event->getName();
        $log = Mage::getModel('vs7_authlog/log');
        $passwordHash = Mage::helper('core')->getEncryptor()->getHash($event->getPassword());
        if ($eventName == 'admin_user_authenticate_after') {
            $userName = $event->getUsername();
            $result = $event->getResult() ? 'true' : 'false';
        } elseif ($eventName == 'admin_session_user_login_failed') {// user exists but disabled
            $userName = $event->getUserName();
            $result = $event->getException()->getMessage();
            $post = Mage::app()->getRequest()->getPost();
            if (!empty($post) && isset($post['login']) && isset($post['login']['password'])) {
                $passwordHash = Mage::helper('core')->getEncryptor()->getHash($post['login']['password']);
            }
        }
        $log->setUsername($userName);
        $log->setPassword($passwordHash);
        $log->setDate(now());
        $ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : null;
        if (empty($ip)) {
            $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
        }
        $log->setIp($ip);
        $log->setResult($result);

        $log->save();
    }
}