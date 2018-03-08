<?php 
$Itemid = 2;
$tmpl->addStylesheet('default', 'blocks/categories/assets/css');
$tmpl->addScript('jquery.idTabs', 'libraries/jquery');
?>
<div id="block-<?php echo $blockId; ?>" class="block-categories" style="<?php echo $cssText;?>">
    <div class="block-title">
        <a class="caption" href="<?php echo FSRoute::_('index.php?module=product&view=home&Itemid='.$Itemid)?>" title="<?php echo htmlspecialchars($title);?>">
            <?php echo $title;?>
        </a>
        <a class="tool next" href="#next" title="next">next</a>
        <a class="tool prev" href="#prev" title="prev">prev</a>
    </div><!--end: .block-title-->
    <div class="height10"></div>
    <div class="categories">
        <ul class="list-cats fl">
            <?php 
            foreach($categories as $cat){
            ?>
                <li><a href="#block-<?php echo $blockId; ?>-<?php echo $cat->id; ?>" title="<?php htmlspecialchars($cat->name)?>"><?php echo $cat->name; ?></a></li>
            <?php } ?>
        </ul><!--end: .list-cats-->
        <ul class="list-products fr">
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
                                <a class="quick-view" href="<?php echo $link;?>" title="Xem nhanh">Xem nhanh</a>
                                <div>
                                    <a class="img" title="<?php echo $title;?>" href="<?php echo $link;?>">
                                        <img alt="<?php echo $title;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image)?>" onerror="this.src='<?php echo URL_ROOT;?>images/no-image.jpg'"/>
                                    </a>
                                </div>
                            </div><!--end: .thumb-->
                            <div class="summary">
                                <h2 class="df"><a title="<?php echo $title;?>" class="df" href="<?php echo $link;?>"><?php echo $item->name;?></a></h2>
                                <div class="price"><?php echo format_money($item -> price).' Đ'?></div>
                                <?php 
                                if($item->discount){
                                    $percent = round(($item->discount/$item -> price_old) * 100, 0);
                                ?>
                                    <div class="price off"><?php echo format_money($item -> price_old).' Đ'?></div>
                                    <div class="holder">-<?php echo $percent?>%</div>
                            	<?php }?>
                            </div><!--end: .summary-->
                            <a class="addcart" href="<?php echo $linkAddCart;?>" title="Đặt hàng">Đặt hàng</a>
                            <a class="readmore" href="<?php echo $link;?>" title="Xem">Xem</a>
                        </article><!--end: .product-item-->
                    <?php } ?>
                </li>
            <?php } ?>
        </ul><!--end: .list-products-->
        <div class="clearfix"></div>
    </div><!--end: .categories-->
    <div class="clearfix"></div>
</div><!--end: .block-categories-->
<script type="text/javascript"> 
$(document).ready(function() {
    $("#block-<?php echo $blockId; ?> ul.list-cats").idTabs();
});
</script>