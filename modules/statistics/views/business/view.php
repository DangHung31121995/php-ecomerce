<?php
global $arrEdp;
$isLock = 1;
?>
<div class="event-title">
    <?php echo FSText::_('Lập báo cáo'); ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading">
        <?php echo FSText::_('Báo cáo của Doanh nghiệp'); ?>
        <div style="float: right;">
            <a href="javascript:void(0);" class="export word functions_built" title="Xuất ra Word">Xuất ra Word</a>&nbsp;
            <a href="javascript:void(0);" class="export excel functions_built" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
            <a href="javascript:void(0);" class="export print functions_built" title="In trang này">In trang này</a>
        </div>
    </div>
    <table class="table-form">
        <tr>
            <td class="label w110px"><?php echo FSText::_('Chương trình'); ?>:</td>
            <td>
                <select id="program" name="program" class="form w215px" onchange="window.location=this.value;">
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($program == $key) echo 'selected="selected"'; ?> value="<?php echo FSRoute::_('index.php?module=statistics&view=business&task=detail&id='.$data->id.'&program='.$key) ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <table class="data-table data-table-v2" style="width: 810px; table-layout: fixed;">
        <tr class="bg-gray">
            <td class="blue bold" colspan="2"><?php echo FSText::_('Thông tin cơ bản'); ?></td>
        </tr>
        <tr>
            <td style="width: 235px" class="bold"><?php echo FSText::_('Tên'); ?></td>
            <td><?php echo $data->agencies_title ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('Địa chỉ'); ?></td>
            <td><?php echo $data->address ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('Chủ doanh nghiệp'); ?></td>
            <td><?php echo $data->fullname ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('Số lao động'); ?></td>
            <td><?php echo $data->some_staff ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('Ngành hàng'); ?></td>
            <td><?php echo $arrIndustries[$data->commodity_id] ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('Tham gia Chương trình từ ngày'); ?> </td>
            <td><?php echo date('d/m/Y', strtotime($data->created_time)); ?></td>
        </tr>
        <tr>
            <td class="bold"><?php echo FSText::_('EDP'); ?> </td>
            <td>
                <?php foreach($arrEdp as $key=>$val){ ?>
                    <input disabled="disabled" <?php if($key==$data->edp) echo 'checked="checked"'; ?> id="edp<?php echo $key ?>" name="edp" type="radio" value="<?php echo $key ?>" /><label for="edp<?php echo $key ?>"><?php echo $val ?></label><br />
                <?php } ?>
            </td>
        </tr>
        <?php if($industrier || $industrierTQ){?>
            <tr>
                <td colspan="2" class="bold red">
                    <?php echo FSText::_('Báo cáo cho'); ?> 
                    <?php if($industrier){ ?><?php echo $industrier->fullname ?> (<?php echo $industrier->code ?>) - <?php } ?>
                    <?php if($industrierTQ){ ?><?php echo $industrierTQ->fullname ?> (<?php echo $industrierTQ->code ?>)<?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table><br />
    <div class="box-return" style="width: 810px">
    <table class="data-table border" style="table-layout: fixed;">
        <tr>
            <td class="w265px bold white bg-blue"><?php echo FSText::_('Kết quả kinh doanh'); ?></td>
            <?php foreach($arrCurrentOutcome as $key=>$val){ ?>
                <td class="center bold">Q<?php echo $val['text'] ?></td>
            <?php } ?>
        </tr>
        <?php foreach($arrBusinessResults as $key=>$val){ ?>
            <tr>
                <td class="w265px <?php if(in_array($key, array('export_sales', 'sales', 'named_limited_view'))) echo 'red'; ?> <?php if($key == 'named_limited_view') echo 'text-right'; ?>"><?php echo $val ?></td>
                <?php foreach($arrCurrentOutcome as $akey=>$aval){ ?>
                    <td>
                        <span id="<?php echo $data->code ?>|<?php echo $aval['quarter'] ?>|<?php echo $aval['year'] ?>|<?php echo $key ?>" class="clickedit" style="display: inline;"><?php 
                            if(isset($dataBusinessResults[$key][$aval['year']][$aval['quarter']])){ 
                                if(in_array($key, array('outcome', 'named_limited_view')))
                                    $_value = $dataBusinessResults[$key][$aval['year']][$aval['quarter']]; 
                                else
                                    $_value = number_format($dataBusinessResults[$key][$aval['year']][$aval['quarter']], 0, ',', '.');
                                if(in_array($key, array('export_sales', 'sales', 'named_limited_view')))
                                    if(IS_ADMIN || (isset($user->userID) && ($user->userInfo->code == $data->code || in_array($user->userInfo->type, array(1,2)))))
                                        echo $_value;
                                    else
                                        echo '...';
                                else
                                    echo $_value;
                            }else{ 
                                if($key == 'outcome') 
                                    echo '...'; 
                                elseif($key == 'named_limited_view')
                                    echo '...';
                                else 
                                    echo '0'; 
                            } 
                            ?></span>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
    </div><!--end: .box-return-->
    <div class="ci-heading"><?php echo FSText::_('Kết quả từ các hoạt động đã tham gia với chương trình'); ?></div>
    <?php
    foreach($listActivities as $item){
        $arrOutcome = array();
        foreach($arrActivityKeyTime as $key){
            if(in_array($key, array('after', 'empirical')))
                continue;
            if($key == 'after1month'){
                $arrOutcome[$key]['text'] = 'Ngay sau 1 tháng'; 
                $arrOutcome[$key]['year'] = 0;
                $arrOutcome[$key]['quarter'] = 0;
                continue;
            }
            $arrOutcome[$key] = getQuarterText($item->start_date, $key);
        }
    ?>
    <div class="box-return" style="width: 810px">
        <table class="data-table border" style="width: 1525px;  table-layout: fixed;">
            <tr class="bold">
                <td class="w200px bg-blue white">(<?php echo FSText::_('Tự popup từ báo cáo HĐ'); ?>)</td>
                <?php foreach($arrOutcome as $key=>$val){ ?>
                    <td class="w265px"><?php echo $val['text'] ?></td>
                <?php } ?>
            </tr>
            <tr class="bold">
                <td class="w200px bg-blue white">
                    <?php echo $arrActivityType[$item->activity_type] ?><br />
                    <span style="font-weight: normal;"><?php echo FSText::_('Địa chỉ')?>: <?php echo $item->activity_address ?></span><br />
                    <span style="font-weight: normal;"><?php echo date('d/m/Y', strtotime($item->start_date)); ?> - <?php echo date('d/m/Y', strtotime($item->start_date)); ?></span>
                </td>
                <?php foreach($arrOutcome as $key=>$val){  ?>
                    <?php if(!in_array($item->activity_type, array(3,4,5,6))){ ?>
                        <td class="w265px"><span style="font-weight: normal;" id="<?php echo $data->code ?>|<?php echo $item->id; ?>|<?php echo $key ?>|outcome|<?php echo $val['year'] ?>|<?php echo $val['quarter'] ?>" class="clickedit-outcome"><?php if(isset($dataBusinessOutcome[$item->id][$key]['outcome'])) echo $dataBusinessOutcome[$item->id][$key]['outcome']; else echo '...';  ?></span></td>
                    <?php }else{ ?>
                        <td class="w265px">
                            <table class="table-form sub" style="table-layout: fixed;">
                                <tr>
                                    <td class="w200px"><?php echo FSText::_('Số khách hàng mới'); ?>:</td>
                                    <td class="center"><?php if(isset($dataBusinessOutcome[$item->id][$key]['customers'])) echo number_format($dataBusinessOutcome[$item->id][$key]['customers'], 0, ',', '.');?></td>
                                </tr>
                                <tr>
                                    <td class="w200px"><?php echo FSText::_('Số hợp đồng mới'); ?>:</td>
                                    <td class="center"><?php if(isset($dataBusinessOutcome[$item->id][$key]['contracts'])) echo number_format($dataBusinessOutcome[$item->id][$key]['contracts'], 0, ',', '.');?></td>
                                </tr>
                                <tr>
                                    <td class="w200px"><?php echo FSText::_('Giá trị hợp đồng').' ('.FSText::_('triệu đồng').')'; ?>:</td>
                                    <td class="center"><?php if(isset($dataBusinessOutcome[$item->id][$key]['contractsvalue'])) echo number_format($dataBusinessOutcome[$item->id][$key]['contractsvalue'], 0, ',', '.');?></td>
                                </tr>
                            </table>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
            <?php if(in_array($item->activity_type, array(3,4,5,6))){ ?>
                <tr class="bold">
                    <td class="w200px bg-yellow white"><?php echo FSText::_('Bài học kinh nghiệm'); ?></td>
                    <?php foreach($arrOutcome as $key=>$val){ ?>
                        <td class="w265px">
                            <span style="font-weight: normal;" id="<?php echo $data->code ?>|<?php echo $item->id; ?>|<?php echo $key ?>|outcome|<?php echo $val['year'] ?>|<?php echo $val['quarter'] ?>" class="clickedit-outcome"><?php if(isset($dataBusinessOutcome[$item->id][$key]['outcome'])) echo $dataBusinessOutcome[$item->id][$key]['outcome']; else echo '...';  ?></span>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div><!--end: .box-return--><br />
    <?php } ?>
    <!--<a href="javascript:void(0);" class="export word functions_built" title="Xuất ra Word">Xuất ra Word</a>&nbsp;
    <a href="javascript:void(0);" class="export excel functions_built" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
    <a href="javascript:void(0);" class="export print functions_built" title="In trang này">In trang này</a>-->
    <?php /* <input type="submit" value="Nộp báo cáo" />
    <input class="yellow" type="button" value="Phê duyệt báo cáo" /> */ ?>
    <br /><br />
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-business-list" />
<input type="hidden" id="member_code" name="member_code" value="<?php echo $data->code ?>" />