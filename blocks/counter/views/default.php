<?php
global $tmpl; 
$tmpl->addStylesheet($style, 'blocks/counter/assets/css');
?>
<div class="height10"></div>
<div class="box-counter">
    <div class="box-title"><?php echo FSText::_('Thống kê truy cập'); ?></div>
    <div class="height5"></div>
    <div class="fl"><?php echo FSText::_('Tổng số lượt');?> : </div>
    <div class="fr"><?php echo number_format($visited, 0, ',', '.');?></div>
    <div class="clearfix"></div>
    <div class="fl"><?php echo FSText::_('Đang online')?>  : </div>
    <div class="fr a123"><?php echo number_format($online, 0, ',', '.');?></div>
    <div class="clearfix"></div>
</div><!--end: .box-counter-->