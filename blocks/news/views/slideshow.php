<?php 
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/news/assets/css');
$tmpl->addScript('jquery.carouFredSel', 'libraries/jquery');
$Itemid = 5;
?>
<div id="block-<?php echo $blockId?>" class="block-news block-news-<?php echo $style?>" style="<?php echo $cssText; ?>">
    <ul>
        <li class="row-fluid">
        <?php $i = 0; $total = count($list);
        foreach($list as $item){
            $i++;
            $title = htmlspecialchars($item->title);
            $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);?>
            <article class="item-regular">
                <div class="row-fluid">
                    <a class="column span4" href="<?php echo $link;?>" title="<?php echo $title;?>">
                        <span><img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" alt="<?php echo $title;?>" /></span>
                    </a>
                    <div class="column span8">
                        <h2><a class="df" href="<?php echo $link;?>" title="<?php echo $title ?>"><?php echo $item->title?></a></h2>
                    </div>
                </div>
            </article><!--end: .item-regular-->
            <?php if($i%3 == 0 && $i!=$total){ ?>
            </li>
            <li class="row-fluid">
            <?php } ?>
        <?php } //end: foreach($list as $item)?>
        </li>
    </ul>
    <div class="clearfix"></div>
    <a href="#prev" class="prev tool">prev</a>
    <a href="#next" class="next tool">next</a>
</div><!--end: .block-news-->
<script type="text/javascript">	
$(document).ready(function() {		
    $("#block-<?php echo $blockId?> ul").carouFredSel({            
        circular: true,   	        
        infinite: false,   	        
        auto: true,            
        scroll: {           		
            items	: "span4",           		
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