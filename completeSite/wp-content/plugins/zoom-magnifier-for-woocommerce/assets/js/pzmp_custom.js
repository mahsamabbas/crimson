jQuery.noConflict();
jQuery(document).ready(function(){

	if (jQuery('input#pzmp_plugin_mobile_enable').is(':checked')) {
		jQuery('#pzmp_box_pos').val('inside');
		jQuery('#right_option').hide();
	}else{
		jQuery('#right_option').show();
	}
	
});
jQuery(document).on('click','#pzmp_reset_value',pzmp_reset_all);
	
	function pzmp_reset_all(){

		jQuery('#pzmp_plugin_enable').prop('checked', true);
		
		jQuery('#pzmp_plugin_mobile_enable').prop('checked', false);

		jQuery('#pzmp_box_width').val('auto');

		jQuery('#pzmp_box_height').val('auto');

		jQuery('#pzmp_box_pos').val('right');

	}

jQuery(document).on('click','#pzmp_plugin_mobile_enable',pzmp_activate_mobile);
function pzmp_activate_mobile(){
	
	if (jQuery('input#pzmp_plugin_mobile_enable').is(':checked')) {
		jQuery('#pzmp_box_pos').val('inside');
		jQuery('#right_option').hide();
	}else{
		jQuery('#right_option').show();
	}
}