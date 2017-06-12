<?php
/*
Plugin Name: MCB Payment Gateway
Description: MCB payment gateway for woocommerce
Author: WebWorks.pk
Author URI: http://webworks.pk/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

session_start();
ob_start();

/**
 * Custom Payment Gateway.
 *
 * Provides a Custom Payment Gateway, mainly for testing purposes.
 */


add_action('plugins_loaded', 'init_custom_gateway_class');
function init_custom_gateway_class(){

    class WC_Gateway_Custom extends WC_Payment_Gateway {

        public $domain;

        /**
         * Constructor for the gateway.
         */
        public function __construct() {

            $this->domain = 'custom_payment';

            $this->id                 = 'custom';
            $this->icon               = apply_filters('woocommerce_custom_gateway_icon', '');
            $this->has_fields         = false;
            $this->method_title       = __( 'MCB', $this->domain );
            $this->method_description = __( 'Allows payments with MCB gateway.', $this->domain );

            // Load the settings.
            $this->init_form_fields();
            $this->init_settings();

            // Define user set variables
            $this->title        = $this->get_option( 'title' );
            $this->description  = $this->get_option( 'description' );
            $this->instructions = $this->get_option( 'instructions', $this->description );
            $this->order_status = $this->get_option( 'order_status', 'completed' );

            // Actions
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            add_action( 'woocommerce_thankyou_custom', array( $this, 'thankyou_page' ) );

            // Customer Emails
            add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
        }

        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', $this->domain ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Enable MCB Payment', $this->domain ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __( 'Title', $this->domain ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', $this->domain ),
                    'default'     => __( 'Custom Payment', $this->domain ),
                    'desc_tip'    => true,
                ),
                'order_status' => array(
                    'title'       => __( 'Order Status', $this->domain ),
                    'type'        => 'select',
                    'class'       => 'wc-enhanced-select',
                    'description' => __( 'Choose whether status you wish after checkout.', $this->domain ),
                    'default'     => 'wc-completed',
                    'desc_tip'    => true,
                    'options'     => wc_get_order_statuses()
                ),
                'description' => array(
                    'title'       => __( 'Description', $this->domain ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment method description that the customer will see on your checkout.', $this->domain ),
                    'default'     => __('Payment Information', $this->domain),
                    'desc_tip'    => true,
                ),
                'instructions' => array(
                    'title'       => __( 'Instructions', $this->domain ),
                    'type'        => 'textarea',
                    'description' => __( 'Instructions that will be added to the thank you page and emails.', $this->domain ),
                    'default'     => '',
                    'desc_tip'    => true,
                ),
            );
        }

        /**
         * Output for the order received page.
         */
        public function thankyou_page() {
            if ( $this->instructions )
                echo wpautop( wptexturize( $this->instructions ) );
        }

        /**
         * Add content to the WC emails.
         *
         * @access public
         * @param WC_Order $order
         * @param bool $sent_to_admin
         * @param bool $plain_text
         */
        public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
            if ( $this->instructions && ! $sent_to_admin && 'custom' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
                echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
            }
        }

        public function payment_fields(){

            if ( $description = $this->get_description() ) {
                echo wpautop( wptexturize( $description ) );
            }

        }

        /**
         * Process the payment and return the result.
         *
         * @param int $order_id
         * @return array
         */
        public function process_payment( $order_id ) {

            $order = wc_get_order( $order_id );

            $status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;

            // Set order status
            $order->update_status( $status, __( 'Checkout with MCB payment. ', $this->domain ) );

            // Reduce stock levels
            $order->reduce_order_stock();

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url( $order )
            );
        }
    }
}

add_filter( 'woocommerce_payment_gateways', 'add_custom_gateway_class' );
function add_custom_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Custom'; 
    return $methods;
}

