<?php 
global $tmpl;
$tmpl->addScript('jquery.carouFredSel', 'libraries/jquery');
$Itemid = 5;
$total = count($list);
if($total < 4)
    return;
$totalSlide = $total - 3 - 1; // -3 Tin bên phải, -1 cho index = 0;
?>
<div id="block-<?php echo $blockId ?>" class="wapper-content clearfix" style="<?php echo $cssText?>">
    <div class="wt-slider">
        <ul>
            <?php 
            for($i=0; $i<= $totalSlide; $i++){
                $item = $list[$i];
                $title = htmlspecialchars($item->title);
                $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
                <li class="slider-item fl">
                    <a href="<?php echo $link ?>" title="<?php echo $title ?>">
                        <img src="<?php echo URL_ROOT.str_replace('/original/','/slideshow/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                    </a>
                    <div class="txt-slider">
                        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a><br />
                        <?php echo cutString($item->summary, 130, '...') ?> 
                    </div>
                </li>
            <?php }//end: for($i=0; $i++; $i<= $totalSlide) ?>
        </ul>
        <a class="flex prev" href="#" title="">Previous</a>
        <a class="flex next" href="#" title="">Next</a>
    </div><!-- .wt-slider  -->
    <div class="wt-right">
        <div class="wt-content row1">
            <?php 
            $item = $list[$totalSlide+1];
            $title = htmlspecialchars($item->title);
            $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
            <a href="<?php echo $link ?>" title="<?php echo $title ?>">
                <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
            </a>
            <div class="fr">
                <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a><br />
                <?php echo cutString($item->summary, 130, '...') ?>
            </div>
        </div>
        <div class="wt-content row2">
            <?php 
            $item = $list[$totalSlide+2];
            $title = htmlspecialchars($item->title);
            $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
            <a href="<?php echo $link ?>" title="<?php echo $title ?>">
                <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
            </a>
            <div class="fr">
                <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
            </div>
        </div>
        <div class="wt-content row3">
            <?php 
            $item = $list[$totalSlide+3];
            $title = htmlspecialchars($item->title);
            $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
            <a href="<?php echo $link ?>" title="<?php echo $title ?>">
                <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
            </a>
            <div class="fr">
                <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
            </div>
        </div>
    </div><!-- .wt-right  -->
</div><!-- .wapper-content  -->
<script type="text/javascript">	
$(document).ready(function() {		
    $("#block-<?php echo $blockId?> ul").carouFredSel({            
        circular: true,   	        
        infinite: false,   	        
        auto: true,            
        scroll: {           		
            items	: "slider-item",           		
            easing			: "linear",           		
            pauseDuration   : 3000,           		
            pauseOnHover	: "immediate"           	
        },			
        items : 1,            
        prev: '#block-<?php echo $blockId?> .prev',            
        next: '#block-<?php echo $blockId?> .next'		
    });		
});
</script>