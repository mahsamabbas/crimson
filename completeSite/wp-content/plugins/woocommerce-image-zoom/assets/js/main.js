(function($) { 
  'use strict';

	/**
	 * Active the Zoom
	 */
	
	$('#wpb_wiz_img_id').elevateZoom({
		zoomType: "inner",
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750,
scrollZoom : true,
		gallery:'wpb_wiz_gallery',
		galleryActiveClass: 'wpb-wiz-active', 
	});

	/**
	 * Change image on gallery image click
	 */
	
	$("#wpb_wiz_img_id").bind("click", function(e) { 
		var ez = $('#wpb_wiz_img_id').data('elevateZoom');	
		$.fancybox(ez.getGalleryList()); 
		return false; 
	});

	/**
	 * Remove srcset & size attr
	 */
	
	$("#wpb_wiz_gallery a").on("click", function(){ 
		$('.single-product .images > a img').removeAttr('srcset');
		$('.single-product .images > a img').removeAttr('sizes');
	});
	
})(jQuery);
