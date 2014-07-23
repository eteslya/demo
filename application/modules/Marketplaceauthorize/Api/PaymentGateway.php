<?php

/**
 * Payment Gateway
 *
 * This library provides generic payment gateway handling functionlity
 * to the other payment gateway classes in an uniform way. Please have
 * a look on them for the implementation details.
 *
 * @package     Payment Gateway
 * @category    Library
 * @author      Md Emran Hasan <phpfour@gmail.com>
 * @link        http://www.phpfour.com
 */

abstract class Marketplaceauthorize_Api_PaymentGateway extends Core_Api_Abstract
{
    /**
     * Holds the last error encountered
     *
     * @var string
     */
    public $lastError;

    /**
     * Do we need to log IPN results ?
     *
     * @var boolean
     */
    public $logIpn;

    /**
     * File to log IPN results
     *
     * @var string
     */
    public $ipnLogFile;

    /**
     * Payment gateway IPN response
     *
     * @var string
     */
    public $ipnResponse;

    /**
     * Are we in test mode ?
     *
     * @var boolean
     */
    public $testMode;

    /**
     * Field array to submit to gateway
     *
     * @var array
     */
    public $fields = array();

    /**
     * IPN post values as array
     *
     * @var array
     */
    public $ipnData = array();

    /**
     * Payment gateway URL
     *
     * @var string
     */
    public $gatewayUrl;

    /**
     * Initialization constructor
     *
     * @param none
     * @return void
     */
    public function __construct()
    {
        // Some default values of the class
        $this->lastError = '';
        $this->logIpn = TRUE;
        $this->ipnResponse = '';
        $this->testMode = FALSE;
    }

    /**
     * Adds a key=>value pair to the fields array
     *
     * @param string key of field
     * @param string value of field
     * @return
     */
    public function addField($field, $value)
    {
        $this->fields["$field"] = $value;
    }

    /**
     * Submit Payment Request
     *
     * Generates a form with hidden elements from the fields array
     * and submits it to the payment gateway URL. The user is presented
     * a redirecting message along with a button to click.
     *
     * @param none
     * @return void
     */
    public function submitPayment()
    {

        $this->prepareSubmit();

        echo "<html>\n";
        echo "<head><title>Processing Payment...</title></head>\n";
        echo "<body onLoad=\"document.forms['gateway_form'].submit();\">\n";
        echo "<p style=\"text-align:center;\"><h2>Please wait, your order is being processed and you";
        echo " will be redirected to the payment website.</h2></p>\n";
        echo "<form method=\"POST\" name=\"gateway_form\" ";
        echo "action=\"" . $this->gatewayUrl . "\">\n";

        foreach ($this->fields as $name => $value)
        {
             echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
        }


        echo "<p style=\"text-align:center;\"><br/><br/>If you are not automatically redirected to ";
        echo "payment website within 5 seconds...<br/><br/>\n";
        echo "<input type=\"submit\" value=\"Click Here\"></p>\n";

        echo "</form>\n";
        echo "</body></html>\n";
    }