add_action('woocommerce_checkout_process', 'process_custom_payment');
function process_custom_payment(){

    if($_POST['payment_method'] != 'custom')
        return;

    /*if( !isset($_POST['mobile']) || empty($_POST['mobile']) )
        wc_add_notice( __( 'Please add your mobile number', $this->domain ), 'error' );


    if( !isset($_POST['transaction']) || empty($_POST['transaction']) )
        wc_add_notice( __( 'Please add your transaction ID', $this->domain ), 'error' );*/

}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'custom_payment_update_order_meta' );
function custom_payment_update_order_meta( $order_id ) {

    if($_POST['payment_method'] != 'custom')
        return;

    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    // exit();

    //update_post_meta( $order_id, 'mobile', $_POST['mobile'] );
    //update_post_meta( $order_id, 'transaction', $_POST['transaction'] );
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order_meta', 10, 1 );
function custom_checkout_field_display_admin_order_meta($order){
    $method = get_post_meta( $order->id, '_payment_method', true );
    if($method != 'custom')
        return;

    /*$mobile = get_post_meta( $order->id, 'mobile', true );
    $transaction = get_post_meta( $order->id, 'transaction', true );*/
}

//redirects

add_action("template_redirect", "wc_custom_redirect_after_purchase");
function wc_custom_redirect_after_purchase() {
	global $wp;
	global $wpdb;
	global $woocommerce;
	global $order;
	
	$uri = $_SERVER['REQUEST_URI'];
	$uri_array = explode('/',$uri);
	$order_number = $uri_array[3];
	//$return_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$return_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$product_names;
	
	$payment_method_check = get_post_meta($order_number,'_payment_method',true);

if($payment_method_check == 'custom'):	
	$prefix = $wpdb->prefix;
	$sql = "SELECT order_item_name FROM ".$prefix."woocommerce_order_items WHERE order_id =".$order_number;
	$query_results = $wpdb->get_results($sql, ARRAY_A);
	
	foreach($query_results as $product_name):
		$product_names.= $product_name['order_item_name'].",";
	endforeach;
	
	$product_names = ltrim(rtrim($product_names,','));
	$total_price = get_post_meta($order_number,'_order_total', true) * 100;
	$transaction_ref = "crimsonatorderno".$order_number;
	$order_info = "ref_".$order_number;
	
	if ( is_checkout() && !empty( $wp->query_vars["order-received"] ) && !isset($_GET['pg']) && $_GET['pg'] != 'rdr' ):
		 update_post_meta($order_number, '_payment_method_title', 'Visa / Master Card but not approved yet!');
		
		/*$to = "ghulam.dastgir@webworks.pk";
		$subject = "Data";
		$txt = content_url().$transaction_ref.$product_names.$total_price.$return_url;
		$headers = "From: error@crimson.com.pk";

		mail($to,$subject,$txt,$headers);*/
		
		?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<!--<html>
<head><title>Virtual Payment Client Example</title>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <style type='text/css'>
        
        H1       { font-family:Arial,sans-serif; font-size:20pt; color:#08185A; font-weight:600; margin-bottom:0.1em}
        H2       { font-family:Arial,sans-serif; font-size:14pt; color:#08185A; font-weight:100; margin-top:0.1em}
        H2.co    { font-family:Arial,sans-serif; font-size:24pt; color:#08185A; margin-top:0.1em; margin-bottom:0.1em; font-weight:100}
        H3.co    { font-family:Arial,sans-serif; font-size:16pt; color:#FFFFFF; margin-top:0.1em; margin-bottom:0.1em; font-weight:100}
        BODY     { font-family:Verdana,Arial,sans-serif; font-size:10pt; color:#08185A background-color:#FFFFFF }
        TR       { height:25px; }
        TR.shade { height:25px; background-color:#CED7EF }
        TR.title { height:25px; background-color:#0074C4 }
        TD       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        P        { font-family:Verdana,Arial,sans-serif; font-size:10pt; color:#FFFFFF }
        P.blue   { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#08185A }
        P.red    { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
        P.green  { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#00AA00 }
        DIV.bl   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#0074C4 }
        LI       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
        INPUT    { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold }
        SELECT   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold }
        TEXTAREA { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:normal; scrollbar-arrow-color:#08185A; scrollbar-base-color:#CED7EF }
        A:link   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        A:visited{ font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
        A:hover  { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0000 }
        A:active { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0000 }
        
    </style>
</head>
<body>
 start branding table 
<table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
    <tr>
        <td bgcolor='#CED7EF' width='90%'><h2 class='co'>&nbsp;MasterCard Virtual Payment Client Example</h2></td>
    </tr>
</table>
 end branding table 

<center><h1>PHP 3-Party Transaction</h1></center>
<center><h2>Simply input those required fields to change the functionality.</h2></center>


 The "Pay Now!" button submits the form and gives control to the form 'action' parameter 
<form action="http://www.crimson.com.pk/mcb/PHP_VPC_3Party_Order_DO.php" method="post" accept-charset="UTF-8">
<input type="hidden" name="Title" value = "PHP VPC 3 Party Transacion">

 get user input 
<table width="80%" align="center" border="0" cellpadding='0' cellspacing='0'>

<tr class="shade">
    <td align="right"><strong><em>Virtual Payment Client URL:&nbsp;</em></strong></td>
    <td><input  name="virtualPaymentClientURL" size="65" value="https://migs.mastercard.com.au/vpcpay" maxlength="250"/></td>
</tr>
<tr><td colspan="2">&nbsp;<hr width="75%">&nbsp;</td></tr>
<tr class="title">
    <td colspan="2" height="25"><p><strong>&nbsp;Basic 3-Party Transaction Fields</strong></p></td>
</tr>
<tr>
    <td align="right"><strong><em> VPC Version: </em></strong></td>
    <td><input name="vpc_Version" value="1" size="20" maxlength="8"/></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Command Type: </em></strong></td>
    <td><input name="vpc_Command" value="pay" size="20" maxlength="16"/></td>
</tr>
<tr>
    <td align="right"><strong><em>Merchant AccessCode: </em></strong></td>
    <td><input name="vpc_AccessCode" value="8D34E5F7" size="20" maxlength="8"/></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Merchant Transaction Reference: </em></strong></td>
    <td><input name="vpc_MerchTxnRef" value="<?php echo $transaction_ref; ?>" size="20" maxlength="40"/></td>
</tr>
<tr>
    <td align="right"><strong><em>MerchantID: </em></strong></td>
    <td><input name="vpc_Merchant" value="562150180284" size="20" maxlength="16"/></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Transaction OrderInfo: </em></strong></td>
    <td><input name="vpc_OrderInfo" value="Lawn suit" size="20" maxlength="34"/></td>
</tr>
<tr>
    <td align="right"><strong><em>Purchase Amount: </em></strong></td>
    <td><input name="vpc_Amount" value="<?php echo $total_price; ?>" maxlength="10"/></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Receipt ReturnURL: </em></strong></td>
    <td><input name="vpc_ReturnURL" size="65" value="http://www.crimson.com.pk/mcb/PHP_VPC_3Party_Order_DR.php" maxlength="250"/></td>
</tr>
<tr>
    <td align="right"><strong><em>Payment Server Display Language Locale: </em></strong></td>
    <td><select name="vpc_Locale"><option SELECTED>en_AU</option><option>en_AU</option></select></td>
</tr>
<tr class="shade">
    <td align="right"><strong><em>Currency: </em></strong></td>
    <td><select name="vpc_Currency"><option SELECTED>PKR</option></select></td>
</tr>



<tr>    <td colspan="2">&nbsp;</td></tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" NAME="SubButL" value="Pay Now!"></td>
</tr>
<tr><td colspan="2">&nbsp;<hr width="75%">&nbsp;</td></tr>

<tr>
    <td colspan="2">
        <p class='blue'><strong><em><u>Note</u>:</em></strong><br/>
            Any information passed through the customer's browser
            can potentially be modified by the customer, or even by third parties to
            fraudulently alter the transaction data. Therefore all transactional
            information should <strong>not</strong> be passed through the browser in
            a way that could potentially be modified (e.g. hidden form fields).
            Transaction data should only be accepted once from a browser at the
            point of input, and then kept in a way that does not allow others
            to modify it (e.g. database, server session, etc.). Any transaction
            information displayed to a customer, such as amount, should be passed
            only as display information and the actual transactional data should be
            retrieved from the secure source last thing at the point of processing
        the transaction.</p>
       
    </td>
</tr>

<tr>
    <td width="40%">&nbsp;</td>
    <td width="60%">&nbsp;</td>
</tr>

</table>

</form>
</body>

<head>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
</head>
</html>-->




			<h3>Redirecting to payment gateway...!</h3>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
			<form name="payment_with_mcb" id="payment_with_mcb" action="http://www.crimson.com.pk/mcb/PHP_VPC_3Party_Order_DO.php" method="post" accept-charset="UTF-8">
				
				<input type="hidden" name="virtualPaymentClientURL" size="65" value="https://migs.mastercard.com.au/vpcpay" maxlength="250"/>
				<input type="hidden" name="vpc_Version" value="1" size="20" maxlength="8"/>
				<input type="hidden" name="vpc_Command" value="pay" size="20" maxlength="16"/>
				<input type="hidden" name="vpc_AccessCode" value="8D34E5F7" size="20" maxlength="8"/>
				<input type="hidden" name="vpc_MerchTxnRef" value="<?php echo $transaction_ref; ?>" size="20" maxlength="40"/>
				<input type="hidden" name="vpc_Merchant" value="562150180284" size="20" maxlength="16"/>
				<input type="hidden" name="vpc_OrderInfo" value="<?php echo $order_info; ?>" size="20" maxlength="34"/>
				<input type="hidden" name="vpc_Amount" value="<?php echo $total_price; ?>" maxlength="10"/>
				<input type="hidden" name="vpc_ReturnURL" size="65" value="<?php echo $return_url."&pg=rdr"; ?>" maxlength="250"/>
				<input type="hidden" name="vpc_Locale" value="en_AU" />
				<input type="hidden" name="vpc_Currency" value="PKR" />
				<p>If not redirected in 3 seconds, please press the below button</p>
				<input id="submit_payment_g" type="submit" NAME="SubButL" value="Pay Now!">
			</form>
			<script type="text/javascript">
				$(document).ready(function(){
					setTimeout(function(){ 
						$('#payment_with_mcb').submit();
					}, 2000);
					$( "#submit_payment_g" ).trigger( "click" );
					//$('#payment_with_mcb').submit();
				});
			</script>	
		<?php
		//wp_redirect( "http://www.yoururl.com/your-page/" );
		exit;
	else:
		// Initialisation
		// ==============

		// 
		include('VPCPaymentConnection.php');
		$conn = new VPCPaymentConnection();


		// This is secret for encoding the SHA256 hash
		// This secret will vary from merchant to merchant

		$secureSecret = "FFA67784C814BD69815A835F60A1EF2F";

		// Set the Secure Hash Secret used by the VPC connection object
		$conn->setSecureSecret($secureSecret);


		// Set the error flag to false
		$errorExists = false;



		// *******************************************
		// START OF MAIN PROGRAM
		// *******************************************


		// This is the title for display
		$title  = $_GET["Title"];


		// Add VPC post data to the Digital Order
		foreach($_GET as $key => $value) {
			if (($key!="vpc_SecureHash") && ($key != "vpc_SecureHashType") && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
				$conn->addDigitalOrderField($key, $value);
			}
		}

		// Obtain a one-way hash of the Digital Order data and
		// check this against what was received.
		$serverSecureHash	= array_key_exists("vpc_SecureHash", $_GET)	? $_GET["vpc_SecureHash"] : "";
		$secureHash = $conn->hashAllFields();
		if ($secureHash==$serverSecureHash) {
			$hashValidated = "<font color='#00AA00'><strong>CORRECT</strong></font>";
		} else {
			$hashValidated = "<font color='#FF0066'><strong>INVALID HASH</strong></font>";
			$errorsExist = true;
		}
		
		$Title 				= array_key_exists("Title", $_GET) 						? $_GET["Title"] 				: "";
		$againLink 			= array_key_exists("AgainLink", $_GET) 					? $_GET["AgainLink"] 			: "";
		$amount 			= array_key_exists("vpc_Amount", $_GET) 				? $_GET["vpc_Amount"] 			: "";
		$locale 			= array_key_exists("vpc_Locale", $_GET) 				? $_GET["vpc_Locale"] 			: "";
		$batchNo 			= array_key_exists("vpc_BatchNo", $_GET) 				? $_GET["vpc_BatchNo"] 			: "";
		$command 			= array_key_exists("vpc_Command", $_GET) 				? $_GET["vpc_Command"] 			: "";
		$message 			= array_key_exists("vpc_Message", $_GET) 				? $_GET["vpc_Message"]			: "";
		$version  			= array_key_exists("vpc_Version", $_GET) 				? $_GET["vpc_Version"] 			: "";
		$cardType   		= array_key_exists("vpc_Card", $_GET) 					? $_GET["vpc_Card"] 			: "";
		$orderInfo 			= array_key_exists("vpc_OrderInfo", $_GET) 				? $_GET["vpc_OrderInfo"] 		: "";
		$receiptNo 			= array_key_exists("vpc_ReceiptNo", $_GET) 				? $_GET["vpc_ReceiptNo"] 		: "";
		$merchantID  		= array_key_exists("vpc_Merchant", $_GET) 				? $_GET["vpc_Merchant"] 		: "";
		$merchTxnRef 		= array_key_exists("vpc_MerchTxnRef", $_GET) 			? $_GET["vpc_MerchTxnRef"]		: "";
		$authorizeID 		= array_key_exists("vpc_AuthorizeId", $_GET) 			? $_GET["vpc_AuthorizeId"] 		: "";
		$transactionNo  	= array_key_exists("vpc_TransactionNo", $_GET) 			? $_GET["vpc_TransactionNo"] 	: "";
		$acqResponseCode 	= array_key_exists("vpc_AcqResponseCode", $_GET) 		? $_GET["vpc_AcqResponseCode"] 	: "";
		$txnResponseCode 	= array_key_exists("vpc_TxnResponseCode", $_GET) 		? $_GET["vpc_TxnResponseCode"] 	: "";
		$riskOverallResult	= array_key_exists("vpc_RiskOverallResult", $_GET) 		? $_GET["vpc_RiskOverallResult"]: "";

				// Obtain the 3DS response
		$vpc_3DSECI				= array_key_exists("vpc_3DSECI", $_GET) 			? $_GET["vpc_3DSECI"] : "";
		$vpc_3DSXID				= array_key_exists("vpc_3DSXID", $_GET) 			? $_GET["vpc_3DSXID"] : "";
		$vpc_3DSenrolled 		= array_key_exists("vpc_3DSenrolled", $_GET) 		? $_GET["vpc_3DSenrolled"] : "";
		$vpc_3DSstatus 			= array_key_exists("vpc_3DSstatus", $_GET) 			? $_GET["vpc_3DSstatus"] : "";
		$vpc_VerToken 			= array_key_exists("vpc_VerToken", $_GET) 			? $_GET["vpc_VerToken"] : "";
		$vpc_VerType 			= array_key_exists("vpc_VerType", $_GET) 			? $_GET["vpc_VerType"] : "";
		$vpc_VerStatus			= array_key_exists("vpc_VerStatus", $_GET) 			? $_GET["vpc_VerStatus"] : "";
		$vpc_VerSecurityLevel	= array_key_exists("vpc_VerSecurityLevel", $_GET) 	? $_GET["vpc_VerSecurityLevel"] : "";


			// CSC Receipt Data
		$cscResultCode 	= array_key_exists("vpc_CSCResultCode", $_GET)  			? $_GET["vpc_CSCResultCode"] : "";
		$ACQCSCRespCode = array_key_exists("vpc_AcqCSCRespCode", $_GET) 			? $_GET["vpc_AcqCSCRespCode"] : "";

		// Get the descriptions behind the QSI, CSC and AVS Response Codes
			// Only get the descriptions if the string returned is not equal to "No Value Returned".

		$txnResponseCodeDesc = "";
		$cscResultCodeDesc = "";
		$avsResultCodeDesc = "";
    
			if ($txnResponseCode != "No Value Returned") {
				$txnResponseCodeDesc = getResultDescription($txnResponseCode);
			}

			if ($cscResultCode != "No Value Returned") {
				$cscResultCodeDesc = getCSCResultDescription($cscResultCode);
			}


				$error = "";
			// Show this page as an error page if error condition
			if ($txnResponseCode=="7" || $txnResponseCode=="No Value Returned" || $errorExists) {
				$error = "Error ";
			}
		if($txnResponseCode == '0'):
			update_post_meta($order_number, '_payment_method_title', 'Visa / Master Card and approved by MCB!');

			function wdm_my_custom_notes_on_single_order_page($order){

					$category_array=array();
					foreach( $order->get_items() as $item_id => $item ) {
						$product_id=$item['product_id'];
						$product_cats = wp_get_post_terms( $product_id, 'product_cat' );
						foreach( $product_cats as $key => $value ){
							if(!in_array($value->name,$category_array)){
									array_push($category_array,$value->name);
							}
						}
					}
					$note = '<b>Payment was approved by MCB.</b>';
					$order->add_order_note( $note );

					}

			add_action( 'woocommerce_order_details_after_order_table', 'wdm_my_custom_notes_on_single_order_page',10,1 );
		else:
			update_post_meta($order_number, '_payment_method_title', 'Visa / Master Card and not approved yet!');
			function wdm_my_custom_notes_on_single_order_page($order){

					$category_array=array();
					foreach( $order->get_items() as $item_id => $item ) {
						$product_id=$item['product_id'];
						$product_cats = wp_get_post_terms( $product_id, 'product_cat' );
						foreach( $product_cats as $key => $value ){
							if(!in_array($value->name,$category_array)){
									array_push($category_array,$value->name);
							}
						}
					}
					$note = '<b>Payment was not approved by MCB.</b>';
					$order->add_order_note( $note );

					}

			add_action( 'woocommerce_order_details_after_order_table', 'wdm_my_custom_notes_on_single_order_page',10,1 );
		endif;
	endif;
 endif;	
}

