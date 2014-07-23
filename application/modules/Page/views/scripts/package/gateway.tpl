<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Page
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: gateway.tpl 8221 2011-07-25 00:24:02Z taalay $
 * @author     Taalay (TJ)
 */
?>

<?php if( $this->status == 'pending' ): // Check for pending status ?>
  Your subscription is pending payment. You will receive an email when the
  payment completes.
<?php else: ?>

  <form method="get" name="form_pay" action="<?php echo $this->escape($this->url(array('action' => 'process'))) ?>"
  
   
   
        class="global_form" enctype="application/x-www-form-urlencoded">
		
		<?php echo '<input type="hidden" name="startDate" value="'.date("Y")."-".date("m")."-".date("d").'" />'; ?>
		
		  <?php
  
	echo '<input type="hidden" name="h_email" value="'.Engine_Api::_()->user()->getViewer()->email.'" />';
	echo '<input type="hidden" name="h_uid" value="'.Engine_Api::_()->user()->getViewer()->getIdentity().'" />';
  
  ?>
  
  
    <div>
      <div>
        <h3>
          <?php echo $this->translate('Pay for Access') ?>
        </h3>
        <p class="form-description">
          <?php echo $this->translate('You have selected an account type that requires ' .
            'subscription payments. You will be taken to a secure ' .
            'checkout area where you can setup your subscription. Remember to ' .
            'continue back to our site after your purchase to sign in to your ' .
            'account.') ?>
        </p>
        <p style="font-weight: bold; padding-top: 15px; padding-bottom: 15px;">
          <?php echo $this->translate('Please setup your subscription to continue:') ?>
          <?php echo $this->package->getPackageDescription();
		  $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD');
		  $view = Zend_Registry::get('Zend_View');
		 //$price = $view->locale()->toCurrency($this->package->price,$currency);
		 $price = round( $this->package->price, 2);
		// $price

		
		if($price == 5.99)
		{ ?>
		
			<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 1000736782;
			var google_conversion_language = "en";
			var google_conversion_format = "3";
			var google_conversion_color = "ffffff";
			var google_conversion_label = "GfxrCLr1tAgQjpCY3QM";
			var google_conversion_value = 5.99;

			var google_remarketing_only = false;
			/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			
			<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=5.99&amp;label=GfxrCLr1tAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
			
		<?php
		}
		else if($price == 7.99)
		{ ?>
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 1000736782;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "QiKcCKr3tAgQjpCY3QM";
				var google_conversion_value = 7.99;

				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				
				<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=7.99&amp;label=QiKcCKr3tAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
				
		<?php
		}
		else if($price == 9.99)
		{ ?>
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 1000736782;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "1nfSCJr5tAgQjpCY3QM";
				var google_conversion_value = 9.99;

				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=7.99&amp;label=QiKcCKr3tAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
		<?php
		}
		else if($price == 59.99)
		{ ?>
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 1000736782;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "632UCJrbtAgQjpCY3QM";
				var google_conversion_value = 59.99;
				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				
				<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=59.99&amp;label=632UCJrbtAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
		<?php
		}
		
		else if($price == 79.99)
		{ ?>
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 1000736782;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "W8eCCLL2tAgQjpCY3QM";
				var google_conversion_value = 79.99;
				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=79.99&amp;label=W8eCCLL2tAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
		<?php
		}
		else if($price == 99.99)
		{ ?>
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 1000736782;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "KyCUCKL4tAgQjpCY3QM";
				var google_conversion_value = 99.99;

				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				<input type="hidden" name="h_googleConv" value='<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1000736782/?value=99.99&amp;label=KyCUCKL4tAgQjpCY3QM&amp;guid=ON&amp;script=0"/>' />
		<?php
		}
		else
		{?>
		
			<input type="hidden" name="h_googleConv" value='' />
		
		<?php
		
		}
		
		?>
		



		<?php
		//Pending 
		/*
		$db = Engine_Db_Table::getDefaultAdapter();

		$table = Engine_Api::_()->getDbTable('pages', 'page');
		$prefix = $table->getTablePrefix();
		  
		$user_id = (int)Engine_Api::_()->user()->getViewer()->getIdentity();
	  
	  //check if i-payout payment is pending
	  $sql = "
		SELECT count(*) cnt
		FROM business b
        where page_id={$page_id} and user_id = {$user_id} and status is null";
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
		
		

echo "ZZZ".$user_id;

*/
		//
		
		 
		 
		  ?>
        </p>
        <div class="form-elements">
          <div id="buttons-wrapper" class="form-wrapper">
              <?php /* foreach( $this->gateways as $gatewayInfo ):
                $gateway = $gatewayInfo['gateway'];
                $plugin = $gatewayInfo['plugin'];
                $first = ( !isset($first) ? true : false );
                ?>
                <?php if( !$first ): ?>
                  <?php echo $this->translate('or') ?>
                <?php endif; ?>
                <button type="submit" name="execute" onclick="$('gateway_id').set('value', '<?php echo $gateway->gateway_id ?>')">
                  <?php echo $this->translate('Pay with %1$s', $this->translate($gateway->title)) ?>
                </button>
				
				
              <?php endforeach; */?>
			  
			  
			  