    /**
     * Submit Payment Render
     *
     * @param none
     * @return void
     */
    public function render()
    {

        $this->prepareSubmit();

        $form = "<form method=\"POST\" name=\"gateway_form\" id=\"gateway_form\" ";
        $form .= "action=\"" . $this->gatewayUrl . "\">\n<!-- P Gateway -->";
        foreach ($this->fields as $name => $value)
        {
             $form .= "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
        }
		
		//et
		$test = Engine_Api::_()->user()->getViewer()->getIdentity();
		if ($test > 0 ) {
			//$form .= "<div type=\"submit\" id=\"done\" name=\"done\" style=\"width:220px; color:#fff\" onclick=\"fpayButtonDisabled(this);\" class=\"payButtom\" >Pay with credit card</div>\n";

			
			$form .= '<script type="text/javascript" src="/bv/custom/auth/ipayout.js"></script>';//et
			
			
			//
			$user_id = $test;
			$email = Engine_Api::_()->user()->getViewer()->email;
			$name = Engine_Api::_()->user()->getViewer()->getTitle(); 
			
			
			/*
			$s = "<h2>Create eWallet Account</h2><button id=\'submit\' type=\'submit\' name=\'submit\'>Create Account</button>";
				
				$user_id = Engine_Api::_()->core()->getSubject('user')->getIdentity();
				$email = Engine_Api::_()->core()->getSubject('user')->email; //Engine_Api::_()->core()->getSubject('Email Address')->getIdentity();
				
		
				$viewer = Engine_Api::_()->user()->getViewer();
				$name =  $viewer->getTitle(); 
				$s = "<iframe id=\'body\' name=\'body\' src=\'/bv/custom/auth/ipayout.php?u=".$user_id."&e=".$email."&n=".$name."\' frameborder=\'0\' scrolling=\'no\' align=\'top\' height=\'708\' width=\'798\'></iframe>";
				
				*/
				
				//$str = '<span style="line-height: 45px; color: rgb(0, 136, 204); padding: 0px 15px;" onclick="document.forms[0].innerHTML =\' '.$s.' \';" >Create eWallet Acct</span>';
				
			
		//check pending status
		
		
		$db = Engine_Db_Table::getDefaultAdapter();		  
		$user_id = (int)Engine_Api::_()->user()->getViewer()->getIdentity();

			$sql = "
		SELECT count(*) cnt
		FROM business b
        where user_id = {$user_id} and page_id = 16 and status is null";
		
		
		 $res = $db->query($sql);
		$rows = $res->fetchAll();
		if ($rows[0]['cnt'] > 0)
		{
			$pending = 1;
		}
		else
		{
			$pending = 0;
		}
		
		if ($pending == 1)
		  {	
			$pending_class = "payButtonDisabled";
			$pending_btn = "Pending I-Payout invoice";
		  }
		  else
		  {	
			$pending_class = "payButtom";
			$pending_btn = "Pay with I-PayOut";
		  }
		
		
			$form .= '
			<input type="hidden" name="name" value="MarketPlace transaction">
<input type="hidden" name="length" value="1">
<input type="hidden" name="unit" value="months">
<input type="hidden" name="totalOccurrences" value="1"> 
<input type="hidden" name="test" value="'.$pending.'"> 
<input type="hidden" name="amount" value="0">
<input type="hidden" name="trialAmount" value="0">
<input type="hidden" name="h_page_id" value="0">
<input type="hidden" name="h_uid" value="'.$user_id.'">
<input type="hidden" name="h_trans_id" value=""> 
<input type="hidden" name="h_card" value=""> 
<input type="hidden" name="h_exp" value=""> 
<input type="hidden" name="h_lname" value=""> 
<input type="hidden" name="h_fname" value=""> 
<input type="hidden" name="h_email" value="'.Engine_Api::_()->user()->getViewer()->email.'"> 
<input type="hidden" name="item_desc" value="MarketPlace transaction"> 
<input type="hidden" name="ref_id" value="marketplaceTrans"> 
<!--div id="disp" style="color:#b41e17"><div type="button" id="done2" name="done2" onclick="fPayOut(this);" class="payButtom" style="width:220px; color:#fff">Pay with I-PayOut</div></div-->

<div id="disp" >
  <center> 
  <table>
  <tr><td  width="220px"><div type="submit" id="done" name="done" onclick="fpayButtonDisabled(this);" style="width:180px; color:#fff" class="payButtom" >Pay with credit card</div></td></tr>
  <tr><td  style="height:30px"><div class="comments_options" style="border-top: 1px solid #76767d; margin 20px"></div></td></tr>
  <tr><td><span>No Credit Card? No problem! </span></td></tr>
  <tr><td><br/><div type="button" id="done2" name="done2" onclick="fPayOut(this);" class="'.$pending_class.'" style="width:180px; color:#fff">'.$pending_btn.'</div></td></tr>
  <tr><td> <br/><span ><a href="https://www.i-payout.com" target="_new">Learn more about I-PayOut</a></span></td></tr>
</table>
  </center>
  
</div> 
<input type="hidden" name="h_frame" value="<iframe id=\'body\' name=\'body\' src=\'/bv/custom/auth/ipayout.php?u='.$user_id.'&e='.$email.'&n='.$name.'\' frameborder=\'0\' scrolling=\'no\' align=\'top\' height=\'708\' width=\'798\'></iframe>";
				
<br/><br/><br/>

<!-- (c) 2005, 2013. Authorize.Net is a registered trademark of CyberSource Corporation --> 
<div class="AuthorizeNetSeal"id="AuthorizeNetSeal" > <script type="text/javascript" language="javascript">var ANS_customer_id="cc165d67-4f34-42cf-8d67-b4788a2cde28";</script> 
<script type="text/javascript" language="javascript" src="https://verify.authorize.net/anetseal/seal.js" ></script> 
<a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Internet Payments</a> </div>
<br/><br/>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=5ucsYW4SuvPHjkb4zD8nb3Q7dNcHhm1zMrBcsComT8Dgt0myWpsnUtAX9xz"></script></span><br/><br/>
<script type="text/javascript" src="https://www.rapidscansecure.com/siteseal/siteseal.js?code=65,28249BDDAA76A676342C0D72DC02F4F8BE5FDA36"></script>

';
		}
		else
		{
		
			echo '<input type="hidden" name="return_url"  value="'.Zend_Controller_Front::getInstance()->getRouter()->assemble(array()).'" />';
			echo '<script>function fSignup(){ var a = document.getElementById(\'core_menu_mini_menu\').innerHTML.split(\'"\'); if(a[1] == "menu_core_mini core_mini_auth"){ return a[3]; }else{return a[1]; }}</script>'; ////return a[3]; 
			//2 echo '<script>function fSignup(){ var a = document.getElementById(\'core_menu_mini_menu\').innerHTML.split(\'"\'); document.forms[0].action = "/bv/login"; document.forms[0].submit();}</script>';


			//$form .= '<a href="/bv/login" style="color:#fff"><button type="button" name="done" style="color:#fff">Signin to purchase</button></a>';  //Zend_Controller_Front::getInstance()->getRouter()->assemble(array())  //.core_menu_mini_menu.innerHTML
			//$form .= '<div class="payButtom" name="done" style="color:#fff" onclick="fSignup();">Signin to purchase</div>';
			$form .= '<a href="#" style="color:#fff" onclick="this.href=fSignup();"><div class="payButtom" name="done" style="color:#fff" >Signin to purchase</div></a>'; //2 onclick="fSignup();" this.href=
			
		}
	
        //$form .= "<button type=\"submit\" id=\"done\" name=\"done\">Buy</button>".$test."\n";
        $form .= "</form>\n";
		return $form;
    }

    /**
     * Perform any pre-posting actions
     *
     * @param none
     * @return none
     */
    protected function prepareSubmit()
    {
        // Fill if needed
    }

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    abstract protected function enableTestMode();

    /**
     * Validate the IPN notification
     *
     * @param none
     * @return boolean
     */
    abstract protected function validateIpn();

    /**
     * Logs the IPN results
     *
     * @param boolean IPN result
     * @return void
     */
    public function logResults($success)
    {
        if (!$this->logIpn) return;

        // Timestamp
        $text = '[' . date('m/d/Y g:i A').'] - ';

        // Success or failure being logged?
        $text .= ($success) ? "SUCCESS!\n" : 'FAIL: ' . $this->lastError . "\n";

        // Log the POST variables
        $text .= "IPN POST Vars from gateway:\n";
        foreach ($this->ipnData as $key=>$value)
        {
            $text .= "$key=$value, ";
        }

        // Log the response from the paypal server
        $text .= "\nIPN Response from gateway Server:\n " . $this->ipnResponse;

        // Write to log
        $fp = fopen($this->ipnLogFile,'a');
        fwrite($fp, $text . "\n\n");
        fclose($fp);
    }
}
