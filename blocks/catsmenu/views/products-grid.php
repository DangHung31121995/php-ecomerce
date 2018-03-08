<?php
global $tmpl;
$Itemid = 2;
$tmpl->addStylesheet($style, 'blocks/catsmenu/assets/css');
?>
<div id="block-<?php echo $blockId;?>" class="block-catsmenu block-catsmenu-<?php echo $style ?> block-catsmenu-<?php echo $module?>" style="<?php echo $cssText ?>">
    <ul>
        <?php
        foreach($listCatmenu as $item){ 
            $link = FSRoute::_('index.php?module=product&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
            $title =  htmlspecialchars($item->name);
        ?>
            <li>
                <h2 class="mcat-item">
                    <a class="heading" href="<?php echo $link ?>" title="<?php echo $title ?>">
                        <?php echo $item->name; ?>
                    </a>
                    <a class="thumb" href="<?php echo $link ?>" title="<?php echo $title ?>">
                        <img src="<?php echo URL_ROOT.$item->icon ?>" />
                    </a>
                    <div class="caption">
                        Tổng số
                    </div>
                    <div class="number">
                        <?php echo $item->total_products ?> sản phẩm
                    </div>
                </h2><!--end: .mcat-item--> 
            </li>
        <?php } ?>
    </ul>
</div>