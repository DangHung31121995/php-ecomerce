<?php
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/banners/assets/css');
$tmpl->addScript('jquery.mousewheel', 'blocks/banners/assets/js');
$tmpl->addScript('jquery.flexslider-min', 'blocks/banners/assets/js');
$tmpl->addScript('jquery.easing', 'blocks/banners/assets/js');
?>
<div id="block-<?php echo $blockId ?>" class="block-banner block-banner-<?php echo $style;?> flexslider" style="<?php echo $cssText;?>">
    <ul class="slides">
        <?php foreach($list as $item){?>
            <?php if($item -> type == 1):?>
                <li>
                    <a href="<?php echo $item -> link;?>" title="<?php echo $item -> name;?>">
                        <img alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>"/>
                    </a>
                </li>
            <?php endif; ?>
        <?php }?>
    </ul>
    <div class="clear"></div>
</div><!--end: #block-<?php echo $blockId; ?>-->
<script type="text/javascript">
$(document).ready(function(){
    $('#block-<?php echo $blockId ?>').flexslider({
        animation: "slide",
        controlNav: true,
        animationLoop: false,
        slideshow: true,
    });
});
</script>