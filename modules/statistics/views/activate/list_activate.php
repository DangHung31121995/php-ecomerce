<?php 
global $tmpl, $arrActivityType, $arrIndustries, $arrRegions, $arrProgram;
?>
<div class="event-title">
    <?php echo FSText::_('Xem báo cáo'); ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Báo cáo hoạt động'); ?></div>
    <form id="frm_statistics" action="<?php echo FSRoute::_('index.php?module=statistics&view=activate&task=list_activate'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b><?php echo FSText::_('Lọc kết quả theo'); ?>:</b>&nbsp;
                <?php $program = FSInput::get('program', 0); ?>
                <select id="program" name="program" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Chọn chương trình'); ?> --</option>
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($program == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_city = FSInput::get('activity_city', 0); ?>
                <select id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tỉnh'); ?> --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($activity_city == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_type = FSInput::get('activity_type', 0); ?>
                <select id="activity_type" name="activity_type" class="form w110px">
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
                <?php $activity_month = FSInput::get('activity_month', 0); ?>
                <select id="activity_month" name="activity_month" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Tháng') ?> --</option>
                    <?php for($i=1; $i<=12; $i++){ ?>
                        <option <?php if($activity_month == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $activity_year = FSInput::get('activity_year', 0); ?>
                <select id="activity_year" name="activity_year" class="form w110px">
                    <option value="0">-- <?php echo FSText::_('Năm') ?> --</option>
                    <?php $year = date('Y') + 1; ?>
                    <?php for($i=2010; $i<=$year; $i++){ ?>
                        <option <?php if($activity_year == $i) echo 'selected="selected"'; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $keyword = FSInput::get('keyword', ''); ?>
                <input type="text" name="keyword" id="keyword" class="form w110px" placeholder="<?php echo FSText::_('Mã outcome'); ?>..." value="<?php echo $keyword ?>" />&nbsp;
                <input type="submit" value="<?php echo FSText::_('Tìm kiếm'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="activate"/>
    <input type="hidden" name="task" value="list_activate"/>
    </form>
    <table class="data-table" style="width:1000px; table-layout: fixed;">
        <tr class="bg-gray">
            <td class="bold center"><?php echo FSText::_('Chương trình'); ?></td>
            <td class="bold"><?php echo FSText::_('Tên đơn vị'); ?></td>
            <td class="bold"><?php echo FSText::_('Tên hoạt động'); ?></td>
            <td class="bold center"><?php echo FSText::_('Loại hình'); ?></td>
            <td class="bold center"><?php echo FSText::_('Ngành hàng'); ?></td>
            <td class="bold center"><?php echo FSText::_('Địa điểm'); ?></td>
            <td class="bold center"><?php echo FSText::_('Thời gian'); ?></td>
            <td class="bold center"><?php echo FSText::_('Xem'); ?></td>
        </tr>
        <?php foreach($list as $item){ ?>
            <tr>
                <td>0<?php echo $item->program ?></td>
                <td><?php echo $item->agencies_title; ?></td>
                <td><?php echo $item->title; ?></td>
                <td><?php echo @$arrActivityType[$item->activity_type]; ?></td>
                <td><?php echo @$arrIndustries[$item->commodity_id]; ?></td>
                <td><?php echo $item->activity_address; ?><?php // echo @$cities[$item->activity_city]; ?></td>
                <td><?php echo date('d/m/Y', strtotime($item->start_date)); ?> - <?php echo date('d/m/Y', strtotime($item->finish_date)); ?></td>
                <td class="center"><a class="view" href="/index.php?module=statistics&view=activate&task=view&id=<?php echo $item->id ?>"><?php echo FSText::_('Xem'); ?></a></td>
            </tr>
        <?php } ?>
    </table>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-activate-list" />