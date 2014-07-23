<?php

class Honeypot_Plugin_Signup_Account extends User_Plugin_Signup_Account {

    protected $_formClass = 'Honeypot_Form_Signup_Account';

    public function onSubmit(Zend_Controller_Request_Abstract $request) {
        $honeypot = Engine_Api::_()->getApi('settings', 'core')->getSetting('honeypot.email');
        $postData = $request->getPost();

        if ('' != $postData['email']) {
            //bot attack!
            die(Zend_Registry::get('Zend_Log')->log('Bot signup was prevented by Honeypot plugin (' . $postData['email'] . ')', Zend_Log::INFO));
        }

        // Form was valid
        if ($this->getForm()->isValid($postData)) {
            $values = $this->getForm()->getValues();
            $values['email'] = $values[$honeypot];
            unset($values[$honeypot]);

            $this->getSession()->data = $values;
            $this->setActive(false);
            $this->onSubmitIsValid();
            return true;
        }

        // Form was not valid
        else {
            $this->getSession()->active = true;
            $this->onSubmitNotIsValid();
            return false;
        }
    }

}