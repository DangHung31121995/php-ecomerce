<?php
global $tmpl, $arrActivityType, $arrIndustries;
$tmpl->addScript('plan', 'modules/statistics/assets/js');
?>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo'); ?> 
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Danh sách các doanh nghiệp'); ?> </div>
    <form id="frm_members" action="<?php echo FSRoute::_('index.php?module=statistics&view=business'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b><?php echo FSText::_('Lọc kết quả theo'); ?>:</b>&nbsp;
                <?php $city_id = FSInput::get('city_id', 0); ?>
                <select id="city_id" name="city_id" class="form">
                    <option value="0">-- <?php echo FSText::_('Tỉnh/Tp'); ?> --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($city_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $commodity_id = FSInput::get('commodity_id', 0); ?>
                <select id="commodity_id" name="commodity_id" class="form">
                    <option value="0">-- <?php echo FSText::_('Ngành hàng'); ?> --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option <?php if($commodity_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <input type="text" name="keyword" id="keyword" class="form w215px" placeholder="<?php echo FSText::_('Nhập tên doanh nghiệp cần tìm'); ?>..." />&nbsp;
                <input type="submit" value="<?php echo FSText::_('Tìm kiếm'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="business"/>
    </form>
    <table class="data-table" style="width:900px">
        <tr class="bg-yellow white">
            <td style="width: 75px;" class="bold center"><?php echo FSText::_('STT'); ?></td>
            <td class="bold center"><?php echo FSText::_('Tên doanh nghiệp'); ?></td>
            <td style="width: 125px;" class="bold center"><?php echo FSText::_('Tỉnh'); ?></td>
            <td style="width: 125px;" class="bold center"><?php echo FSText::_('Ngành hàng'); ?></td>
        </tr>
        <?php 
        $i = 0;
        foreach($list as $item){ 
            $i++;
        ?>
            <tr>
                <td class="center"><?php echo $i ?></td>
                <td><a target="_blank" class="link" href="/index.php?module=statistics&view=business&task=detail&id=<?php echo $item->id ?>"><?php echo $item->agencies_title ?></a></td>
                <td><?php echo @$cities[$item->city_id] ?></td>
                <td><?php echo @$arrIndustries[$item->commodity_id] ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-business-display" />