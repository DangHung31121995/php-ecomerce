<div class="tbpopup-title">
    Kết quả và bài học kinh nghiệm
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <form onsubmit="return get_lessons_learned();" id="frm_lessons_learned" action="<?php echo FSRoute::_('index.php?module=statistics&view=program&show_lessons_learned&raw=1'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b><?php echo FSText::_('Lọc kết quả theo'); ?>:</b>&nbsp;
                <?php $activity_city = FSInput::get('activity_city', 0); ?>
                <select id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tỉnh'); ?> --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($activity_city == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_type = FSInput::get('activity_type', 0); ?>
                <select id="activity_type" name="activity_type" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Chọn loại hình'); ?> --</option>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <option <?php if($activity_type == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $commodity_id = FSInput::get('commodity_id', 0); ?>
                <select id="commodity_id" name="commodity_id" class="form">
                    <option value="0">-- <?php echo FSText::_('Ngành hàng'); ?> --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option <?php if($commodity_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <input type="checkbox" id="my_plan" name="my_plan" value="1" />&nbsp;<label for="my_plan"><?php echo FSText::_('Báo cáo của tôi') ?></label>&nbsp;&nbsp;
                <?php echo FSText::_('Từ'); ?> <div class="bound-calendar"><input style="width:75px" id="start_date" name="start_date" type="text" class="form" value="<?php echo date('d/m/Y') ?>" /></div>&nbsp;&nbsp;
                <?php echo FSText::_('Đến'); ?> <div class="bound-calendar"><input style="width:75px" id="finish_date" name="finish_date" type="text" class="form calendar" value="<?php echo date('d/m/Y') ?>" /></div>
                <input type="submit" value="<?php echo FSText::_('Xem bài học') ?>" />&nbsp;
                <a href="<?php echo FSRoute::_('index.php?module=statistics&view=program&raw=1&task=excel_lessons_learned') ?>" class="export excel" title="Xuất ra Excel">Xuất ra Excel</a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="program"/>
    <input type="hidden" name="task" value="show_lessons_learned"/>
    </form>
    <table id="tbl_participants" class="data-table">
        <tr class="bg-gray blue center bold" style="table-layout: fixed;">
            <td style="width: 45px;"><?php echo FSText::_('STT'); ?></td>
            <td style="width: 160px;"><?php echo FSText::_('Loại hình hoạt động'); ?></td>
            <td style="width: 120px;"><?php echo FSText::_('Ngành hàng'); ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Tỉnh') ?></td>
            <td style="width: 150px;"><?php echo FSText::_('Số người tham gia') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Số gian hàng') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Số lượt khách') ?></td>
            <td style="width: 100px;"><?php echo FSText::_('Số giao dịch') ?></td>
            <td><?php echo FSText::_('Kết quả và bài học kinh nghiệm'); ?></td>
        </tr>
        <?php 
        $i = 0;
        foreach($list as $item){ 
            $i++;
        ?>
            <tr class="tr-item">
                <td class="center"><?php echo $i ?></td>
                <td><?php echo @$arrActivityType[$item->activity_type] ?></td>
                <td><?php echo @$arrIndustries[$item->commodity_id] ?></td>
                <?php if($item->city_id){ ?>
                    <td><?php echo @$cities[intval($item->city_id)] ?></td>
                <?php }else{ ?>
                    <td>Toàn quốc</td>
                <?php } ?>
                <td class="center">
                    <?php if($item->number_participants){ ?>
                        <?php echo $item->number_participants ?>
                    <?php } ?>
                    <?php if($item->number_participants_females){ ?>
                        (<?php echo $item->number_participants_females ?> nữ)
                    <?php } ?>
                </td>
                <td><?php if($item->number_participants){ ?><?php echo $item->booth_number ?><?php } ?></td>
                <td><?php if($item->number_visitors){ ?><?php echo $item->number_visitors ?><?php } ?></td>
                <td><?php if($item->number_transactions){ ?><?php echo $item->number_transactions ?><?php } ?></td>
                <td><?php echo $item->outcome ?></td>
            </tr>
        <?php } ?>
    </table>
</div><!--end: .tbpopup-content-->