<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrRegions, $arrProgram, $user, $arrOperationalStatus;
$tmpl->addStylesheet('activate', 'modules/statistics/assets/css');
$tmpl->addStylesheet('thickbox');
$tmpl->addStylesheet('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addScript('thickbox');
$tmpl->addScript('activate', 'modules/statistics/assets/js');
$tmpl->addScript('jquery-ui', 'libraries/jquery/jquery.ui');
?>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo'); ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Lập báo cáo'); ?></div>
    <form id="frm_activate" action="/index.php?module=statistics&view=activate&task=do_save" onsubmit="return validReportActivity();" method="POST" enctype="multipart/form-data">
    <table class="table-form">
        <tr>    
            <td class="label"><?php echo FSText::_('Tên hoạt động'); ?>:</td>
            <td colspan="3">
                <input id="title" name="title" type="text" style="width: 716px;" class="form" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Chương trình'); ?>:</td>
            <td class="w355px">
                <select id="program" name="program" class="form w215px" onchange="filterOutcome();">
                    <option value="0">-- <?php echo FSText::_('Chọn chương trình'); ?> --</option>
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="note">(<?php echo FSText::_('Bắt buộc'); ?> )</span>
            </td>
            <td class="label">
                <span class="program-city"><?php echo FSText::_('Đơn vị')?></span>
            </td>
            <td>
                <span class="program-city"><?php if($user->userID){ ?>
                    <?php echo $user->userInfo->agencies_title; ?>
                <?php } ?></span>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Loại hình hoạt động'); ?>:</td>
            <td class="w355px">
                <select id="activity_type" name="activity_type" class="form w215px" onchange="filterOutcome();">
                    <option value="0">-- <?php echo FSText::_('Chọn loại hình'); ?> --</option>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="note">( <?php echo FSText::_('Bắt buộc'); ?>)</span>
            </td>
            <td class="label"><?php echo FSText::_('Thời gian'); ?>:</td>
            <td>
                <?php echo FSText::_('Từ'); ?> <div class="bound-calendar"><input style="width:75px" id="start_date" name="start_date" type="text" class="form" value="<?php echo date('d/m/Y') ?>" /></div>&nbsp;&nbsp;
                <?php echo FSText::_('Đến'); ?> <div class="bound-calendar"><input style="width:75px" id="finish_date" name="finish_date" type="text" class="form calendar" value="<?php echo date('d/m/Y') ?>" /></div>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Hoạt động'); ?>:</td>
            <td class="w355px">
                <select id="activity_plan_id" name="activity_plan_id" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Lựa chọn từ kế hoạch CT'); ?> --</option>
                    <?php foreach($plans as $item){?>
                        <option value="<?php echo $item->id ?>"><?php echo $item->activity_title ?></option>
                    <?php } ?>
                </select>
                <span class="note"><?php echo FSText::_(''); ?><!--( Không bắt buộc)--></span>
            </td>
            <td class="label"><?php echo FSText::_('Cán bộ phụ trách'); ?>:</td>
            <td>
                <input id="city_code" name="city_code" type="text" class="form w90px" placeholder="Tỉnh (ID)," />&nbsp;&nbsp;
                <input id="officers_code" name="officers_code" type="text" class="form w110px" placeholder="Ngành hàng (ID)" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Ngành hàng'); ?>:</td>
            <td class="w355px">
                <select id="commodity_id" name="commodity_id" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Lựa chọn'); ?> --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="label"><?php echo FSText::_('Số người tham gia'); ?>:</td>
            <td>
                <input id="number_participants" name="number_participants" type="text" style="width: 40px;" class="form" value="0" />&nbsp;
                <input id="btn_activity_participants" class="yellow" type="button" value="Upload" />
                <input onclick="open_participants_box();" class="yellow" type="button" value="<?php echo FSText::_('Nhập chi tiết'); ?>" />
                <span style="opacity: 0; height: 1; width: 1;">
                    <input type="file" name="activity_participants" id="activity_participants" />
                </span>
                <input id="number_centre_staff" name="number_centre_staff" value="0" type="hidden"/>
                <input id="number_center" name="number_center" value="0" type="hidden"/>
                <input id="number_business_staff" name="number_business_staff" value="0" type="hidden"/>
                <input id="number_businesses" name="number_businesses" value="0" type="hidden"/>
                <input id="number_press_agencies" name="number_press_agencies" value="0" type="hidden"/>
                <input id="number_project_managers" name="number_project_managers" value="0" type="hidden"/>
                <input id="number_visitors_activity" name="number_visitors_activity" value="0" type="hidden"/>
                <input id="number_visitors_activity_females" name="number_visitors_activity_females" value="0" type="hidden"/>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Khác'); ?>:</td>
            <td class="w355px">
                <input id="commodities_outside" name="commodities_outside" type="text" class="form w215px" placeholder="Ngành hàng/ hoạt động ngoài CT" />
            </td>
            <td class="label"><?php echo FSText::_('Ngân sách chương trình'); ?>:</td>
            <td>
                <input id="budget_program" name="budget_program" type="text" class="form w215px text-right" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Địa điểm'); ?>:</td>
            <td class="w355px">
                <input id="activity_address" name="activity_address" type="text" class="form w215px" />
                <?php /* <select id="activity_region" name="activity_region" class="form w110px">
                    <option value="0">-- Vùng --</option>
                    <?php foreach($arrRegions as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <select id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- Tỉnh --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select> */ ?>
            </td>
            <td class="label"><?php echo FSText::_('Ngân sách đối ứng'); ?>:</td>
            <td>
                <input id="budget_reciprocal" name="budget_reciprocal" type="text" class="form w215px text-right" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Kết quả đạt được ngay sau hoạt động'); ?>:</td>
            <td colspan="3">
                <textarea id="achievements" name="achievements" style="width: 716px" rows="3" class="form"></textarea>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Bài học kinh nghiệm'); ?>:</td>
            <td colspan="3">
                <textarea id="empirical" name="empirical" style="width: 716px" rows="3" class="form"></textarea>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Thách thức'); ?>:</td>
            <td colspan="3">
                <textarea id="challenge" name="challenge" style="width: 716px" rows="3" class="form"></textarea>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Rủi ro'); ?>:</td>
            <td colspan="3">
                <input onclick="open_risk_box();" class="yellow" type="button" value="<?php echo FSText::_('Nhập chi tiết'); ?>" />
            </td>
        </tr>
        <tr class="for-fair">
            <td class="label"><?php echo FSText::_('Số gian hàng'); ?>:</td>
            <td colspan="3">
                <input id="booth_number" name="booth_number" type="text" class="form w215px" />
            </td>
        </tr>
        <tr class="for-fair">
            <td class="label"><?php echo FSText::_('Số lượt khách'); ?>:</td>
            <td colspan="3">
                <input id="number_visitors" name="number_visitors" type="text" class="form w215px" />
            </td>
        </tr>
        <tr class="for-fair">
            <td class="label"><?php echo FSText::_('Số giao dịch'); ?>:</td>
            <td colspan="3">
                <input id="number_transactions" name="number_transactions" type="text" class="form w215px" />
            </td>
        </tr>
        <tr class="for-fair">
            <td class="label"><?php echo FSText::_('Số hợp đồng đã ký kết'); ?>:</td>
            <td colspan="3">
                <input id="number_contracts_signed" name="number_contracts_signed" type="text" class="form w215px" />
            </td>
        </tr>
        <tr class="for-fair">
            <td class="label"><?php echo FSText::_('Doanh thu tại chỗ'); ?>:</td>
            <td colspan="3">
                <input id="revenue_spot_vnd" name="revenue_spot_vnd" type="text" class="form w215px" />&nbsp;(VNĐ)&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="revenue_spot_usd" name="revenue_spot_usd" type="text" class="form w215px" />&nbsp;(USD)
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Tình trạng hoạt động'); ?>:</td>
            <td colspan="3">
                <?php foreach($arrOperationalStatus as $key=>$val){ ?>
                    <input type="radio" name="status" id="status<?php echo $key ?>" value="<?php echo $key ?>" /><label for="status<?php echo $key ?>"><?php echo $val ?></label>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="label">&nbsp;</td>
            <td colspan="3">
                <input type="submit" value="<?php echo FSText::_('Thêm mới'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="task" value="do_save"/>
    <input type="hidden" name="view" value="activate"/>
    <input type="hidden" name="data_id" id="data_id" value="0"/>
    </form>
</div><!--end: .content-inner-->
<script type="text/javascript">

$(document).ready(function(){
    $("#start_date").datepicker({ dateFormat: "dd/mm/yy"});
    $("#finish_date").datepicker({ dateFormat: "dd/mm/yy"});
    $('#program').change(function(){
        if($(this).val() == 3) 
            $('.program-city').show();
        else
            $('.program-city').hide();
    });
    $('#btn_activity_participants').click(function(){
        $('#activity_participants').click();
    });
});

function filterOutcome(){
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=activate&raw=1&task=filter_outcome',
		data: 'program='+$('#program').val()+'&activity_type='+$('#activity_type').val(),
        success : function($json){
            if($json.error == false)
                $('#activity_plan_id').html($json.html);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
</script>
<input type="hidden" id="data-role" value="statistics-activate-create" />