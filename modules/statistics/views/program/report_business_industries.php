<?php 
global $arrIndustries;
?>
<div class="tbpopup-title">
    Danh sách ngành
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <table id="tbl_participants" class="data-table">
        <tr class="bg-gray blue center bold" style="table-layout: fixed;">
            <td style="width: 45px;"><?php echo FSText::_('STT'); ?></td>
            <td style="width: 400px;"><?php echo FSText::_('Ngành'); ?></td>
        </tr>
        <?php 
        $i = 0;
        foreach($list as $item){
            $i++;
        ?>
            <tr>
                <td class="center"><?php echo $i ?></td>
                <td><?php echo @$arrIndustries[$item->industry_id] ?></td>
            </tr>
        <?php } ?>
    </table>
</div><!--end: .tbpopup-content-->