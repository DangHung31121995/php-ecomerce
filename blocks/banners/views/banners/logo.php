<?php 
global $config;
$Itemid = FSInput::get('Itemid',1,'int');
$item = $list[0];
$title = $item -> name; 
?>
<?php if($Itemid == 1){ ?>
	<h1 class="main-logo">
		<a href="<?php echo URL_ROOT; ?>" title="<?php echo $config['site_name'] ?>">
            <img src="<?php echo URL_ROOT.$item -> image;?>" alt="<?php echo $config['site_name'] ?>"/>
        </a>
        <span>
        	<?php echo $config['title'] ?>
        </span>   
	</h1>	
<?php }else{ ?>
    <h4 class="main-logo">
		<a href="<?php echo URL_ROOT; ?>" title="<?php echo $config['site_name'] ?>">
            <img src="<?php echo URL_ROOT.$item -> image;?>" alt="<?php echo $config['site_name'] ?>"/>
        </a>
        <span>
        	<?php echo $config['title'] ?>
        </span>   
	</h4>
<?php } ?>