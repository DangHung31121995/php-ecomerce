<div class="tbpopup-title">
    <?php echo $title; ?>
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <table id="tbl_participants" class="data-table">
        <tr class="bg-yellow white center bold" style="table-layout: fixed;">
            <td style="width: 200px;">Đơn vị</td>
            <?php if(in_array($activity_type, array(3,4,5,6))){ ?>
                <td style="width: 100px;"><?php echo FSText::_('Số khách hàng mới'); ?></td>
                <td style="width: 100px;"><?php echo FSText::_('Số hợp đồng'); ?></td>
                <td style="width: 150px;"><?php echo FSText::_('Tổng giá trị hợp đồng').' ('.FSText::_('triệu đồng').')' ?></td>
            <?php } ?>
            <td><?php echo FSText::_('Bài học kinh nghiệm'); ?></td>
        </tr>
        <?php foreach($list as $item){ ?>
            <tr>
                <td><?php echo $item->agencies_title ?></td>
                <?php if(in_array($activity_type, array(3,4,5,6))){ ?>
                    <td class="center"><?php echo number_format($item->customers, 0, ',', '.') ?></td>
                    <td class="center"><?php echo number_format($item->contracts, 0, ',', '.') ?></td>
                    <td style="text-align: right;"><?php echo number_format($item->contractsvalue, 0, ',', '.') ?></td>
                <?php } ?>
                <td><?php echo $item->outcome ?></td>
            </tr>
        <?php } ?>
    </table>
</div><!--end: .tbpopup-content-->