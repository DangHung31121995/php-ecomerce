<?php
global $tmpl, $arrActivityType, $arrProgram, $user;
$tmpl->addScript('plan', 'modules/statistics/assets/js');
?>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo') ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Lập kế hoạch quý') ?></div>
    <form id="frmAddPlan" action="/index.php?module=statistics&view=plan&task=create" method="post" onsubmit="return validAddPlan();">
    <table class="table-form">
        <tr>
            <td class="label"><?php echo FSText::_('Chương trình') ?>:</td>
            <td class="input" style="width: 240px;">
                <select id="program" name="program" class="form w215px">
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if(@$data->program == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
            <td rowspan="9" style="vertical-align: top;">
                <div style="padding-left: 15px;">
                    <p><b>1. Chương trình "Nâng cao năng lực cạnh tranh xuất khẩu cho các DNNVV Việt Nam thông qua hệ thống XTTM địa phương"</b>, do Chính phủ Thụy Sỹ tài trợ thông qua Cục kinh tế Liên bang Thụy Sĩ (SECO), 2014 – 2017</p>
                    <p><b>2. Chương trình Xúc tiến Thương mại Quốc gia</b></p>
                    <p><b>3. Chương trình hỗ trợ doanh nghiệp nâng cao năng lực thiết kế, phát triển sản phẩm Việt Nam - Hàn Quốc</b>, do Cục Xúc tiến thương mại phối hợp với Viện Xúc tiến thiết kế Hàn Quốc (KIDP)- Bộ Thương mại, Công nghiệp và Năng lượng Hàn Quốc thực hiện.</p>
                    <p><b>4. Chương trình CBI (Cơ quan Xúc tiến và nhập khẩu từ các nước đang phát triển của Hà Lan)</b>, hỗ trợ các doanh nghiệp thuộc 4 ngành hàng xuất khẩu là thủ công mỹ nghệ, may mặc thời trang, thực phẩm chế biến và sản phẩm công nghiệp xuất khẩu hàng hóa sang thị trường châu Âu.</p>
                    <p><b>5. Khác- chương trình của tỉnh</b></p>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Mã outcome') ?>:</td>
            <td class="input">
                <input id="outcome_code" name="outcome_code" class="form w215px" type="text" value="<?php echo @$data->outcome_code ?>" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Mã hoạt động') ?>:</td>
            <td class="input">
                <input id="activity_code" name="activity_code" class="form w215px" type="text" value="<?php echo @$data->activity_code ?>" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Tên hoạt động') ?>:</td>
            <td class="input">
                <input id="activity_title" name="activity_title" class="form w215px" type="text" value="<?php echo @$data->activity_title ?>" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Loại hình') ?>:</td>
            <td class="input">
                <select id="activity_type" name="activity_type" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Chọn loại hình') ?> --</option>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <option <?php if(@$data->activity_type == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Thời gian') ?>: </td>
            <td class="input">
                <select id="activity_month" name="activity_month" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tháng') ?> --</option>
                    <?php for($i=1; $i<=12; $i++){ ?>
                        <option <?php if(@$data->activity_month == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
                <select id="activity_year" name="activity_year" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Năm') ?> --</option>
                    <?php $year = date('Y') + 1; ?>
                    <?php for($i=2010; $i<=$year; $i++){ ?>
                        <option <?php if(@$data->activity_year == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Địa điểm') ?>:</td>
            <td class="input">
                <input id="activity_address" name="activity_address" class="form w215px" type="text" value="<?php echo @$data->activity_address ?>" />
                <?php /* <select id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- Vùng --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select> */ ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Ngân sách dự kiến') ?>:</td>
            <td class="input">
                <input id="budget_expected" name="budget_expected" class="form w215px text-right" type="text" value="<?php echo @$data->budget_expected ?>" >
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td class="input">
                <?php if(isset($data)){ ?>
                    <input type="submit" value="<?php echo FSText::_('Cập nhật') ?>" />
                    <input type="hidden" name="data_id" id="data_id" value="<?php echo $data->id ?>" />
                    <input type="hidden" name="task" value="update"/>
                <?php }else{ ?>
                    <input type="submit" value="<?php echo FSText::_('Thêm mới') ?>" />
                    <input type="hidden" name="data_id" id="data_id" value="0" />
                    <input type="hidden" name="task" value="create"/>
                <?php } ?>
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="plan"/>
    </form>
    <form id="frm_statistics" action="<?php echo FSRoute::_('index.php?module=statistics&view=activate'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b><?php echo FSText::_('Lọc kết quả theo') ?>:</b>&nbsp;
                <?php $program = FSInput::get('program', 0); ?>
                <select id="sprogram" name="sprogram" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Chọn chương trình') ?> --</option>
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($program == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_type = FSInput::get('activity_type', 0); ?>
                <select id="sactivity_type" name="sactivity_type" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Chọn loại hình') ?> --</option>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <option <?php if($activity_type == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_city = FSInput::get('activity_city', 0); ?>
                <select id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tỉnh'); ?> --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($activity_city == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $sactivity_month = FSInput::get('sactivity_month', 0); ?>
                <select id="sactivity_month" name="sactivity_month" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tháng') ?> --</option>
                    <?php for($i=1; $i<=12; $i++){ ?>
                        <option <?php if($sactivity_month == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $sactivity_year = FSInput::get('sactivity_year', 0); ?>
                <select id="sactivity_year" name="sactivity_year" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Năm') ?> --</option>
                    <?php $year = date('Y') + 1; ?>
                    <?php for($i=2010; $i<=$year; $i++){ ?>
                        <option <?php if($sactivity_year == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $my_plan = FSInput::get('my_plan', 0) ?>
                <input <?php if($my_plan == 1) echo 'checked="checked"' ?> type="checkbox" id="my_plan" name="my_plan" value="1" />&nbsp;<label for="my_plan"><?php echo FSText::_('Kế hoạch của tôi') ?></label>&nbsp;&nbsp;
                <input type="submit" value="<?php echo FSText::_('Tìm kiếm'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="plan"/>
    </form>
    <table class="data-table" style="table-layout: fixed;">
        <tr class="bg-gray center bold">
            <td style="width: 70px;"><?php echo FSText::_('Chương trình') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Mã outcome') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Mã hoạt động') ?></td>
            <td><?php echo FSText::_('Tên hoạt động') ?></td>
            <td style="width: 120px;"><?php echo FSText::_('Loại hình') ?></td>
            <td style="width: 110px;"><?php echo FSText::_('Thời gian (tháng)') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Địa điểm (vùng)') ?></td>
            <td style="width: 120px;"><?php echo FSText::_('Ngân sách dự kiến') ?></td>
            <td style="width: 70px;"><?php echo FSText::_('Sửa') ?></td>
            <td style="width: 70px;"><?php echo FSText::_('Xóa') ?></td>
        </tr>
        <?php
        foreach($list as $item) {
        ?>
            <tr>
                <td class="center">0<?php echo $item->program ?></td>
                <td class="center"><?php echo $item->outcome_code ?></td>
                <td><?php echo $item->activity_code ?></td>
                <td><?php echo $item->activity_title ?></td>
                <td><?php echo @$arrActivityType[$item->activity_type] ?></td>
                <td style="text-align: right;"><?php echo $item->activity_month ?>/<?php echo $item->activity_year ?></td>
                <td><?php echo $item->activity_address ?></td>
                <td style="text-align: right;">
                    <?php if(($user->userID && $user->userInfo->code == $item->member_code)  || IS_ADMIN){ ?>
                        <?php echo number_format($item->budget_expected, 0, ',', '.'); ?>
                    <?php } ?>
                </td>
                <td class="center"><a href="<?php echo FSRoute::_('index.php?module=statistics&view=plan&task=edit&id='.$item->id); ?>"><img src="/images/edit.png" /></a></td>
                <td class="center"><a onclick="delPlan(<?php echo $item->id ?>);" href="javascript:void(0);"><img src="/images/delete.png" /></a></td>
            </tr>
        <?php } ?>
    </table>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-plan-display" />