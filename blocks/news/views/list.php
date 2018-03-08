<?php 
global $tmpl, $arrStatus;
//$tmpl->addStylesheet($style, 'blocks/news/assets/css');
$tmpl->addScript('jquery.idTabs', 'libraries/jquery');
$Itemid = 5;
?>
<div id="block-<?php echo $blockId?>" class="news-list" style="<?php echo $cssText?>">
    <ul class="name-title tabs">
        <?php  
        foreach($cats as $cat){
        ?>
            <li><a href="#block-<?php echo $blockId?>-<?php echo $cat->id ?>-content" title="<?php echo htmlspecialchars($cat->name); ?>"><span><?php echo $cat->name; ?></span></a></li>
        <?php } ?>
    </ul><!-- .name-title -->
    <?php  
    foreach($cats as $cat){
        $list = $cat->news;
    ?>
        <div id="block-<?php echo $blockId?>-<?php echo $cat->id ?>-content">
        <?php 
        foreach($list as $item){
            $title = htmlspecialchars($item->title);
            $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
        ?>
            <div class="col-fn">
                <a class="img-col-fn" href="<?php echo $link ?>" title="<?php echo $title ?>">
                    <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                </a>
                <h2 class="title-col-fn"><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a></h2>
                <p class="sumary-col-fn"><?php echo cutString($item->summary, 115) ?></p>
            </div><!-- .col-fn-->
        <?php } ?>
        </div>
    <?php } ?>
</div><!--end: #block-<?php echo $blockId?>-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#block-<?php echo $blockId?> li:first-child a").addClass('selected');
        $("#block-<?php echo $blockId?> ul").idTabs();
    });
</script>