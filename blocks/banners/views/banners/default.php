<?php  
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/banners/assets/css');
?>
<div id="block-<?php echo $blockId; ?>" class="block-banner block-banner-<?php echo $style ?>" style="<?php echo $cssText?>">
    <?php foreach($list as $item){?>
        <div  id="banner-<?php echo $item->id; ?>" class="item">
    		<?php if($item -> type == 1){?>
    			<?php if($item -> image){?>
    				<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
    					<?php if($item -> width && $item -> height){?>
    					<img alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
    					<?php } else { ?>
    					<img alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>"/>
    					<?php }?>
    				</a>
    			<?php }?>
    		<?php } else if($item -> type == 2){?>
    			<?php 
                if($item -> flash){
                    $flash_size=@getimagesize($item -> flash);
                ?>
    			<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
    				<embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$item->flash?>" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $flash_size[0];?>" height="<?php echo $flash_size[1];?>"/>
    			</a>
    			<?php }?>
    		<?php } else {?>
    			<?php echo $item -> content; ?>
    		<?php }?>
        </div>
	<?php }?>
</div><!--end: #block-<?php echo $blockId; ?>-->