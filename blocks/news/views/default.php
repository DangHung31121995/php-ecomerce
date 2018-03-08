<?php 
global $tmpl;
$tmpl->addScript('jquery.idTabs', 'libraries/jquery');
$Itemid = 5;
?>
<div id="block-<?php echo $blockId?>" class="content-left-row1 clearfix" style="<?php echo $cssText?>">
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
        <div id="block-<?php echo $blockId ?>-<?php echo $cat->id ?>-content">
            <div class="new-health-col1">
            <?php 
            $i = 0;
            foreach($list as $item){
                $i++;
                $title = htmlspecialchars($item->title);
                $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
                <?php if($i == 1){ ?>
                    <a class="img-new-health" href="<?php echo $link ?>" title="<?php echo $title ?>">
                        <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                    </a>
                    <h2 class="title-new-health">
                        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
                    </h2>
                    <p><?php echo cutString($item->summary, 215) ?></p>
                </div> <!-- .new-health-col1 -->
                <div class="new-health-col2">
                <?php }else{ ?>
                    <div class="new-health-row news1">
                        <a class="img-new-row" href="<?php echo $link ?>" title="<?php echo $title ?>">
                            <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                        </a>
                        <h2 class="title-new-health">
                            <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
                        </h2>
                        <p><?php echo cutString($item->summary, 110) ?></p>
                    </div><!-- .new-health-row-1 -->
                <?php }//end: if($i == 1) ?>
            <?php }//end: foreach($list as $item) ?>
            </div> <!-- .new-health-col2 -->
        </div><!--end: #block-<?php echo $blockId ?>-<?php echo $cat->id ?>-content-->
    <?php }//end: foreach($cats as $cat) ?>
</div><!-- .content-left-row1 -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#block-<?php echo $blockId?> li:first-child a").addClass('selected');
        $("#block-<?php echo $blockId?> ul").idTabs();
    });
</script>