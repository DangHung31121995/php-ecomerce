<?php
global $tmpl, $arrActivityType;
$tmpl->addScript('plan', 'modules/statistics/assets/js');
?>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo') ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Danh sách các TT, Hiệp hội') ?></div>
    <form id="frm_associations" action="<?php echo FSRoute::_('index.php?module=statistics&view=associations'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b><?php echo FSText::_('Lọc kết quả theo') ?>:</b>&nbsp;
                <?php $city_id = FSInput::get('city_id', 0); ?>
                <select id="city_id" name="city_id" class="form">
                    <option value="0">-- <?php echo FSText::_('Tỉnh/Tp'); ?> --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($city_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <input type="submit" value="<?php echo FSText::_('Tìm kiếm'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="view" value="associations"/>
    </form>
    <table class="data-table" style="width:900px">
        <tr class="bg-yellow white">
            <td class="bold center"><?php echo FSText::_('STT') ?></td>
            <td class="bold center"><?php echo FSText::_('Tên Trung tâm, Hiệp hội') ?></td>
            <td class="bold center"><?php echo FSText::_('Tỉnh') ?></td>
            <td class="bold center"><?php echo FSText::_('Số đơn vị tham gia') ?></td>
            <td class="bold center"><?php echo FSText::_('Báo cáo') ?></td>
        </tr>
        <?php
        $i = 0; 
        foreach($list as $item){
            $i++;
        ?>
            <tr>
                <td class="center"><?php echo $i ?></td>
                <td><a target="_blank" class="link" href="/index.php?module=statistics&view=associations&task=detail&id=<?php echo $item->id ?>"><?php echo $item->agencies_title ?></a></td>
                <td><?php echo $cities[$item->city_id] ?></td>
                <td class="center">1</td>
                <td class="center"><a target="_blank" class="detail" href="/index.php?module=statistics&view=associations&task=detail&id=<?php echo $item->id ?>">Lập báo cáo</a></td>
            </tr>
        <?php } ?>
    </table>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-associations-display" />