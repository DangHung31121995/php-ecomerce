<?php 
global $arrRiskType;
?>
<div class="tbpopup-title">
    <?php echo FSText::_('Chi tiết rủi ro') ?>
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <form id="add_risk" name="add_risk" action="/">
    <table class="table-form">
        <tr>
            <td class="label"><?php echo FSText::_('Loại') ?>:</td>
            <td>
                <select id="type" name="type" class="form w215px">
                    <?php foreach($arrRiskType as $key=>$val){ ?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Rủi ro') ?>:</td>
            <td>
                <textarea id="risk" name="risk" style="width: 716px" rows="3" class="form"></textarea>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Biện pháp giảm nhẹ') ?>:</td>
            <td>
                <textarea id="solution" name="solution" style="width: 716px" rows="3" class="form"></textarea>
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td>
                <input type="button" value="<?php echo FSText::_('Thêm mới') ?>" onclick="addRisk();" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="data_id" id="data_id" value="<?php echo $id ?>" />
    </form><br /><br />
    <div class="heading">
        <?php echo FSText::_('Danh sách Rủi ro') ?>:
    </div>
    <table id="tbl_risks" class="data-table" style="table-layout: fixed; ">
        <tr class="bg-yellow white center bold">
            <td style="width: 250px;"><?php echo FSText::_('Loại') ?></td>
            <td><?php echo FSText::_('Rủi ro') ?></td>
            <td><?php echo FSText::_('Biện pháp giảm nhẹ') ?></td>
            <td style="width: 50px;"></td>
        </tr>
        <?php foreach($list as $item){ ?>
            <tr id="tr_<?php echo fsEncode($item->id); ?>">
                <td><?php echo @$arrRiskType[$item->type] ?></td>
                <td><?php echo $item->risk ?></td>
                <td><?php echo $item->solution ?></td>
                <td class="center"><a onclick="delRisk('<?php echo fsEncode($item->id); ?>');" class="btn-delete" href="javascipt:void(0);"></a></td>
            </tr>
        <?php } ?>
    </table>
</div><!--end: .tbpopup-content-->