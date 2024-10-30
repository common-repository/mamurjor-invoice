

<?php 


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
global $newVar;
$charset_collate = $wpdb->get_charset_collate();
$mamurjor_invoice_table_name=$wpdb->prefix.'mamurjor_invoice';
$sql = "CREATE TABLE $mamurjor_invoice_table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  item Text DEFAULT '' NOT NULL,
  price Text DEFAULT '' NOT NULL,
  qty Text DEFAULT '' NOT NULL,
  total Text DEFAULT '' NOT NULL,
  discount Text DEFAULT '' NOT NULL,
  shipped Text DEFAULT '' NOT NULL,
  grandTotal Text DEFAULT '' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

if ($wpdb->get_var("SHOW TABLES LIKE '$mamurjor_invoice_table_name'") != $mamurjor_invoice_table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
  
  
  
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$mamurjor_invoice_table_name=$wpdb->prefix.'mamurjor_invoice_details';
$sqlorderdetails = "CREATE TABLE $mamurjor_invoice_table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  billedto Text DEFAULT '' NOT NULL,
  shippedto Text DEFAULT '' NOT NULL,
  paymenttype Text DEFAULT '' NOT NULL,
  orderdate Text DEFAULT '' NOT NULL,
  ordderid Text DEFAULT '' NOT NULL,
  total Text DEFAULT '' NOT NULL,
  discount Text DEFAULT '' NOT NULL,
  shippingcharge Text DEFAULT '' NOT NULL,
  grandTotal Text DEFAULT '' NOT NULL,
  totalqty Text DEFAULT '' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

if ($wpdb->get_var("SHOW TABLES LIKE '$mamurjor_invoice_table_name'") != $mamurjor_invoice_table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sqlorderdetails);
  }

add_action('admin_menu', 'mamurjor_mamurjor_report_admin');
if(!function_exists('mamurjor_mamurjor_report_admin')){
function mamurjor_mamurjor_report_admin() {
add_menu_page('report', 'report', 'manage_options', 'report','mamurjor_report', 'dashicons-admin-users');
}
	
}



add_action('admin_menu', 'mamurjor_invoice_admin');
if(!function_exists('mamurjor_invoice_admin')){
function mamurjor_invoice_admin() {
add_menu_page('invoice', 'invoice', 'manage_options', 'invoice','mamurjor_invoice', 'dashicons-admin-users');


add_submenu_page(
    'invoice',       // parent slug
    'Invoice Setting',    // page title
    'Invoice Setting',             // menu title
    'manage_options',           // capability
    'invoice_setting', // slug
    'get_mamurjor_invoice_setting_info' // callback
);

if(!function_exists('get_mamurjor_invoice_setting_info')){
	function get_mamurjor_invoice_setting_info(){
		 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
  if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'mamurjor_thme_option_messages', 'mamurjor_thme_option_message', __( 'Settings Saved', 'invoice_setting' ), 'updated' );
 }
 // show error/update messages
 settings_errors( 'mamurjor_thme_option_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "mamurjor_thme_option"
 settings_fields( 'invoice_setting' );
 
 // output setting sections and their fields
 // (sections are registered for "mamurjor_thme_option", each field is registered to a specific section)
 do_settings_sections( 'invoice_setting' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
		
	}
}

}
}

/**
 * custom option and settings
 */
function mamurjor_invoice_settings_init() {
 // register a new setting for "wporg" page
 register_setting( 'invoice_setting', 'mamurjor_institute_name' );
 register_setting( 'invoice_setting', 'mamurjor_institute_info' );
 register_setting( 'invoice_setting', 'shippingcharge');
 register_setting( 'invoice_setting', 'discount_mamurjor');
 register_setting( 'invoice_setting', 'discount_mamurjor');
 
 
 // register a new section in the "wporg" page
 add_settings_section(
 'wporg_section_developerdds_id',
 __( 'Mamurjor Invoice Setting.', 'mamurjor_invoice' ),
 'mamurjor_invoice_section_developers_cb',
 'invoice_setting'
 );
 
 // register a new field in the "wporg_section_developers" section, inside the "wporg" page
 add_settings_field(
 'invoice', // as of WP 4.6 this value is used only internally
 // use $args' label_for to populate the id inside the callback
 '',
 'mamurjor_invoice_setting_field_pill_cb',
 'invoice_setting',
 'wporg_section_developerdds_id'
 );
}
 
