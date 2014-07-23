<?php

class Honeypot_Installer extends Engine_Package_Installer_Module {

    public function onInstall() {

        $db = $this->getDb();
        $select = new Zend_Db_Select($db);

        $select->from('engine4_user_signup')
                ->where('class = ?', 'Honeypot_Plugin_Signup_Account');

        $info = $select->query()->fetch();
        if (empty($info)) {
            $select = new Zend_Db_Select($db);
            $select->from('engine4_user_signup')
                    ->where('class = ?', 'User_Plugin_Signup_Account')
                    ->limit(1);
            $account = $select->query()->fetchObject();

            if (!empty($account)) {
                $db->insert('engine4_user_signup', array(
                    'class' => 'Honeypot_Plugin_Signup_Account',
                    'order' => $account->order,
                    'enable' => 1,
                ));

                $db->update('engine4_user_signup', array('enable' => false), array(
                    'signup_id = ?' => $account->signup_id,
                ));
            }

            parent::onInstall();
        }
    }

    public function onEnable() {
        $db = $this->getDb();
        $db->update('engine4_user_signup', array('enable' => false), array(
            'class = ?' => 'User_Plugin_Signup_Account',
        ));

        $db->update('engine4_user_signup', array('enable' => true), array(
            'class = ?' => 'Honeypot_Plugin_Signup_Account',
        ));

        return parent::onEnable();
    }

    public function onDisable() {
        $db = $this->getDb();
        $db->update('engine4_user_signup', array('enable' => true), array(
            'class = ?' => 'User_Plugin_Signup_Account',
        ));

        $db->update('engine4_user_signup', array('enable' => false), array(
            'class = ?' => 'Honeypot_Plugin_Signup_Account',
        ));
        return parent::onDisable();
    }

}

?>