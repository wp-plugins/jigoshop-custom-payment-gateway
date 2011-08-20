<?php
/*
Plugin Name: Jigoshop Custom Payment Gateway
Plugin URI: http://wordpress.org/extend/plugins/jigoshop-custom-payment-gateway
Description: This plugin extends the Jigoshop payment gateways to add in a custom gateway for tgm_custom_gateway use. You can use this in place of the test "Cheque" for client billing accounts or other non-traditional forms of payment.
Version: 1.0.1
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
*/


/*  Copyright 2011  Thomas Griffin  (email : thomas@thomasgriffinmedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
*/


/* Add a custom payment class to Jigoshop
------------------------------------------------------------ */

add_action( 'plugins_loaded', 'tgm_jigoshop_custom_payment_gateway', 0 );
function tgm_jigoshop_custom_payment_gateway() {
	
	if ( !class_exists( 'jigoshop_payment_gateway' ) ) return; // if the Jigoshop payment gateway class is not available, do nothing
	
		class jigoshop_tgm_custom_gateway extends jigoshop_payment_gateway {
		
		public function __construct() { 
        	$this->id				= 'tgm_custom_gateway';
        	$this->icon 			= apply_filters( 'tgm_jigoshop_custom_icon', '' );
        	$this->has_fields 		= false;
		
			$this->enabled			= get_option( 'jigoshop_tgm_custom_gateway_enabled' );
			$this->title 			= get_option( 'jigoshop_tgm_custom_gateway_title' );
			$this->description 		= get_option( 'jigoshop_tgm_custom_gateway_description' );

			add_action( 'jigoshop_update_options', array( &$this, 'process_admin_options' ) );
			add_option( 'jigoshop_tgm_custom_gateway_enabled', 'no' );
			add_option( 'jigoshop_tgm_custom_gateway_title', '' );
			add_option( 'jigoshop_tgm_custom_gateway_description', '' );
    
    		add_action( 'thankyou_tgm_custom_gateway', array( &$this, 'thankyou_page' ) );
    	} 
    
    
		/* Construct our function to output and display our gateway
		------------------------------------------------------------ */
		
		public function admin_options() {
    		?>
    		<thead><tr><th scope="col" width="200px"><?php echo apply_filters( 'tgm_jigoshop_custom_gateway_title', 'Client Payments' ); ?></th><th scope="col" class="desc"><?php echo apply_filters( 'tgm_jigoshop_custom_gateway_description', 'This payment gateway is setup specifically for client billing accounts. Orders will be processed and billed directly to existing client accounts.' ); ?></th></tr></thead>
    		<tr>
	        	<td class="titledesc"><?php echo apply_filters( 'tgm_jigoshop_enable_custom_gateway_title', 'Enable Client Payments?' ) ?>:</td>
	        		<td class="forminp">
		        		<select name="jigoshop_tgm_custom_gateway_enabled" id="jigoshop_tgm_custom_gateway_enabled" style="min-width:100px;">
		            		<option value="yes" <?php if ( get_option( 'jigoshop_tgm_custom_gateway_enabled' ) == 'yes' ) echo 'selected="selected"'; ?>><?php _e( 'Yes', 'jigoshop' ); ?></option>
		            		<option value="no" <?php if ( get_option( 'jigoshop_tgm_custom_gateway_enabled' ) == 'no' ) echo 'selected="selected"'; ?>><?php _e( 'No', 'jigoshop' ); ?></option>
		        		</select>
	        		</td>
	    	</tr>
	    	<tr>
	        	<td class="titledesc"><a href="#" tip="<?php echo apply_filters( 'tgm_jigoshop_method_tooltip_description', 'This controls the title which the user sees during checkout.' ); ?>" class="tips" tabindex="99"></a><?php echo apply_filters( 'tgm_jigoshop_method_tooltip_title', 'Method Title' ) ?>:</td>
	        		<td class="forminp">
		        		<input class="input-text" type="text" name="jigoshop_tgm_custom_gateway_title" id="jigoshop_tgm_custom_gateway_title" value="<?php if ( $value = get_option( 'jigoshop_tgm_custom_gateway_title' ) ) echo $value; else echo 'Client Payments'; ?>" />
	        		</td>
	    	</tr>
	    	<tr>
	        	<td class="titledesc"><a href="#" tip="<?php echo apply_filters( 'tgm_jigoshop_message_tooltip_description', 'This message lets the customer know that the order and total will be processed to their billing account.' ); ?>" class="tips" tabindex="99"></a><?php echo apply_filters( 'tgm_jigoshop_message_tooltip_title', 'Customer Message' ) ?>:</td>
	        		<td class="forminp">
		        		<input class="input-text wide-input" type="text" name="jigoshop_tgm_custom_gateway_description" id="jigoshop_tgm_custom_gateway_description" value="<?php if ( $value = get_option( 'jigoshop_tgm_custom_gateway_description' ) ) echo $value; ?>" />
	        		</td>
	    	</tr>

    		<?php
    	}
    	
    
		/* Display description for payment fields and thank you page
		------------------------------------------------------------ */
		
		function payment_fields() {
			if ( $this->description ) echo wpautop( wptexturize( $this->description ) );
			do_action( 'tgm_jigoshop_payment_fields' ); // allow for insertion of custom code if needed
		}
	
		function thankyou_page() {
			if ( $this->description ) echo wpautop( wptexturize( $this->description ) );
			do_action( 'tgm_jigoshop_thankyou_page' ); // allow for insertion of custom code if needed
		}
		
    
		/* Update options in the database upon save
		------------------------------------------------------------ */
		
    	public function process_admin_options() {
   			if( isset( $_POST['jigoshop_tgm_custom_gateway_enabled'] ) ) update_option( 'jigoshop_tgm_custom_gateway_enabled', jigowatt_clean( $_POST['jigoshop_tgm_custom_gateway_enabled'] ) ); else @delete_option( 'jigoshop_tgm_custom_gateway_enabled' );
   			if( isset( $_POST['jigoshop_tgm_custom_gateway_title'] ) ) update_option( 'jigoshop_tgm_custom_gateway_title', jigowatt_clean( $_POST['jigoshop_tgm_custom_gateway_title'] ) ); else @delete_option( 'jigoshop_tgm_custom_gateway_title' );
   			if( isset( $_POST['jigoshop_tgm_custom_gateway_description'] ) ) update_option( 'jigoshop_tgm_custom_gateway_description', 	jigowatt_clean( $_POST['jigoshop_tgm_custom_gateway_description'] ) ); else @delete_option( 'jigoshop_tgm_custom_gateway_description' );
    	}
    	
	
		/* Process order 
		------------------------------------------------------------ */
		
		function process_payment( $order_id ) {
		
			$order = &new jigoshop_order( $order_id );
		
			// By default, mark as processing, but can be filtered for any mark
			$order->update_status( apply_filters( 'tgm_jigoshop_order_update_status', __( 'processing', 'Your order is being processed. Thank you!' ) ) );
		
			// Remove cart
			jigoshop_cart::empty_cart();
			
			// Return thankyou redirect
			return array(
				'result' 	=> 'success',
				'redirect'	=> add_query_arg( 'key', $order->order_key, add_query_arg( 'order', $order_id, get_permalink( get_option( 'jigoshop_thanks_page_id' ) ) ) )
			);
		
		}
	
	}


	/* Add our new payment gateway to the Jigoshop gateways 
	------------------------------------------------------------ */
 
	add_filter( 'jigoshop_payment_gateways', 'add_tgm_custom_payment_gateway' );
	function add_tgm_custom_payment_gateway( $methods ) {
		$methods[] = 'jigoshop_tgm_custom_gateway'; return $methods;
	}
	
}