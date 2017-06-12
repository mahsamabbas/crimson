<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
function pzmp_settings(){
	if ( ! empty( $_POST ) && check_admin_referer( 'phoen_zoom_my_action', 'phoen_zoom_nonce_field' ) ) {
		
		if(isset($_POST['pzmp_genaral_setting'])){

			$pzmp_is_enable= sanitize_text_field( $_POST['pzmp_plugin_enable'] );
			$pzmp_is_enable_mob= sanitize_text_field( $_POST['pzmp_plugin_mobile_enable'] );
			$box_width= sanitize_text_field( $_POST['pzmp_box_width'] );
			$box_height= sanitize_text_field( $_POST['pzmp_box_height'] );
			$box_pos= sanitize_text_field( $_POST['pzmp_box_pos'] );
			
						
			$pzmp_genral_data=array('pzmp_is_enable'=>$pzmp_is_enable,'pzmp_is_enable_mob'=>$pzmp_is_enable_mob,
									'box_width'=>$box_width,'box_height'=>$box_height,'box_pos'=>$box_pos,
									);
			
					
			update_option('data_zoom_genral',$pzmp_genral_data);
			 
		}
	}
		
		$pzmp_genral_dataa=get_option('data_zoom_genral');
		
		if(!empty($pzmp_genral_dataa)){
			extract($pzmp_genral_dataa);
		}
		

$tab = sanitize_text_field( $_GET['tab'] );	


	?>
    <div id="profile-page" class="wrap">
	<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=pzmp-zoom-manager&amp;tab=general">General</a>
			
			<a class="nav-tab <?php if($tab == 'premium'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=pzmp-zoom-manager&amp;tab=premium">Premium</a>
	</h2>
	<?php
    
    $plugin_dir_url = plugin_dir_url(__FILE__);
    
	if($tab == 'general' || $tab == '')
	{
		
	?>	
<div class="meta-box-sortables" id="normal-sortables">
				<div class="postbox " id="pho_wcpc_box">
					<h3><span class="upgrade-setting">Upgrade to the PREMIUM VERSION</span></h3>
					<div class="inside">
						<div class="pho_check_pin">

							<div class="column two">
								<!----<h2>Get access to Pro Features</h2>----->
									<p>Switch to the premium version </p>

										<div class="pho-upgrade-btn">
										<a target="_blank" href="http://www.phoeniixx.com/product/zoom-magnifier-for-woocommerce/?utm_source=Wordpress.org&utm_medium=CPC&utm_campaign=Wordpress.org/"><img src="<?php echo $plugin_dir_url; ?>images/premium-btn.png" /></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div></div>
			
<form class="pzmp_genral" method="post">
 <?php wp_nonce_field( 'phoen_zoom_my_action', 'phoen_zoom_nonce_field' ); ?>
<h3>General Settings</h3>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="">
				<th scope="row" class="titledesc">Enable Zoom Magnifier Plugin</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<legend class="screen-reader-text"></legend>
						<label for="pzmp_plugin_enable">
							<input type="checkbox" name="pzmp_plugin_enable" id="pzmp_plugin_enable" <?php if(isset($pzmp_is_enable)){echo ($pzmp_is_enable==1)?'checked':'' ;}else{ echo 'checked';}?> value="1"> 
						</label> 
					</fieldset>
				</td>
			</tr>
			<tr valign="top" class="">
				<th scope="row" class="titledesc">Activate the plugin on mobile device</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<legend class="screen-reader-text"></legend>
						<label for="pzmp_plugin_mobile_enable">
							<input type="checkbox" name="pzmp_plugin_mobile_enable" id="pzmp_plugin_mobile_enable" <?php if(isset($pzmp_is_enable_mob)){echo ($pzmp_is_enable_mob==1)?'checked':'' ;}?>  value="1"> 
						</label> 
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="pzmp_box_width">Width Of Zoom Box  </label>
				</th>
				<td class="forminp forminp-select">
					<input type="text" name="pzmp_box_width" id="pzmp_box_width" style="" value="<?php if(isset($box_width)){echo ($box_width!='')?$box_width:'auto' ;}else{ echo 'auto';}?>" size="30"> in (px)											
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="pzmp_box_height">Height Of Zoom Box </label>
				</th>
				<td class="forminp forminp-select">
					<input type="text" name="pzmp_box_height" id="pzmp_box_height" style="" value="<?php if(isset($box_height)){echo ($box_height!='')?$box_height:'auto' ;}else{ echo 'auto';}?>" size="30"> in (px)											
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label for="pzmp_box_pos">Position Of Zoom Box </label>
				</th>
				<td class="forminp forminp-text">
					<select name="pzmp_box_pos" id="pzmp_box_pos"  style="width:300px;">
						<option id="right_option" <?php if(isset($box_pos)){echo ($box_pos=='right')?'selected':'' ;}else{ echo 'selected';}?> value="right">Right</option>
						<option <?php if(isset($box_pos)){echo ($box_pos=='inside')?'selected':'' ;}?> value="inside">Inside</option>
					</select><br>
				</td>
			</tr>
			
		</tbody>
	</table>
	<input type="button" style="float: left; margin-right: 10px;" class="button button-info" value="Reset" id="pzmp_reset_value" name="pzmp_reset_value">
	<input type="submit" style="float: left; margin-right: 10px;" name="pzmp_genaral_setting" class="button-primary" value="Save Changes">
</form>
	<style>
				.form-table th {
					width: 270px;
					padding: 25px;
				}
				.form-table td {
					
					padding: 20px 10px;
				}
				.form-table {
					background-color: #fff;
				}
			

				.px-multiply{ color:#ccc; vertical-align:bottom;}

				.long{ display:inline-block; vertical-align:middle; }

				.wid{ display:inline-block; vertical-align:middle;}

				.up{ display:block;}

				.grey{ color:#b0adad;}
#pho_wcpc_box.postbox h3{ padding:0 0 0 10px;}
	</style>
	
<?php 
	}
	
	if($tab == 'premium')
	{
		require_once('zomm_mag_premium.php');
	}
	
}
?>