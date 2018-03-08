<?php 
global $tmpl, $arrStatus;
//$tmpl->addStylesheet($style, 'blocks/news/assets/css');
$tmpl->addScript('jquery.idTabs', 'libraries/jquery');
$Itemid = 3;
?>
<div id="block-<?php echo $blockId?>" class="content-left-row3 clearfix">
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
            <div class="col-wp-3 clearfix">
            <?php 
            $i = 0;
            foreach($list as $item){
                $i++;
                $title = htmlspecialchars($item->title);
                $link = FSRoute::_('index.php?module=news&view=news&id='.$item->id.'&code='.$item->alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
            ?>
                <?php if($i==1){ ?>
                    <a class="img-col-fn-3" href="<?php echo $link ?>" title="<?php echo $title ?>">
                        <img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                    </a>
                    <h2 class="title-col-fn">
                        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
                    </h2>
                    <p class="sumary-col-fn"><?php echo $item->summary ?></p>
                    <a class="wp-detail" href="<?php echo $link ?>" title="Chi tiết">Chi tiết</a>
                </div><!-- .col-wp-3 -->
                <div class="col1-left-row2">
                <?php }else{ ?>
                    <div class="col-fn">
                        <a class="img-col-fn" href="<?php echo $link ?>" title="<?php echo $title ?>">
                            <img src="<?php echo URL_ROOT.str_replace('/original/','/tiny/', $item->image); ?>" onerror="this.src='/images/no-image.jpg'" alt="<?php echo $title ?>" />
                        </a>
                        <h2 class="title-col-fn">
                            <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $item->title ?></a>
                        </h2>
                        <p class="sumary-col-fn">
                            <?php echo cutString($item->summary, 115) ?>
                        </p>
                    </div><!-- .col-fn-->
                <?php }//end: if($i==1) ?>
                <?php if($i==3){ ?>
                    </div><!-- .col1-left-row2-->
                    <div class="col2-left-row2">
                <?php }//end: if($i==3) ?>
            <?php }//end: foreach($list as $item) ?>
            </div><!--  .col2-left-row2 -->
        </div><!--end: #block-<?php echo $blockId?>-<?php echo $cat->id ?>-content-->
    <?php }// end: foreach($cats as $cat) ?>
</div><!-- .content-left-row3 -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#block-<?php echo $blockId?> li:first-child a").addClass('selected');
        $("#block-<?php echo $blockId?> ul").idTabs();
    });
</script>