<script type="text/javascript">

function fValidate(expirationDate)
{
	var err = 0;
	
	if (myTrim(document.form_pay.firstName.value) == "")
	{
		err = 1;
	}
	else if (myTrim(document.form_pay.lastName.value) == "")
	{
		err = 1;
	}
	else if (myTrim(document.form_pay.cardNumber.value) == "")
	{
		err = 1;
	}
	else if (myTrim(expirationDate) == "-")
	{
		err = 1;
	}
	
	return err;
	
}

function fExpDate()
{
var expirationDate = '';

try
	{
		expirationDate =  document.form_pay.eYear.value + "-" + document.form_pay.eMonth.value;
	}
	catch(e)
	{
	}
	
	try
	{
		if (expirationDate == '')
		{
			expirationDate =  document.form_pay.expirationDate.value;
			
		}
	}
	catch(e)
	{
	}
	
	return expirationDate;
	
}

function fCreate(obj)
{

	fpayButtonDisabled(obj);
	
var expirationDate = fExpDate();

	var loc = String(window.location);
	
	var package_id = loc.substr(loc.lastIndexOf("/")+1);
	
	 document.form_pay.h_package_id.value = package_id;
	 
	 
	if (submit_go == 1)
	{
		submit_go = 0;
		
	document.form_pay.h_exp.value = expirationDate;


	var err = fValidate(expirationDate);

	if (err == 1)
	{
		document.getElementById("msg").innerHTML = "";
		document.getElementById("err").innerHTML = "Please enter required fields.";
	}
	else
	{

	document.getElementById("msg").innerHTML = "";


	}
	document.form_pay.h_fname.value = document.form_pay.firstName.value;
	document.form_pay.h_lname.value = document.form_pay.lastName.value;
	document.form_pay.h_card.value = document.form_pay.cardNumber.value.substr((document.form_pay.cardNumber.value.length -4), 4);
	
	var str="&amount=" + document.form_pay.amount.value;
	str += "&refId=" + 123; //document.form_pay.refId.value;
	
str += "&name=" + "channel 1"; //document.form_pay.name.value;
	str += "&length=" + 4; //document.form_pay.length.value;
	
str += "&unit=" + document.form_pay.unit.value;
	
str += "&startDate=" + document.form_pay.startDate.value;
	
str += "&totalOccurrences=" + document.form_pay.totalOccurrences.value;
	
str += "&trialOccurrences=0"; //+ document.form_pay.trialOccurrences.value;

	str += "&trialAmount=" + document.form_pay.trialAmount.value;
	
str += "&cardNumber=" + document.form_pay.cardNumber.value;
	
str += "&expirationDate=" + expirationDate;
	
str += "&firstName=" + document.form_pay.firstName.value;
	
str += "&lastName=" + document.form_pay.lastName.value;
str += "&page_id=" + document.form_pay.h_page_id.value;
str += "&uid=" + document.form_pay.h_uid.value;
str += "&package_id=" + document.form_pay.h_package_id.value;

	go_ajax2("subscription_create.php?task=package"+str, "/bv/custom/auth/ajax/", "subscription_create");

	}
}


</script>
<script type="text/javascript">
var submit_go = 1;
var refId = '';
var myObj;

