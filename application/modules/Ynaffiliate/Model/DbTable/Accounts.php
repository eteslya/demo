<?php

class Ynaffiliate_Model_DbTable_Accounts extends Engine_Db_Table
{

	protected $_rowClass = "Ynaffiliate_Model_Account";
	
	public function getPaymentAccount($user_id) {
		$select = $this->select()->where('user_id = ?', $user_id);
		$result = $this->fetchRow($select);
		return $result;
	}

}