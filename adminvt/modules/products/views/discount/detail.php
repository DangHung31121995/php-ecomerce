<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin();
TemplateHelper::dt_edit_text('Tên chương trình', 'title',@$data -> title);
TemplateHelper::dt_edit_text('Mã giảm giá', 'code',@$data -> code, '', 20);
?>
<tr>
    <td class="label key">Giảm</td>
    <td class="value">
        <input type="text" id="discount" name="discount" value="<?php echo (int)@$data->discount; ?>" size="20" />&nbsp;&nbsp;
        <select name="discount_unit" id="discount_unit">
            <option value="1" <?php if((int)@$data->discount_unit==1) echo 'selected="selected"'?> >VNĐ</option>
            <option value="2" <?php if((int)@$data->discount_unit==2) echo 'selected="selected"'?>>%</option>
        </select>
    </td>
</tr>
<tr>
    <td class="label key">Thời gian áp dụng: Từ</td>
    <td class="value">
        <input type="text" id="start_date" name="start_date" value="<?php if(isset($data->start_date)) echo date('d/m/Y', $data->start_date); else echo date('d/m/Y');?>" size="12" />&nbsp;&nbsp;
        đến&nbsp;
        <input type="text" id="expiration_date" name="expiration_date" value="<?php if(isset($data->expiration_date)) echo date('d/m/Y', $data->expiration_date); else echo date('d/m/Y');?>" size="12" />&nbsp;&nbsp;
    </td>
</tr>
<?php
TemplateHelper::dt_edit_text('Hạn mức áp dụng', 'values_apply',@$data -> values_apply, 0, 20);
TemplateHelper::dt_edit_text('Số lần áp dụng', 'number_apply',@$data -> number_apply, 0, 12,1,0,'Giá trị = 0 là không giới hạn');
if(isset($data->number_usered)){
?>
<tr>
    <td class="label key">Số lần đã sử dụng</td>
    <td class="value">
        <input readonly="readonly" type="text" value="<?php echo $data->number_usered;?>" size="12" />&nbsp;&nbsp;
    </td>
</tr>
<?php
}
TemplateHelper::dt_edit_text('Giới thiệu', 'summary', @$data -> summary, '',100,7);
TemplateHelper::dt_checkbox('Kích hoạt','published',@$data -> published,1);
TemplateHelper::dt_edit_text('Thứ tự','ordering',@$data -> ordering,@$maxOrdering,'20');
$this -> dt_form_end(@$data, 1, 0);
?>
<script type="text/javascript">
$("#start_date").datepicker({ dateFormat: "dd/mm/yy" });
$("#expiration_date").datepicker({ dateFormat: "dd/mm/yy" });
</script>