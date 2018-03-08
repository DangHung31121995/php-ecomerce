<?php
global $tmpl;
$Itemid = 2;
$tmpl->addStylesheet($style, 'blocks/catsmenu/assets/css');
?>
<div id="block-<?php echo $blockId;?>" class="block-catsmenu block-catsmenu-<?php echo $module?>">
    <div class="span3-title">
        Danh mục sản phẩm
    </div>
    <div class="span3-cotent">
        <ul class="cats">
            <?php 
            $parentId = 0;
            $numChild = 0;
            $count = 0;
            foreach($listCatmenu as $item){ 
                if($parentId)
                    $count ++;
                $link = FSRoute::_('index.php?module=product&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
                echo '<li class="menu-'.$item->id.' '.($item->children?'has-child':'').' '.($currentCat==$item->id?'selected':'').'"><a href="'.$link.'" title="'.htmlspecialchars($item->name).'">'.$item->name.'</a>';  
                if($item->children){
                    $parentId = $item->id;
                    $numChild = $item->children;
                    echo '<ul class="submenu-'.$item->id.'">';
                }
                if($parentId && $count==$numChild){
                    $parentId = 0;
                    $count = 0;
                    $numChild = 0;
                    echo '  </li>'; 
                    echo '</ul>';
                    continue;
                }
                echo '</li>';    
            }
            ?>
        </ul>
    </div><!--end: .span3-cotent-->
</div><!--end: .block-catsmenu-->