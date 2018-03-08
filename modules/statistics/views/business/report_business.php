<?php 
global $arrBusinessResults;
?>
<div class="tbpopup-title">
    Bảng liệt kê các doanh nghiệp
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <table id="tbl_participants" class="data-table">
        <tr class="bg-gray blue center bold" style="table-layout: fixed;">
            <td style="width: 45px;"><?php echo FSText::_('STT'); ?></td>
            <td style="width: 400px;"><?php echo FSText::_('Đơn vị'); ?></td>
            <td><?php echo FSText::_($arrBusinessResults[$key]); ?></td>
        </tr>
        <?php 
        $i = 0;
        foreach($list as $item){
            $i++;
        ?>
            <tr>
                <td class="center"><?php echo $i ?></td>
                <td><?php echo $item->agencies_title ?></td>
                <td class="center"><?php echo number_format($item->$key, 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </table>
</div><!--end: .tbpopup-content-->