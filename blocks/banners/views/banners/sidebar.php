<div id="banner<?php echo $blockId; ?>" class="box">
    <?php foreach($list as $item){?>
        <div class="pav-banner">
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
</div>

<script type="text/javascript">
<!--
    $(document).ready(function() {
        $('#banner<?php echo $blockId; ?> div:first-child').css('display', 'block');
    
        var banner = function() {
            $('#banner<?php echo $blockId; ?>').cycle({
                before: function(current, next) {
                $(next).parent().height($(next).outerHeight());
            }
            });
        }
    
        setTimeout(banner, 2000);
    });
//-->
</script>