/**
 * register our wporg_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'mamurjor_invoice_settings_init' );

if(!function_exists('mamurjor_invoice_section_developers_cb')){
	function mamurjor_invoice_section_developers_cb(){
		?>
		
		
		
		<?php
	}
}

if(!function_exists('mamurjor_invoice_setting_field_pill_cb')){
	function mamurjor_invoice_setting_field_pill_cb($args){
		$mamurjor_institute_name = get_option( 'mamurjor_institute_name' );
		$mamurjor_institute_info = get_option( 'mamurjor_institute_info' );
		$discount_mamurjor = get_option( 'discount_mamurjor' );
			$shippingcharge = get_option( 'shippingcharge' );

		
		?>
			
		
		 <div class="form-group">
			  <label class="control-label col-sm-2" for="email"> <?php esc_html_e( 'Enter institute name', 'mamurjor_invoice' ); ?></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mamurjor_institute_name" value="<?php echo isset( $mamurjor_institute_name ) ? esc_attr( $mamurjor_institute_name ) : ''; ?>">
					</div>
		</div>
		 <div class="form-group">
			  <label class="control-label col-sm-2" for="email"> <?php esc_html_e( 'Enter institute info', 'mamurjor_invoice' ); ?></label>
					<div class="col-sm-10">
					
					<textarea class="form-control" aria-label="With textarea" name="mamurjor_institute_info"><?php echo isset( $mamurjor_institute_info ) ? esc_attr( $mamurjor_institute_info ) : ''; ?></textarea>
					</div>
		</div>
		
		
		<div class="form-group">
			  <label class="control-label col-sm-6" for="discount_mamurjor"> <?php esc_html_e( 'Show Discount Field', 'mamurjor_invoice' ); ?></label>
					<div class="col-sm-10">
					
					<?php
					
					if($discount_mamurjor=="yes"){
						esc_html_e( 'Enable', 'mamurjor_invoice' );
						
						?>
						<input type="checkbox" name="discount_mamurjor"  value="no">
						
						<?php
						
						
					}
					else{
						esc_html_e( 'Disable', 'mamurjor_invoice' );
						?>
						<input type="checkbox" name="discount_mamurjor"  value="yes">
						<?php
					}
					
					
					?>
					
					</div>
		</div>
		
		
		<div class="form-group">
			  <label class="control-label col-sm-6" for="shippingcharge"> <?php esc_html_e( 'Show Shipping Charge Field', 'mamurjor_invoice' ); ?></label>
					<div class="col-sm-10">
					
					<?php
				
					if($shippingcharge=="yes"){
						esc_html_e( 'Enable', 'mamurjor_invoice' );
						?>
						<input type="checkbox" name="shippingcharge"  value="no">
						<?php
						
						
					}
					else{
						esc_html_e( 'Disable', 'mamurjor_invoice' );
						?>
						<input type="checkbox" name="shippingcharge"  value="yes">
						<?php
						
					}
					
					
					?>
					
					</div>
		</div>
		
		
		
		
		<?php
	}
}


if(!function_exists('mamurjor_invoice')){
function mamurjor_invoice() {
	
	  global $wpdb;
  $mamurjor_invoice_table_name = $wpdb->prefix.'mamurjor_invoice';
  $mamurjor_invoice_details_table_name = $wpdb->prefix.'mamurjor_invoice_details';

    if (isset($_POST['mamurjorinvoicesubmit'])) {
   $billedto = sanitize_text_field($_POST['billedto']);
   $shippedto = sanitize_text_field($_POST['shippedto']);
   $paymenttype = sanitize_text_field($_POST['paymenttype']);
   $orderdate = sanitize_text_field($_POST['orderdate']);
   $ordderid  = sanitize_text_field($_POST['ordderid']);
   
   $total = 0;

   $discount = sanitize_text_field($_POST['discount']);
     $shippingcharge = sanitize_text_field($_POST['shippingcharge']);
   $grandTotal = 0;
   

   


$item = array_map( 'sanitize_text_field', $_POST['item'] );

$price = array_map( 'sanitize_text_field', $_POST['price'] );

$quantity = array_map( 'sanitize_text_field', $_POST['quantity'] );
   
   //$item = $_POST['item'];
   //$price =$_POST['price']; 
   //$quantity =$_POST['quantity'];
	$qtytotal=0;
  for($i=0;$i<count($item);$i++){
	  $query= "INSERT INTO $mamurjor_invoice_table_name(item,price,qty,orderid) VALUES('$item[$i]','$price[$i]','$quantity[$i]','$ordderid')";
	  $wpdb->query($query);
     $qtytotal+=$quantity[$i]; 
     $total+=number_format($price[$i])*number_format($quantity[$i]); 
  }
    $query_details= "INSERT INTO $mamurjor_invoice_details_table_name(billedto,shippedto,paymenttype,orderdate,ordderid,total,discount,shippingcharge,grandTotal,totalqty) 
	VALUES('$billedto','$shippedto','$paymenttype','$orderdate','$ordderid','$total','$discount','$shippingcharge','$grandTotal','$qtytotal')";
	$wpdb->query($query_details);
	
    echo "<script>location.replace('admin.php?page=report');</script>";
    
  }
	
	
	
	
	
?>


<form  action="" method="post">
    <div class="container">
	
        <div class="row">
            <div class="col-xs-10 col-md-10">
                <div>
                    <h2 class="text-center"><?php esc_html_e('Invoice', 'mamurjor_invoice' )?>	</h2>
                </div>
            </div>
            <div class="col-xs-12 col-md-10">
                <hr>
                <div class="row">
				
                    <div class="col-xs-5 col-md-5">
                        <address>
                            <strong><?php esc_html_e('Billed To:', 'mamurjor_invoice' )?></strong><br>
                            <input type="text" class="form-control" name="billedto">
                        </address>
                    </div>
                    <div class="col-xs-5 col-md-5 ">
                        <address>
                            <strong><?php esc_html_e('Shipped To:', 'mamurjor_invoice' )?></strong><br>
                           <input type="text" class="form-control" name="shippedto">
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs- col-md-5">
                        <address>
                            <strong><?php esc_html_e('Payment Method:', 'mamurjor_invoice' )?></strong><br>
                            <input type="text" class="form-control" name="paymenttype">
                        </address>
                    </div>
                    <div class="col-xs-5 col-md-5">
                        <address>
                            <strong><?php esc_html_e('Order Date:', 'mamurjor_invoice' )?></strong><br>
                            <input type="date"  class="form-control" name="orderdate">
                            <?php esc_html_e('Order No:', 'mamurjor_invoice' )?> <br/>
							<strong> <input type="text" readonly value="<?php esc_html_e(time(), 'mamurjor_invoice' )?>" class="form-control" name="ordderid"> </strong>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="table-responsive">
				
                    <table class="table table-bordered">
				
                        <thead>
						 
                            <tr class="item-row">
                                <th><?php esc_html_e('Item', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Price', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Quantity', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Total', 'mamurjor_invoice' )?></th>
                            </tr>
                        </thead>
                        <tbody>
						
                        <tr id="hiderow">
                            <td colspan="4">
                                <a id="addRow" href="javascript:;" title="Add a row" class="btn btn-primary"><?php esc_html_e('Add a row', 'mamurjor_invoice' )?></a>
                            </td>
                        </tr>
                     
                        <tr>
                            <td><strong><?php esc_html_e('Total Quantity:', 'mamurjor_invoice' )?> </strong><span id="totalQty" style="color: red; font-weight: bold"> <?php esc_html_e('0', 'mamurjor_invoice' )?></span> </td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Sub Total', 'mamurjor_invoice' )?></strong></td>
                            <td><span id="subtotal"><?php esc_html_e('0.00', 'mamurjor_invoice' )?> </span></td>
                        </tr>
                        
                            
							
							
							<?php
					$discount_mamurjor = get_option( 'discount_mamurjor' );
					if($discount_mamurjor=="yes"){
						?>
						<tr>
						<td></td>
                            <td></td>
						<td class="text-right"><strong><?php esc_html_e('Discount', 'mamurjor_invoice' )?></strong></td>
                            <td><input class="form-control" id="discount" name="discount" value="0" type="text"></td>
                         </tr>
						<?php 				
						
					}
					else{
						?>
						<input type="hidden" class="form-control" id="discount" name="discount" value="0" type="text">
						
						<?php
					}
					
					
					?>
                            
					 
						
						<?php
					$shippingcharge = get_option( 'shippingcharge' );
					if($shippingcharge=="yes"){
						?>
						 <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Shipping', 'mamurjor_invoice' )?></strong></td>
                            <td><input class="form-control" id="shipping" name="shippingcharge" value="0" type="text"></td>
                        </tr>
						<?php 				
						
					}
					else{
						?>
						<input type="hidden" class="form-control" id="shipping" name="shippingcharge" value="0" type="text">
						<?php
					}
					
					
					?>
                       
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Grand Total', 'mamurjor_invoice' )?></strong></td>
                            <td><span id="grandTotal"><?php esc_html_e('0', 'mamurjor_invoice' )?></span></td>
                            
                        </tr>
						  <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"></td>
                            <td><span id="grandTotal"> <input type="submit" class="btn btn-primary"  value="Create Invoice" name="mamurjorinvoicesubmit"/></span></td>
                            
                        </tr>
						
                        </tbody>
						
                    </table>
					
                </div>
            </div>
        </div>
		
    </div>
  </form>
    <script src=""></script>
    <script src=""></script>
    <script>
        jQuery(document).ready(function(){
            jQuery().invoice({
                addRow : "#addRow",
                delete : ".delete",
                parentClass : ".item-row",

                price : ".price",
                qty : ".qty",
                total : ".total",
                totalQty: "#totalQty",

                subtotal : "#subtotal",
                discount: "#discount",
                shipping : "#shipping",
                grandTotal : "#grandTotal"
            });
        });
    </script>
</body>


</html>
<?php

}
}

if(!function_exists('mamurjor_report')){
function mamurjor_report($newVar) {
	
		global $wpdb;
        $mamurjor_invoice_details= $wpdb->prefix.'mamurjor_invoice_details';

          $mamurjor_details = $wpdb->get_results("SELECT * FROM $mamurjor_invoice_details ORDER BY id DESC LIMIT 1");
		  $serial=0;
          foreach ($mamurjor_details as $print_details) {
	
	?>
	<div class="container" >
	<div id="printableArea">
	
        <div class="row">
            <div class="col-xs-10 col-md-10">
                <div>
                    <h2 class="text-center"><?php esc_html_e('Invoice', 'mamurjor_invoice' )?>	</h2>
                    <h4 class="text-center"><?php 
					$mamurjor_institute_name = get_option( 'mamurjor_institute_name' );
					if($mamurjor_institute_name!=""){
						echo esc_html($mamurjor_institute_name);
					}
					else{
						echo esc_html('Mamurjor IT Institute');
					}

					?>	</h4>
					
                    <h5 class="text-center">
					<?php 
					$mamurjor_institute_info = get_option( 'mamurjor_institute_info' );
				
					if($mamurjor_institute_info!=""){
						echo esc_html($mamurjor_institute_info);
					}
					else{
						echo esc_html('Mirpur#10,Dhaka.01746686868');
					}
					
					
					?>	
					</h5>
                </div>
            </div>
            <div class="col-xs-12 col-md-10">
                <hr>
                <div class="row">
				
                    <div class="col-xs-5 col-md-5">
                        <address>
                            <strong><?php esc_html_e('Billed To:', 'mamurjor_invoice' )?></strong><br>
                            <?php esc_html_e($print_details->billedto, 'mamurjor_invoice' )?>
                        </address>
                    </div>
                    <div class="col-xs-5 col-md-5 ">
                        <address>
                            <strong><?php esc_html_e('Shipped To:', 'mamurjor_invoice' )?></strong><br>
                           <?php esc_html_e($print_details->shippedto, 'mamurjor_invoice' )?>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs- col-md-5">
                        <address>
                            <strong><?php esc_html_e('Payment Method:', 'mamurjor_invoice' )?></strong><br>
                            <?php esc_html_e($print_details->paymenttype, 'mamurjor_invoice' )?>
                        </address>
                    </div>
                    <div class="col-xs-5 col-md-5">
                        <address>
                            <strong><?php esc_html_e('Order Date:', 'mamurjor_invoice' )?></strong><br>
                            <?php esc_html_e($print_details->orderdate, 'mamurjor_invoice' )?>  <br/>
                            <?php esc_html_e('Order No:', 'mamurjor_invoice' )?> <br/>
							<strong> <?php esc_html_e($print_details->ordderid, 'mamurjor_invoice' )?> </strong>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="table-responsive">
				
                    <table class="table table-bordered">
				
                        <thead>
						 
                            <tr class="item-row">
                                <th><?php esc_html_e('Sl.No', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Item', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Price', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Quantity', 'mamurjor_invoice' )?></th>
                                <th><?php esc_html_e('Total', 'mamurjor_invoice' )?></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
						
						global $wpdb;
        $mamurjor_invoice_table= $wpdb->prefix.'mamurjor_invoice';

          $mamurjor_details_invoice = $wpdb->get_results("SELECT * FROM $mamurjor_invoice_table where orderid='$print_details->ordderid'");
		 
		 $serialno=0;
		 $subtotal=0;
		 $grandTotal=0;
          foreach ($mamurjor_details_invoice as $print_details_invoice) {
					$subtotal +=$print_details_invoice->qty*$print_details_invoice->price;
					$grandTotal += $subtotal;
						?>
                        
                   <tr class="item-row">
				   <td><?php esc_html_e($serialno+=1, 'mamurjor_invoice' )?></td>
				   <td><?php esc_html_e($print_details_invoice->item, 'mamurjor_invoice' )?></td>
				   <td><?php esc_html_e($print_details_invoice->price, 'mamurjor_invoice' )?></td>
				   <td><?php esc_html_e($print_details_invoice->qty, 'mamurjor_invoice' )?></td>
				   <td><span class="total"><?php esc_html_e($print_details_invoice->qty*$print_details_invoice->price, 'mamurjor_invoice' )?></span>
				   </td></tr>
                          
		  <?php
		  }
		  ?>
                     
                        <tr>
                            <td><strong><?php esc_html_e('Total Quantity:', 'mamurjor_invoice' )?> </strong><span id="totalQty" style="color: red; font-weight: bold"> <?php esc_html_e($print_details->totalqty, 'mamurjor_invoice' )?></span></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Sub Total', 'mamurjor_invoice' )?></strong></td>
                            <td><span id="subtotal"><?php esc_html_e($subtotal, 'mamurjor_invoice' )?>  </span></td>
                        </tr>
                       
                        <?php
					$discount_mamurjor = get_option( 'discount_mamurjor' );
					
					if($discount_mamurjor=="yes"){
						?>
						 <tr>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Discount', 'mamurjor_invoice' )?></strong></td>
                            <td><?php esc_html_e($print_details->discount, 'mamurjor_invoice' )?></td>
                        </tr>
						<?php 				
						
					}
					else{
						?>
						<input type="hidden" class="form-control" id="shipping" name="shippingcharge" value="0" type="text">
						<?php
					}
					
					
					?>
						
						
						<?php
					$shippingcharge = get_option( 'shippingcharge' );
					if($shippingcharge=="yes"){
						?>
						<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Shipping', 'mamurjor_invoice' )?></strong></td>
                            <td><?php esc_html_e($print_details->shippingcharge, 'mamurjor_invoice' )?></td>
                        </tr>
						<?php 				
						
					}
					else{
						?>
						<input type="hidden" class="form-control" id="shipping" name="shippingcharge" value="0" type="text">
						<?php
					}
					
					
					?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php esc_html_e('Grand Total', 'mamurjor_invoice' )?></strong></td>
                            <td><span id="grandTotal"><?php esc_html_e(($grandTotal+$print_details->shippingcharge)-$print_details->discount, 'mamurjor_invoice' )?></span></td>
                            
                        </tr>
						  <tr>
                            <td><?php esc_html_e('Authority Signature', 'mamurjor_invoice' )?></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"></td>
                            <td><span id="grandTotal"> </span></td>
                            
                        </tr>
						
                        </tbody>
						
                    </table>
					
                </div>
            </div>
        </div>
        </div>
		<input id="grandTotal" type="button" class="btn btn-primary" onclick="printDiv('printableArea')"  value="Invoice Print" name="mamurjorinvoicesubmit"/>
    </div>
	
	<?php 
	
}
}
}


?>
<script>
function printDiv(divName) {
     
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	
}
</script>
