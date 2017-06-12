/* global woocommerce_copy_billing_address */
jQuery( document ).ready( function( $ ) {

	// woocommerce_copy_billing_address is required to continue, ensure the object exists
	if ( typeof woocommerce_copy_billing_address === 'undefined' ) {
		return false;
	}

	var wc_copy_billing_address = {
		$checkout_form: $( 'form.checkout' ),
		init: function() {
			this.init_icon();
			this.init_tiptip();

			// Copy from billing.
			$( document.body ).on( 'click', 'a.billing-same-as-shipping', this.copy_billing_to_shipping );

			// Checkout form events.
			this.$checkout_form.on( 'change', '#ship-to-different-address input', this.toggle_copy_billing_address );
			this.$checkout_form.find( '#ship-to-different-address input' ).change();
		},
		init_icon: function() {
			$( '#ship-to-different-address' ).append( '<a href="#" class="tips billing-same-as-shipping" data-tip="' + woocommerce_copy_billing_address.copy_title + '"></a>' );
		},
		init_tiptip: function() {
			$( '#tiptip_holder' ).removeAttr( 'style' );
			$( '#tiptip_arrow' ).removeAttr( 'style' );
			$( '.tips' ).tipTip({ 'attribute': 'data-tip', 'fadeIn': 50, 'fadeOut': 50, 'delay': 200 });
		},
		copy_billing_to_shipping: function() {
			if ( window.confirm( woocommerce_copy_billing_address.copy_billing ) ) {
				$( '.woocommerce-checkout :input[name^="billing_"]' ).each( function() {
					var input_name = $( this ).attr( 'name' );
					input_name     = input_name.replace( 'billing_', 'shipping_' );
					$( ':input#' + input_name ).val( $( this ).val() ).change();
				});
			}
			return false;
		},
		toggle_copy_billing_address: function() {
			$( 'a.billing-same-as-shipping' ).hide();

			if ( $( this ).is( ':checked' ) ) {
				$( 'a.billing-same-as-shipping' ).show();
			}
		}
	};

	wc_copy_billing_address.init();
});
