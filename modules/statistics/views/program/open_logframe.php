<?php global $arrProgram ?>
<div class="tbpopup-title">
    <?php echo FSText::_('Select time'); ?>
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <table class="tbl-tmp" style="table-layout: fixed; margin: 0 auto;">
        <tr class="bg-gray bold" style="display: none;">
           <td class="bold" style="width: 47%;">Chương trình</td> 
           <td></td>
           <td class="bold" style="width: 45%;">
                <select class="form w100pc" id="excel_program" name="excel_program" class="form w215px" onchange="filterOutcome();">
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
           </td>
        </tr>
        <tr class="bg-gray bold">
           <td class="bold" style="width: 47%;">Từ ngày/ From</td> 
           <td></td>
           <td class="bold" style="width: 45%;">Đến ngày/ To</td>
        </tr>
        <tr>
           <td style="width: 47%;"><input id="start_date" style="text-align: right;" name="start_date" type="text" class="form w100pc" value="<?php echo date('d/m/Y', strtotime(OPERATING_SYSTEM)) ?>" /></td> 
           <td></td>
           <td style="width: 45%;"><input id="finish_date" style="text-align: right;" name="finish_date" type="text" class="form w100pc" value="<?php echo date('d/m/Y') ?>" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <a id="excel_link" href="<?php echo FSRoute::_('index.php?module=statistics&view=program&raw=1&task=logframe&program=1&start_date='.date('d/m/Y', strtotime(OPERATING_SYSTEM)).'&finish_date='.date('d/m/Y')) ?>" class="export excel" title="Xuất ra Excel">Xuất ra Excel</a>
            </td>
        </tr>
     </table>
</div><!--end: .tbpopup-content-->

<script type="text/javascript">
$("#start_date").datepicker({ 
    dateFormat: "dd/mm/yy",
    onSelect: function(dateText, inst){ changeExcelLink();}
});
$("#finish_date").datepicker({ 
    dateFormat: "dd/mm/yy",
    onSelect: function(dateText, inst){ changeExcelLink();}
});
$('select#excel_program').change(function(){
    changeExcelLink();
})
function changeExcelLink(){
    var $program = $('select#excel_program').val();
    var $start_date = $('#start_date').val();
    var $finish_date = $('#finish_date').val();
    $link = 'index.php?module=statistics&view=program&raw=1&task=logframe&program='+$program+'&start_date='+$start_date+'&finish_date='+$finish_date;
    $('a#excel_link').attr('href', $link);
}
</script>