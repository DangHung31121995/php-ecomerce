<?php 
$Itemid = 2;
$tmpl->addStylesheet($style, 'blocks/categories/assets/css');
$tmpl->addScript('jquery.idTabs', 'libraries/jquery');
?>
<div id="block-<?php echo $blockId; ?>" class="block-categories block-categories-<?php echo $style?>" style="<?php echo $cssText;?>">
    <div class="block-title">
        <ul class="list-cats df">
            <?php 
            foreach($categories as $cat){
            ?>
                <li><a href="#block-<?php echo $blockId; ?>-<?php echo $cat->id; ?>" title="<?php htmlspecialchars($cat->name)?>"><?php echo $cat->name; ?></a></li>
            <?php } ?>
        </ul><!--end: .list-cats-->
        <div class="clearfix"></div>
    </div><!--end: .block-title-->
    <div class="block-content">
        <ul class="list-products">
            <?php 
            foreach($categories as $cat){
            ?>
                <li id="block-<?php echo $blockId; ?>-<?php echo $cat->id; ?>">
                    <?php 
                    foreach($cat->products as $item){
                        $title = htmlspecialchars($item->name);
                        $link = FSRoute::_('index.php?module=product&view=product&code='.$item->alias.'&id='.$item->id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
                        $linkAddCart = FSRoute::_('index.php?module=product&view=cart&task=addCart&id='.$item->id);
                    ?>
                        <article class="product-item fl">
                            <div class="thumb">
                                <a title="<?php echo $title;?>" href="<?php echo $link;?>">
                                    <img alt="<?php echo $title;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image)?>" onerror="this.src='<?php echo URL_ROOT;?>images/no-image.jpg'"/>
                                </a>
                            </div><!--end: .thumb-->
                            <h2 class="df"><a title="<?php echo $title;?>" class="df" href="<?php echo $link;?>"><?php echo $item->name;?></a></h2>
                            <div class="price">
                                <?php echo format_money($item -> price).' VNĐ'?>
                            </div><!--end: .price-->
                            <div class="price off">
                                <?php if($item->discount) echo format_money($item -> price_old).' VNĐ'?>
                            </div><!--end: .price.off-->
                            <a class="addcart" href="<?php echo $linkAddCart;?>" title="MUA HÀNG">MUA HÀNG</a>
                        </article><!--end: .product-item-->
                    <?php } ?>
                </li>
            <?php } ?>
        </ul><!--end: .list-products-->
        <div class="clearfix"></div>
    </div><!--end: .block-content-->
</div><!--end: .block-categories-->
<script type="text/javascript"> 
$(document).ready(function() {
    $("#block-<?php echo $blockId; ?> ul.list-cats").idTabs();
});
</script>