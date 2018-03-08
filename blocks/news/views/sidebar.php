<?php 
global $tmpl, $arrStatus;
//$tmpl->addStylesheet($style, 'blocks/news/assets/css');
$Itemid = 5;
?>
<div id="block-<?php echo $blockId;?>" class="box nopadding" style="<?php echo $cssText?>">
    <h3 class="box-heading">
		<span><?php echo $title; ?></span>
	</h3>
    <div class="box-content">
        <div class="row-fluid box-news">	
            <?php foreach($list as $item){
                $title = htmlspecialchars($item->title);
                $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);?>
                <article class="news-block span12">
                    <div class="news-inner">
                        <div class="image">
                            <a href="<?php echo $link;?>" title="<?php echo $title;?>">
                                <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" alt="<?php echo $title;?>" />
                            </a>
                        </div>	
                        <div class="news-bottom is-over">
                            <h3 class="name"><a class="df" href="<?php echo $link;?>" title="<?php echo $title ?>"><?php echo $item->title?></a></h3>
                        </div>
                    </div><!--end: .news-inner-->
                </article>
            <?php } //end: foreach($list as $item)?>
            <!--<a class="readmore fr" href="<?php echo FSRoute::_('index.php?module=news&view=home&Itemid=4')?>" title="Xem thêm">Xem thêm</a>-->
        </div><!--end: .box-news-->
    </div><!--end: .box-content-->
</div><!--end: .block-news-->