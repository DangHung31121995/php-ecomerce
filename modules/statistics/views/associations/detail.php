<?php
global $tmpl, $arrActivityType, $arrProgram, $arrCapacityBuilding, $arrCapacityBuildingNote, $user;
if(IS_ADMIN || (isset($user->userID) && ($user->userInfo->code == $data->code))){
    $isLock = 0;
    $tmpl->addScript('jquery.jeditable', 'libraries/jquery', 'top');
    $tmpl->addScript('associations.capacitybuilding', 'modules/statistics/assets/js', 'top');
    $tmpl->addScript('associations.realtime.statistics', 'modules/statistics/assets/js', 'top');
    $tmpl->addScript('associations', 'modules/statistics/assets/js');
}else{
    $isLock = 1;
}
//$tmpl->addScript('jquery.jeditable', 'libraries/jquery', 'top');
//$tmpl->addScript('associations.capacitybuilding', 'modules/statistics/assets/js', 'top');
//$tmpl->addScript('associations.realtime.statistics', 'modules/statistics/assets/js', 'top');
//$tmpl->addScript('associations', 'modules/statistics/assets/js');
$tmpl->addScript('thickbox');
$tmpl->addStylesheet('thickbox'); 
//$tmpl->addStylesheet('dataTables.fixedColumns');
//$tmpl->addStylesheet('jquery.dataTables');
//$tmpl->addScript('jquery.dataTables');
//$tmpl->addScript('dataTables.fixedColumns');
?>
<style>
.edit-capacity-building input{
    max-width: 100% !important;
}
</style>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo') ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Báo cáo của') ?> <?php echo $data->agencies_title ?></div>
    <table class="table-form">
        <tr>
            <td class="label w110px"><?php echo FSText::_('Chương trình') ?>:</td>
            <td>
                <select id="program" name="program" class="form w215px" onchange="window.location=this.value;">
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($program == $key) echo 'selected="selected"'; ?> value="<?php echo FSRoute::_('index.php?module=statistics&view=associations&task=detail&id='.$data->id.'&program='.$key) ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <div class="box-return" style="width: 970px">
        <table id="data-table-return" class="data-table border" style="table-layout: fixed;">
            <tr class="bg-gray">
                <td class="white bg-yellow bold" style="width: 310px !important;"><?php echo FSText::_('Kết quả về nâng cao năng lực chung') ?></td>
                <td class="no-input" style="width: 300px;"></td>
                <?php 
                $year = date('Y'); 
                $arrColspan = array();
                foreach($arrQuarterCurrent as $key=>$val){ ?>
                    <?php if($val['quarter'] == 4){ ?>
                        <td class="w110px center bold">
                            <?php if($year == $val['year']){ ?>
                                Q<?php echo $val['quarter'] ?> (<?php echo FSText::_('cả năm'); ?> <?php echo $val['year'] ?>)
                            <?php }else{ ?>
                                <?php echo $val['year'] ?>
                            <?php } ?>
                        </td>
                    <?php 
                    }else{
                        if(isset($arrColspan[$val['year']]['colspan']))
                            $arrColspan[$val['year']]['colspan']++;
                        else
                            $arrColspan[$val['year']]['colspan'] = 1;
                    ?>
                        <td class="w110px center bold">Q<?php echo $val['text'] ?></td>
                    <?php } ?>
                <?php } ?>
            </tr>
            <?php foreach($arrCapacityBuilding as $k=>$v){?>
                <tr>
                    <td class="white bg-yellow"><?php echo $v ?></td>
                    <td class="<?php if($arrCapacityBuildingNote[$k] == '') echo 'no-input' ?>"><?php echo $arrCapacityBuildingNote[$k]; ?></td>
                    <?php foreach($arrQuarterCurrent as $key=>$val){ ?>
                        <?php if($val['quarter'] == 4){ ?>
                            <td class="center">
                                <?php if(in_array($k, array('provincial_building_strategy', 'business_organizations', 'business_survey', 'business_complete_database', 'business_benchmarking'))){ ?>
                                    <input class="checkbox-capacity-building" id="<?php echo $program ?>|<?php echo $data->code ?>|<?php echo $val['quarter'] ?>|<?php echo $val['year'] ?>|<?php echo $k ?>" type="checkbox" <?php if(isset($dataCapacityBuilding[$val['year']][$val['quarter']][$k]) && $dataCapacityBuilding[$val['year']][$val['quarter']][$k]) echo 'checked="checked"'; ?> />
                                <?php }else{ ?>
                                    <span id="<?php echo $program ?>|<?php echo $data->code ?>|<?php echo $val['quarter'] ?>|<?php echo $val['year'] ?>|<?php echo $k ?>" class="edit-capacity-building" style="display: inline;"><?php if(isset($dataCapacityBuilding[$val['year']][$val['quarter']][$k])) echo $dataCapacityBuilding[$val['year']][$val['quarter']][$k]; else echo '0'; ?></span>
                                <?php } ?>
                            </td>
                        <?php }elseif(in_array($k, array('provincial_building_strategy', 'business_organizations', 'business_survey', 'business_complete_database', 'business_benchmarking', 'xttm_open_new', 'business_receiving_support', 'business_user_products', 'business_satisfaction'))){ ?>
                            <?php if($val['quarter'] == 1){ ?>
                                <td class="center" colspan="<?php echo $arrColspan[$val['year']]['colspan'] ?>">
                                    <span id="<?php echo $program ?>|<?php echo $data->code ?>|<?php echo 1 ?>|<?php echo $val['year'] ?>|<?php echo $k ?>" class="edit-capacity-building" style="display: inline;"><?php if(isset($dataCapacityBuilding[$val['year']][1][$k])) echo $dataCapacityBuilding[$val['year']][1][$k]; else echo '0'; ?></span>
                                </td>
                            <?php } ?>
                        <?php }else{ ?>
                            <td class="center"><span id="<?php echo $program ?>|<?php echo $data->code ?>|<?php echo $val['quarter'] ?>|<?php echo $val['year'] ?>|<?php echo $k ?>" class="edit-capacity-building" style="display: inline;"><?php if(isset($dataCapacityBuilding[$val['year']][$val['quarter']][$k])) echo $dataCapacityBuilding[$val['year']][$val['quarter']][$k]; else echo '0'; ?></span></td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>    
        <?php /* <script type="text/javascript">
            $(document).ready(function() {
                var table = $('#data-table-return').DataTable( {
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         false
                } );
             
                new $.fn.dataTable.FixedColumns( table, {
                    leftColumns: 1
                } );
            } );
        </script> */ ?>
    </div><!--end: .box-return--><br /><br />
    <table class="data-table border" style="table-layout: fixed; width: 585px;">
        <?php $cQuarter = getCurrentQuarter() ?>
        <tr>
            <td style="width: 255px;"><b class="blue"><?php echo FSText::_('Các hoạt động triển khai trong quý') ?> <?php echo $cQuarter['text'] ?></b> <!--(theo thời gian thực)--></td>
            <td class="w110px center bg-blue white"><?php echo FSText::_('Tham gia cùng Chương trình') ?></td>
            <td class="w110px center bg-blue white"><?php echo FSText::_('Tự triển khai') ?></td>
            <td class="w110px center bg-blue white"><?php echo FSText::_('Tổng cộng') ?></td>
        </tr>
        <tr>
            <td class="bg-blue white"><?php echo FSText::_('Số cán bộ tham gia') ?></td>
            <td id="cb-in" class="center"></td>
            <td id="cb-out" class="center"></td>
            <td id="cb-total" class="center"></td>
        </tr>
        <tr>
            <td class="bg-blue white"><?php echo FSText::_('Số DN tham gia') ?></td>
            <td id="dn-in" class="center"></td>
            <td id="dn-out" class="center"></td>
            <td id="dn-total" class="center"></td>
        </tr>
        <?php foreach($arrActivityType as $key=>$val){ ?>
            <tr>
                <td class="bg-blue white"><?php echo $val ?></td>
                <td id="<?php echo $key ?>-in" class="center"></td>
                <td id="<?php echo $key ?>-out" class="center"></td>
                <td id="<?php echo $key ?>-total" class="center"></td>
            </tr>
        <?php } ?>
    </table>
    <br /><br />     
    <div class="ci-heading"><?php echo FSText::_('Kết quả của các DN trong tỉnh tham gia Chương trình') ?></div>
    <table class="data-table border data-link" style="table-layout: fixed; width: 805px;">
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Tăng trưởng doanh thu xuất khẩu của các DNNVV tham gia Chương trình') ?></td>
            <td>- <?php echo FSText::_('Top 5 doanh nghiệp tốt nhất')?> - <a class="view-business" data-key="export_sales" href="javascript:void(0);"><?php echo FSText::_('xem bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);"> xem bài học kinh nghiệm</a></td> */ ?>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Tăng trưởng doanh số bán hàng của các DNNVV tham gia Chương trình') ?></td>
            <td>- <?php echo FSText::_('Top 5 doanh nghiệp tốt nhất')?> - <a class="view-business" data-key="sales" href="javascript:void(0);"><?php echo FSText::_('xem bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td> */ ?>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Số thị trường mới mở của các DN tham gia Chương trình trong kỳ báo cáo') ?></td>
            <td>- <?php echo FSText::_('Top 5 doanh nghiệp tốt nhất')?> - <a class="view-business" data-key="new_markets" href="javascript:void(0);"><?php echo FSText::_('xem bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td>*/ ?>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Số khách hàng mới của các DN tham gia Chương trình trong kỳ báo cáo') ?></td>
            <td>- <?php echo FSText::_('Top 5 doanh nghiệp tốt nhất')?> - <a class="view-business" data-key="new_clients" href="javascript:void(0);"><?php echo FSText::_('xem bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td>*/ ?>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Số DN có sản phẩm xuất khẩu mới') ?></td>
            <td>- <?php echo FSText::_('Top 5 doanh nghiệp tốt nhất')?> - <a class="view-business" data-key="new_products" href="javascript:void(0);"><?php echo FSText::_('xem bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td>*/ ?>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 280px;"><?php echo FSText::_('Bài học kinh nghiệm chung') ?></td>
            <td><a class="view-city" data-key="outcome" href="javascript:void(0);"><?php echo FSText::_('Tổng hợp bài học kinh nghiệm')?></a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td>*/ ?>
        </tr>
        <!--<tr>
            <td class="bg-gray" style="width: 280px;">Thay đổi số cán bộ của tỉnh có kiến thức về ngành hàng</td>
            <td>- Top 5 doanh nghiệp tốt nhất - <a class="view-business" data-key="export_sales" href="javascript:void(0);">bài học kinh nghiệm</a></td>
            <?php /* <td class="no-input">- Tốp 3 ngành hàng tốt nhất -  <a href="javascript:void(0);">bài học kinh nghiệm</a></td>*/ ?>
        </tr>-->
    </table><br /><br />
</div><!--end: .content-inner-->
<input type="hidden" id="member_code" name="member_code" value="<?php echo $data->code ?>"  />
<input type="hidden" id="member_city" name="member_city" value="<?php echo $data->city_id ?>"  />
<input type="hidden" id="data-role" value="statistics-associations-display" />