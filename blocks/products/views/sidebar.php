<?php 
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/products/assets/css');
$Itemid = 3;
?>
<div id="block-<?php echo $blockId?>" class="block-product block-product-<?php echo $style ?>" style="<?php echo $cssText?>">
	<h3 class="block-heading">
		<span><?php echo $title; ?></span>
	</h3>
	<?php 
    foreach ($list as $i => $item) {   
        $title = htmlspecialchars($item->name);
        $link = FSRoute::_('index.php?module=product&view=product&code='.$item->alias.'&id='.$item->id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
        $linkAddCart = FSRoute::_('index.php?module=product&view=cart&task=addCart&id='.$item->id);?>
    	<div class="product-sidebar-item">
            <a class="thumb" title="<?php echo $title;?>" href="<?php echo $link;?>">
                <img alt="<?php echo $title;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/tiny/', $item->image)?>" onerror="this.src='<?php echo URL_ROOT;?>images/no-image.jpg'"/>
            </a>
            <div class="name">
                 <a title="<?php echo $title;?>" href="<?php echo $link;?>"><?php echo $item->name ?></a>
            </div>
            <span class="price"><?php echo format_money($item -> price).' VNĐ'?></span>
            <a class="add-cart" href="<?php echo $linkAddCart;?>" title="Mua hàng">Mua hàng</a>
        </div><!-- .product-sidebar-item-->
	<?php } ?>
</div><!--end: .block-product-sidebar-->