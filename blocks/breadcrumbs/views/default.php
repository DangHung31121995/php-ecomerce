<?php
global $tmpl; 
$tmpl -> addStylesheet($style, 'blocks/breadcrumbs/assets/css');
?>	
<?php if(isset($breadcrumbs) && !empty($breadcrumbs)){?>
<div class="block-breadcrumb">
    <a title="Trang chủ" rel="nofollow" href="<?php echo URL_ROOT;?>"><?php echo FSText::_('Trang chủ'); ?></a>
	<?php 
    $i = 0;
    $total = count($breadcrumbs);
    foreach($breadcrumbs as $item){
        $i++;
    ?>
        <?php if($i == $total) echo '<h1>'; ?>
        <span>»</span><a href="<?php echo $item[1];?>" title="<?php echo htmlspecialchars($item[0]);?>"><?php echo $item[0];?></a>
        <?php if($i == $total) echo '</h1>'; ?>
	<?php }?>
</div>
<?php }?>