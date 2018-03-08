<?php 
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/products/assets/css');
$Itemid = 3;
?>
<div id="block-<?php echo $blockId?>" class="block-product block-product-<?php echo $style ?>" style="<?php echo $cssText?>">
    <h3 class="block-heading">
        <a href="<?php echo FSRoute::_('index.php?module=product&view=home&Itemid=2') ?>" title="<?php echo htmlspecialchars($title)?>"><?php echo $title ?></a>
    </h3><!--end: .block-heading-->
    <div class="block-content clearfix">
        <?php $i = 0;
        $total = count($list);
        foreach($list as $item){
            $i++;
            $title = htmlspecialchars($item->name);
            $link = FSRoute::_('index.php?module=product&view=product&code='.$item->alias.'&id='.$item->id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            $linkAddCart = FSRoute::_('index.php?module=product&view=cart&task=addCart&id='.$item->id);?>
            <div class="product-item">
                <a class="thumb" title="<?php echo $title;?>" href="<?php echo $link;?>">
                    <img alt="<?php echo $title;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image)?>" onerror="this.src='<?php echo URL_ROOT;?>images/no-image.jpg'"/>
                </a>
                <div class="heading">
                     <a title="<?php echo $title;?>" href="<?php echo $link;?>"><?php echo $item->name ?></a>
                </div>
                <div class="price"><?php echo format_money($item -> price).' VNĐ'?></div>
            </div><!-- .product-item-->
            <?php if($i%5==0 && $i!=$total){ ?><div class="clear"></div><?php } ?>
        <?php }//end: foreach($list as $item) ?>
    </div><!--end: .block-content -->
</div><!--end: #block-<?php echo $blockId?>-->