<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))));
include APPLICATION_PATH . '/application/modules/Groupbuy/cli.php'; 
define('ALLOWED_REFERRER', '');
define('LOG_DOWNLOADS',true);
define('LOG_FILE','downloads.log');
$file = APPLICATION_PATH . '/application/settings/database.php';
$options = include $file;
$db =  $options['params'];

    $connection = mysql_connect($db['host'], $db['username'], $db['password']);
    $prefix = $options['tablePrefix'];
    if (!$connection)
        die("can't connect server");

    $db_selected = mysql_select_db($db['dbname']);
    if (!$db_selected)
        die ("have not database");
   mysql_query("SET character_set_client=utf8", $connection);
        mysql_query("SET character_set_connection=utf8",  $connection);       
   $action = $_REQUEST['action'];
   switch($action)
   {
       case 'callback':
            
            $req4 = @mysql_escape_string($_REQUEST['req4']);
            $req5 = @mysql_escape_string($_REQUEST['req5']);
            $status = @mysql_escape_string($_REQUEST['status']);
            $payer_status = @mysql_escape_string(($_REQUEST['payer_status']));
            $payment_status = @mysql_escape_string(($_REQUEST['payment_status']));
            $transaction_ID = @mysql_escape_string(($_REQUEST['txn_id']));
			$payment_gross = @mysql_escape_string(($_REQUEST['payment_gross']));
            $mc_gross = @mysql_escape_string(($_REQUEST['mc_gross']));
            $mc_currency = @mysql_escape_string(($_REQUEST['mc_currency']));
            $receiver_email = @mysql_escape_string(($_REQUEST['receiver_email']));
            //get bill
            $sql = "SELECT * FROM ".$prefix."groupbuy_bills WHERE "
                   ."sercurity ='".$req4 ."' AND invoice = '".$req5."'"
                   ." LIMIT 0,1"    
                   ;
            
            $result = mysql_query($sql) or die(mysql_error()."<b>SQL was: </b>$sql");
            if($result)
            {
                $bill = mysql_fetch_assoc($result);
                if($bill['bill_status'] == 0 
				&& ($status == 'COMPLETED' ||$payment_status =='Completed')
				//&& $payer_status =='verified'
				&& ($bill['amount'] == $payment_gross || $bill['amount'] == $mc_gross)
                && $bill['emal_receiver'] == $receiver_email
                && $bill['currency'] == $mc_currency)
                {
                	 //update status of bill
                    updateBillStatus($prefix,$bill,1);
                    $item = $bill['item_id'];
                    updateDisplay($item,$prefix);
                    $bill['bill_status'] = 1;
                     //saveTracking
                     $type = "";
                    saveTrackingPayIn($bill,$type,$prefix,$transaction_ID);
                     
                    /**
			         * Call Event from Affiliate
			         */
			        $module = 'ynaffiliate';
			        $modulesTable = Engine_Api::_()->getDbtable('modules', 'core');
						$mselect = $modulesTable->select()
						->where('enabled = ?', 1)
						->where('name  = ?', $module);
					$module_result = $modulesTable->fetchRow($mselect);
					if(count($module_result) > 0)	{
						$deal = Engine_Api::_()->getItem('deal', $item);
						$params['module'] = 'groupbuy';
						$params['user_id'] = $deal->user_id;
						$params['rule_name'] = 'publish_deal';
						$params['currency'] = $deal->currency;
						$params['total_amount'] = number_format($bill['amount'],2);
			        	Engine_Hooks_Dispatcher::getInstance()->callEvent('onPaymentAfter', $params);
					}
			        
			        /**
			         * End Call Event from Affiliate
			         */
                }
                
            }
            
       break;
       default:
            die('No action');
}

function getFinanceAccount($user_id = null,$payment_type = null,$prefix)
{
    $query = "1 AND 1";
    if($user_id)
    {
        $query .= " AND user_id = ".$user_id ;
    }
    if($payment_type)
    {
        $query .=" AND payment_type = ".$payment_type;    
    }
    
    $sql = "SELECT * FROM ".$prefix."groupbuy_payment_accounts WHERE "
                   .$query
                   ." LIMIT 0,1"    
                   ;

            $result = mysql_query($sql) or die(mysql_error()."<b>SQL was: </b>$sql");
            if($result)
            {
                $acc = mysql_fetch_assoc($result);
                return $acc;
            }
    return null;
}
function saveTrackingPayIn($bill,$type,$prefix,$transaction_ID)
{
    switch($type)
         {
             case 'bill':
             default: 
                $acc = getFinanceAccount($bill['user_id'],2,$prefix);  
				$accSell = getFinanceAccount($bill['owner_id'],1,$prefix); 
				$sql_insert = "INSERT INTO ".$prefix."groupbuy_transaction_trackings"
							."(transaction_date,user_seller,user_buyer,item_id,
							   amount,commission_fee,currency,account_seller_id,account_buyer_id,transaction_status,params) VALUES "
							."("
							."'".date('Y-m-d H:i:s')."'"
							.",'".$bill['owner_id']."'"
							.",'".$bill['user_id']."'"
							.",'".$bill['item_id']."'"
                            .",'".$bill['amount']."'"
                            .",'".$bill['commission_fee']."'"
							.",'".$bill['currency']."'"
							.",'".$accSell['paymentaccount_id']."'"
							.",'".$acc['paymentaccount_id']."'"
							.",'".$bill['bill_status']."'"
							.",'"."Pay fee publish Deal(#".$transaction_ID.")'"
							. ")";
				$result =  mysql_query($sql_insert); 
				if (!$result) {
					echo ('Invalid query: ' . mysql_error());
				}

                
                break;
         }
}
function updateBillStatus($prefix,$bill,$status)
{
    $sql_update = "UPDATE ".$prefix."groupbuy_bills SET"
                  ." `bill_status` = '1'"
                  ." WHERE `bill_id` = ".$bill['bill_id']
                  ;
    
   $result =  mysql_query($sql_update); 
   if (!$result) {
       echo ('Invalid query: ' . mysql_error());
   }
    
}
function updateDisplay($item,$prefix)
{ 
    $auto = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.approveAuto', 0);
    if($auto > 0)
    {
        Engine_Api::_()->groupbuy()->approveDeal($item);
    }
    else
    {
       $sql_update = "UPDATE ".$prefix."groupbuy_deals SET"
                      ." `published` = '10'"
                      .",`status` = '10'"
                      ." WHERE `deal_id` = ".$item
                      ;
	    $result =  mysql_query($sql_update); 
	    if (!$result) {
		    echo ('Invalid query: ' . mysql_error());
	    }
    }
}
?>
