<?php

class Honeypot_Form_Admin_Global extends Engine_Form {

    public function init() {
        $this->setTitle('Global Settings');

        $this->addElement('Text', 'honeypot_email', array(
            'label' => 'Honeypot Signup Field',
            'description' => 'This fields is used on signup form instead of email to trick bots.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('honeypot.email'),
        ));

        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    }

}