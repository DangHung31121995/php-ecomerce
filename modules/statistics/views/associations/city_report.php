<div class="tbpopup-title">
    Tổng hợp kết quả và bài học kinh nghiệm
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <style>
    .data-table td{
        padding: 10px 7px;
    }
    </style>
    <div class="ci-heading" style="font-size: 18px;">Tổng hợp kết quả và bài học kinh nghiệm:</div>
    <table class="data-table">
        <tr>
            <td class="form" style="width: 100%; border: none;">
                <textarea id="lessons_learned" name="lessons_learned" style="width: 100%;" rows="5" class="form" placeholder="Tóm tắt bài học kinh nghiệm..."><?php echo @$data->$key ?></textarea><br /><br />
                <input type="button" value="Cập nhật" onclick="saveBusiness();" />
                <input type="hidden" name="key" id="key" value="<?php echo $key; ?>" />
                <input type="hidden" name="cr_id" id="cr_id" value="<?php echo intval(@$data->id); ?>" />
            </td>
        </tr>
    </table>
</div><!--end: .tbpopup-content-->