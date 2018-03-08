<?php 
global $tmpl;
$tmpl->addScript('default', 'blocks/social/assets/js');
?>
<div id="social-hub" class="block-social box nopadding clearfix">	
    <div class="facebook" onclick="return fb_like();">
		<div class="icons"><img src="<?php echo URL_ROOT?>templates/default/images/facebook-icon.png" alt="facebook Likes"/></div>
		<div class="bottom">				
			<div id="facebook_like" class="count">2014</div>
			<div class="text">Likes</div>				
		</div>
	</div><!--end: .facebook-->
	<div class="gplus" onclick="return g_plusone();">
		<div class="icons"><img src="<?php echo URL_ROOT?>templates/default/images/gplus-icon.png" alt="google +"/></div>
		<div class="bottom">
			<div id="google_plusones" class="count">2014</div>
			<div class="text">+</div>
		</div>
	</div><!--end: .gplus-->	
</div><!--end: #social-hub-->          