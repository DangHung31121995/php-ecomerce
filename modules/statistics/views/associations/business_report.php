<div class="tbpopup-title">
    Kết quả và bài học kinh nghiệm
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <style>
    .data-table td{
        padding: 10px 7px;
    }
    </style>
    <table class="data-table">
        <tr>
            <td class="bg-gray bold center blue" style="width: 45px;">STT</td>
            <td class="bg-gray bold center blue" style="width: 250px;">Doanh nghiệp</td>
            <td class="bg-gray bold center blue" style="width: 120px;">Ngành hàng</td>
            <td class="bg-gray bold center blue">Kết quả và bài học kinh nghiệm</td>
        </tr>
        <?php 
        $i = 0;
        foreach($list as $item){ 
            $i++;
        ?>
            <tr>
                <td class="center"><?php echo $i ?></td>
                <td><?php echo $item->agencies_title ?></td>
                <td><?php echo @$arrIndustries[$item->commodity_id]; ?></td>
                <td><?php echo $item->outcome ?></td>
            </tr>
        <?php } ?>
    </table><br />
    <?php /* <div class="ci-heading" style="font-size: 18px;">Tổng hợp kết quả và bài học kinh nghiệm:</div>
    <table class="data-table">
        <tr>
            <td class="form" style="width: 100%; border: none;">
                <textarea id="lessons_learned" name="lessons_learned" style="width: 100%;" rows="5" class="form" placeholder="Tóm tắt bài học kinh nghiệm..."><?php echo @$data->$key ?></textarea><br /><br />
                <input type="button" value="Cập nhật" onclick="saveBusiness();" />
                <input type="hidden" name="key" id="key" value="<?php echo $key; ?>" />
                <input type="hidden" name="cr_id" id="cr_id" value="<?php echo intval(@$data->id); ?>" />
            </td>
        </tr>
    </table> */ ?>
</div><!--end: .tbpopup-content-->