function fpayButtonEnabled()
{
	submit_go = 1;
	
	myObj.className = "payButtom";
	
	
}


function fpayButtonDisabled(obj)
{
	if (obj.className != "payButtonDisabled")
	{
		myObj = obj;
		obj.className = "payButtonDisabled";
		//document.form_pay.submit();
	}
	
}

function fPayOut(obj)
{
	var loc = String(window.location);
	
	var package_id = loc.substr(loc.lastIndexOf("/")+1);
	
	 document.form_pay.h_package_id.value = package_id;
	 
	 
	if (obj.className != "payButtonDisabled")
	{
	
		obj.className = "payButtonDisabled";

		
		if (submit_go == 1)
		{
			submit_go = 0;
			
		var timestamp = Number(new Date());
		//refId = document.form_pay.ref_id.value + "_" + document.form_pay.h_page_id.value + "_" + document.form_pay.h_uid.value +"_"+timestamp;
		refId = document.form_pay.ref_id.value + "_" + package_id + "_" + document.form_pay.h_uid.value +"_"+timestamp;
		
		/*
		alert("eWallet_AddCheckoutItems.php?task=package" + "&package_id="+package_id+ "&email=" +document.form_pay.h_email.value +"&uid=" +document.form_pay.h_uid.value+ "&am=" + document.form_pay.amount.value + "&item_desc=" +document.form_pay.item_desc.value+ 
		"&ref_id=" +refId);
		
		*/
		
		go_ajax2("eWallet_AddCheckoutItems.php?task=package" + "&package_id="+package_id+ "&email=" +document.form_pay.h_email.value +"&uid=" +document.form_pay.h_uid.value+ "&am=" + document.form_pay.amount.value + "&item_desc=" +document.form_pay.item_desc.value+ 
		"&ref_id=" +refId, "/bv/custom/auth/ipayout/", "subscription_create_payout");
	
		
		}
	
	}
}
</script>
<script type="text/javascript">
function go_ajax2(str, dir, action)
{
var xmlhttp;
var cpt;

var a, b, c, d;
var search_opt, x, p, ind, str, str2, empty_str;

//var x_edit_coupon = '<!--xcp_001-->edit coupon<!--xc_001-->';

var x_edit_coupon = 'edit coupon';
var x_select_coupon = '<!--xcp_002--><< click to select coupon<!--xc_002-->';

if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {
  // code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
else
  {
alert("Your browser does not support XMLHTTP!");
  }


xmlhttp.onreadystatechange=function()
{
if(xmlhttp.readyState==4)
  {
 
	empty_str = "<h1>Your shopping cart is empty.</h1> <br/><br/><br/> <div style='display:block; height: 1px; width: 974px; background-color: #969ec1;' ></div> <br/> <p style='width: 500px;'> If you think that you have received this page as result of an error - please check whether your browser settings allows to accept cookies. <br/> If this issue remains please give us a call and we will process your order or report the issue with a website via an email. </p> <div class='click' onclick='continue_shopping()'><img src='images/continue-shopping.png'  border='0'></div>";


	//lert(action + " :g " + xmlhttp.responseText);
	
	
	a = xmlhttp.responseText.split("!@#$");
	
	
	if (action == "subscription_create")
	{
	
		//lert(action + " : " + xmlhttp.responseText);
		
		b = a[1].split(";");
		
		if (a[1] == "Error1:")
		{
			document.getElementById("msg").innerHTML = "Account with this email already exist.";
		}
		else if (b[1] == 'I00001')
		{
			document.getElementById("dGoogleConv").innerHTML = document.form_pay.h_googleConv.value;
			document.getElementById("disp").innerHTML = '<br/> Thank you for your purchase. Transaction Id:' + b[3] + '<br/><br/> <a href="/bv/create-pages/id/' +document.form_pay.h_package_id.value+'"><div type="button" id="done2" name="done2" class="payButtom" style="width:220px; color:#fff">Click here to continue</div></a>';
			document.form_pay.h_trans_id.value = b[3];
			
			/*
			document.form_pay.action = "/bv/browse-pages/sort_type/sort/sort_value/sub?c=0";
			document.form_pay.target = "_parent";
			document.form_pay.submit();
			*/

		}
		else if (b[1] == 'E00013')
		{
			document.getElementById("err").innerHTML = b[2];
		}
		else if (b[1] == 'E00012')
		{
			document.getElementById("err").innerHTML = b[2];
		}
		else 
		{
			document.getElementById("err").innerHTML = "The transaction failed.";
			fpayButtonEnabled();
		}

		document.form_pay.h_submit_ind.value = 1;
		
		document.form_pay.h_proceed.value = 1;

	}
	else if (action == "subscription_create_payout")
	{
		a = xmlhttp.responseText.split(";");
		
		if(a[0] == "NO_ERROR")
		{
			
			go_ajax2("ipayout_create_subscription.php?task=package"+"&package_id="+document.form_pay.h_package_id.value +"&ref_id=" +refId, "/bv/custom/auth/ipayout/", "ipayout_create_subscription");
	
		}
		else if(a[0] == "CUSTOMER_NOT_FOUND")
		{
		
			document.getElementById("global_content").innerHTML = document.form_pay.h_frame.value;
		}
		else 
		{
			document.getElementById("disp").innerHTML = "An error occurred. Please try again later.";
		}
	}
	else if (action == "ipayout_create_subscription")
	{
	
		document.getElementById("AuthorizeNetSeal").innerHTML = "";
		document.getElementById("dGoogleConv").innerHTML = document.form_pay.h_googleConv.value;
		document.getElementById("disp").innerHTML = '<br/> Thank you for your subscription. Invoice was sent to <a href="https://bio-views.globalewallet.com" target="_new">I-Payout</a>. <br/>Please login to I-Payout to finish payment process. <br/>Once payment is made proceed to <a href="/bv/create-pages/id/' +document.form_pay.h_package_id.value+'">"My Subscription"</a> screen.<br/><br/> <!--a href="/bv/create-pages/id/' +document.form_pay.h_package_id.value+'"><div type="button" id="done2" name="done2" class="payButtom" style="width:220px; color:#fff">Click here to continue</div></a-->';
		
	}
	
 }
	
}


str = dir + str;

xmlhttp.open("Get",str+"&loc="+loc(),true);
xmlhttp.send(null);


}

function loc()
{

 var s, s2, s3, path;

	s = "" + window.location;

	s2 = s.replace(/\//g,"");

	n = s.length - s2.length - 4;

	s3 = s2.replace(".com","")


	//in Prod
	if(s3.length < s2.length)
	{
		n = n + 1;
	}

	path = "";
	for (i=0; i<n;i++)
	{
		path = path + "../";
	}

	return path;
}

function myTrim(str)
{
var str;

	str = str.replace(/ /g,"");
	str = str.replace(/</g,"");
	str = str.replace(/>/g,"");
	str = str.replace(/"/g,"'");
	return str;
}


var d = new Date();
var year = d.getFullYear();

var selYear = '<select name="eYear">';
selYear += '<option value="'+year+'">'+year+'</option>';

for (var i=0; i<10; i++)
{
	year++;
	selYear += '<option value="'+year+'">'+year+'</option>';
}
	selYear += '</select>';
						

</script>


<input type="hidden" name="name" value="BV-subscription2">
<input type="hidden" name="length" value="1">
<input type="hidden" name="unit" value="months">
<input type="hidden" name="totalOccurrences" value="9999"> 

<input type="hidden" name="amount" value="<?php echo $price; ?>">
<input type="hidden" name="trialAmount" value="<?php echo $price; ?>">
<input type="hidden" name="h_page_id" value="<?php   echo Engine_Api::_()->user()->getViewer()->getIdentity(); ?>">
<input type="hidden" name="h_page_title" value="<?php //echo $this->translate($this->layout()->siteinfo['title']); ?>">
<input type="hidden" name="h_trans_id" value=""> 
<input type="hidden" name="h_card" value=""> 
<input type="hidden" name="h_exp" value=""> 
<input type="hidden" name="h_lname" value=""> 
<input type="hidden" name="h_fname" value=""> 
<input type="hidden" name="item_desc" value="channel subscription2"> 
<input type="hidden" name="ref_id" value="chSub"> 
<input type="hidden" name="h_package_id" value="0"> 

			  <br/><br/>
			  
			  
			  <div id="disp">
  <table>
	<tr><td  width="200">First Name <span class="red">*</span></td><td  width="250"><input type="text" name="firstName"  value=""/></td></tr>
	<tr><td>Last Name <span class="red">*</span></td><td><input type="text" name="lastName"  value=""/></td></tr>
	<tr>
                    <td>
                        <font size="2" face="arial">Credit Card Number<span class="red">*</span></font>

                    </td>
                    <td>
                        <input type="text" name="cardNumber" value="">
                    </td>
                </tr>
				
	 <tr>
                    <td>
                        <font size="2" face="arial">Expiration Date<span class="red">*</span></font>
                    </td>
                    <td>
                        <!--input type="text" name="expirationDate" value=""> <font size="1" face="arial">YYYY-MM</font-->
						<select name="eMonth">
							<option value="01">01</option>
							<option value="02">02</ption>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select> &nbsp;
						
						<span id="selectY"></span>
                    </td>
                </tr>
		
		
		<tr>
		
			<td>
				<span class="red">*</span> - required fields.
			</td>
			
			<td>
				 <span><img src="/bv/custom/v.gif" /> <img src="/bv/custom/mc.gif" /> <img src="/bv/custom/amex.gif" /><img src="/bv/custom/disc.gif" /></span>
			</td>
			
		</tr>
  </table>
  <br/>
  
  
  <br/>
  <div id="err" class="red"></div>
  <div id="msg" class="red"></div>
  <br/>
  
  
  			  <!--center> <div type="button" id="done" name="done" onclick="fCreate(this);" style="width:220px; color:#fff" class="payButtom" >Pay with credit card</div> </center><br/> 
				<center> <div type="button" id="done2" name="done2" onclick="fPayOut(this);" class="payButtom" style="width:220px; color:#fff">Pay with I-PayOut</div> </center-->
				

  <table>
  <tr><td width="200px"></td><td  width="250px"><div type="button" id="done" name="done" onclick="fCreate(this);" style="width:180px; color:#fff" class="payButtom" >Pay with credit card</div></td>
  </tr>
  <tr><td colspan="3" style="height:30px"><div class="comments_options" style="border-top: 1px solid #76767d; margin 20px"></div></td></tr>
  <tr><td><span>No Credit Card? No problem! </span></td>
  <td><div type="button" id="done2" name="done2" onclick="fPayOut(this);" class="payButtom" style="width:180px; color:#fff">Pay with I-PayOut</div></td></tr>
  
  <tr><td width="200px"></td><td > <span ><a href="https://www.i-payout.com" target="_new">Learn more about I-PayOut</a></span></td></tr>
</table>

  
  
  
  
  </div>
  
     <br/><br/>
   
<!-- (c) 2005, 2013. Authorize.Net is a registered trademark of CyberSource Corporation --> 
<div class="AuthorizeNetSeal"id="AuthorizeNetSeal" style="float:left; margin:20px; display:block; width: 110px; height: 150px"> <script type="text/javascript" language="javascript">var ANS_customer_id="cc165d67-4f34-42cf-8d67-b4788a2cde28";</script> 
	<script type="text/javascript" language="javascript" src="https://verify.authorize.net/anetseal/seal.js" ></script> 
	<a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Internet Payments</a>
 </div>
  
<div style="float:left; margin:20px 20px 20px 20px; display:block; width: 110px; height: 150px">

  <span id="siteseal" style="margin-buttom:20px; display:block; width: 110px; height: 50px; "><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=5ucsYW4SuvPHjkb4zD8nb3Q7dNcHhm1zMrBcsComT8Dgt0myWpsnUtAX9xz"></script></span> 
</div>


  <div style="float:left; margin:20px 20px 20px 50px; display:block; width: 110px; height: 150px">
  <span style="margin-top:20px"><script type="text/javascript" src="https://www.rapidscansecure.com/siteseal/siteseal.js?code=65,28249BDDAA76A676342C0D72DC02F4F8BE5FDA36"></script></span>
</div>


  <script>
	document.getElementById("selectY").innerHTML = selYear;
  </script>
  
  
  
  

  
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="gateway_id" id="gateway_id" value="" />
	

			<div id="dGoogleConv" style="display:inline;">
			</div>

			
			
  </form>

<?php endif; ?>
