<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$plugin_dir_url =  plugin_dir_url( __FILE__ );
?>
<style>
.premium-box{ width:100%; height:auto; background:#fff;  }
.premium-features{}
.premium-heading{  color: #484747;font-size: 40px;padding-top: 35px;text-align: center;text-transform: uppercase;}
.premium-features li{ width:100%; float:left;  padding: 80px 0; margin: 0; }
.premium-features li .detail{ width:50%; }
.premium-features li .img-box{ width:50%; }

.premium-features li:nth-child(odd) { background:#f4f4f9; }
.premium-features li:nth-child(odd) .detail{float:right; text-align:left; }
.premium-features li:nth-child(odd) .detail .inner-detail{}
.premium-features li:nth-child(odd) .detail p{ }
.premium-features li:nth-child(odd) .img-box{ float:left; text-align:right;}

.premium-features li:nth-child(even){  }
.premium-features li:nth-child(even) .detail{ float:left; text-align:right;}
.premium-features li:nth-child(even) .detail .inner-detail{ margin-right: 46px;}
.premium-features li:nth-child(even) .detail p{ float:right;} 
.premium-features li:nth-child(even) .img-box{ float:right;}

.premium-features .detail{}
.premium-features .detail h2{ color: #484747;  font-size: 24px; font-weight: 700; padding: 0;}
.premium-features .detail p{  color: #484747;  font-size: 13px;  max-width: 327px;}
/**images**/
.pincode-check{ background:url(<?php echo $plugin_dir_url; ?>images/deselect_zoom_for_individual_products.png); width:525px; height:204px; display:inline-block; margin-right: 25px; margin-top: 25px; background-repeat:no-repeat;}

.sat-sun-off{ background:url(<?php echo $plugin_dir_url; ?>images/deselect_zoom_for_entire_category.png); width:520px; height:78px; display:inline-block; background-size:500px auto; margin-right:30px; margin-top: 20px; background-repeat:no-repeat;}

.bulk-upload{ background:url(<?php echo $plugin_dir_url; ?>images/activate_zoom_on_smartphones.png); width:388px; height:89px; display:inline-block; margin-top: 25px; background-repeat:no-repeat;}

.cod-verify{background:url(<?php echo $plugin_dir_url; ?>images/set_zoom_box_dimensions.png); width:566px; height:96px; display:inline-block; margin-right:30px; margin-top: 20px; background-repeat:no-repeat;}

.delivery-date{background:url(<?php echo $plugin_dir_url; ?>images/set_zoom_box_position.png); width:624px; height:79px; display:inline-block;margin-top:5px; background-repeat:no-repeat;}



/*upgrade css*/

.upgrade{background:#f4f4f9;padding: 50px 0; width:100%; clear: both;}
.upgrade .upgrade-box{ background-color: #808a97;
    color: #fff;
    margin: 0 auto;
   min-height: 110px;
    position: relative;
    width: 60%;}

.upgrade .upgrade-box p{ font-size: 15px;
     padding: 19px 20px;
    text-align: center;}

.upgrade .upgrade-box a{background: none repeat scroll 0 0 #6cab3d;
    border-color: #ff643f;
    color: #fff;
    display: inline-block;
    font-size: 17px;
    left: 50%;
    margin-left: -150px;
    outline: medium none;
    padding: 11px 6px;
    position: absolute;
    text-align: center;
    text-decoration: none;
    top: 36%;
    width: 277px;}

.upgrade .upgrade-box a:hover{background: none repeat scroll 0 0 #72b93c;}

.premium-vr{ text-transform:capitalize;}
.premium-box-head {
    background: #eae8e7 none repeat scroll 0 0;
    height: 500px;
    text-align: center;
    width: 100%;
}
.pho-upgrade-btn a {
    display: inline-block;
    margin-top: 75px;
}
.main-heading {
    background: #fff none repeat scroll 0 0;
    margin-bottom: -70px;
    text-align: center;
}
.main-heading img {
    margin-top: -200px;
}
.premium-box-container {
    margin: 0 auto;
}
.premium-box-container .description:nth-child(2n+1) {
    background: #fff none repeat scroll 0 0;
}
.main-heading h1{ margin: 0px;}
.premium-box {
    background: none;
    height: auto;
    width: 100%;
}

.premium-box-container .description {
    display: block;
    padding: 35px 0;
    text-align: center;
}
.premium-box-container .pho-desc-head::after {
    background:url(<?php echo $plugin_dir_url; ?>images/head-arrow.png) no-repeat;
    content: "";
    height: 98px;
    position: absolute;
    right: -40px;
    top: -6px;
    width: 69px;
}
.premium-box-container .pho-desc-head {
    margin: 0 auto;
    position: relative;
    width: 768px;
}
.pho-plugin-content {
    margin: 0 auto;
    overflow: hidden;
    width: 768px;
}
.pho-plugin-content img {
    max-width: 100%;
    width: auto;
}

.premium-box-container .pho-desc-head h2{ line-height:38px;}

.premium-box-container .pho-desc-head h2 {
    color: #02c277;
    font-size: 28px;
    font-weight: bolder;
    margin: 0;
    text-transform: capitalize;
}
.pho-plugin-content p {
    color: #212121;
    font-size: 18px;
    line-height: 32px;
}
.premium-box-container .description:nth-child(2n+1) .pho-img-bg {
    background: #f1f1f1 url(<?php echo $plugin_dir_url; ?>images/image-frame-odd.png) no-repeat 100% top;
}
.description .pho-plugin-content .pho-img-bg {
    border-radius: 5px 5px 0 0;
    height: auto;
    margin: 0 auto;
    padding: 70px 0 40px;
    width: 750px;
}
.pho-upgrade-btn {
    text-align: center;
}
.premium-box-container .description:nth-child(2n) {
    background: #eae8e7 none repeat scroll 0 0;
}
.premium-box-container .description:nth-child(2n) .pho-img-bg {
    background: #f1f1f1 url(<?php echo $plugin_dir_url; ?>images/image-frame-even.png) no-repeat 100% top;
}
.premium-box-container .description:nth-child(2n+1) .pho-img-bg {
    background: #f1f1f1 url(<?php echo $plugin_dir_url; ?>images/image-frame-odd.png") no-repeat scroll 100% top;
} 

</style>

<div class="premium-box">

	<div class="premium-box-head">
           <div class="pho-upgrade-btn">
           <a target="_blank" href="http://www.phoeniixx.com/product/zoom-magnifier-for-woocommerce/?utm_source=Wordpress.org&utm_medium=CPC&utm_campaign=Wordpress.org/"><img src="<?php echo $plugin_dir_url; ?>images/premium-btn.png" /></a>
           </div>
           </div>
            <div class="main-heading">
           <h1> <img src="<?php echo $plugin_dir_url; ?>images/premium-head.png" />
           
          </h1>
           </div>
           <div class="premium-box-container">
           <div class="description">
                <div class="pho-desc-head">
                <h2>Deselect Zoom For Individual Products</h2></div>
                
                    <div class="pho-plugin-content">
                        <p>
                           Zoom Magnifier Plugin gives you the choice to deselect &#39;zoom&#39; option if in case, you don&#39;t want to give it on any individual product. 
                        </p>
                        <div class="pho-img-bg">
                        <img src="<?php echo $plugin_dir_url; ?>images/deselect_zoom_for_individual_products.png" />
                        </div>
                    </div>
            </div> <!-- description end -->
            <div class="description">
                <div class="pho-desc-head">
                <h2>Deselect Zoom For Entire Category</h2></div>
                
                    <div class="pho-plugin-content">
                         <p>
                         You could also deselect &#39;Zoom&#39; option, for an entire category of product, if you wish to.
                        </p>
                        <div class="pho-img-bg">
                        <img src="<?php echo $plugin_dir_url; ?>images/deselect_zoom_for_entire_category.png" />
                        </div>
                    </div>
            </div> <!-- description end -->
             <div class="description">
                <div class="pho-desc-head">
                <h2>Activate zoom on Smartphones</h2></div>
                
                    <div class="pho-plugin-content">
                         <p>
                           If most of your customers use smartphones to browse through your products, you would want them to have the choice to &#39;zoom&#39; products on their phones. The plugin allows you to activate &#39;zoom&#39; option on mobile phones as well.
                        </p>
                        <div class="pho-img-bg">
                        <img src="<?php echo $plugin_dir_url; ?>images/activate_zoom_on_smartphones.png" />
                        </div>
                    </div>
            </div> <!-- description end -->
            <div class="description">
                <div class="pho-desc-head">
                <h2>Set Zoom Box Dimensions</h2></div>
                
                    <div class="pho-plugin-content">
                         <p>
                          You could set the width and height of &#39;Zoom Box&#39;, as per your requirement.
                        </p>
                        <div class="pho-img-bg">
                        <img src="<?php echo $plugin_dir_url; ?>images/set_zoom_box_dimensions.png" />
                        </div>
                    </div>
            </div> <!-- description end -->
            <div class="description">
                <div class="pho-desc-head">
                <h2>Set Zoom Box Position</h2></div>
                
                    <div class="pho-plugin-content">
                         <p>
                           The position of Zoom Box could also be set by you either as &#39;Inside&#39; or as &#39;Right&#39;.
                        </p>
                        <div class="pho-img-bg">
                        <img src="<?php echo $plugin_dir_url; ?>images/set_zoom_box_position.png" />
                        </div>
                    </div>
            </div> <!-- description end -->
            </div></div>

<div class="pho-upgrade-btn">
        <a target="_blank" href="http://www.phoeniixx.com/product/zoom-magnifier-for-woocommerce/?utm_source=Wordpress.org&utm_medium=CPC&utm_campaign=Wordpress.org/"><img src="<?php echo $plugin_dir_url; ?>images/premium-btn.png" /></a>
        </div>
</div>