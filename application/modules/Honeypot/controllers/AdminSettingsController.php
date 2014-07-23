<?php

class Honeypot_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $this->view->form = $form = new Honeypot_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();

            foreach ($values as $key => $value) {
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
        }
    }

}