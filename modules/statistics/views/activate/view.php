<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrRegions, $arrOperationalStatus, $arrProgram;
$tmpl->addStylesheet('activate', 'modules/statistics/assets/css');
$tmpl->addStylesheet('thickbox');
$tmpl->addStylesheet('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addScript('thickbox');
$tmpl->addScript('activate', 'modules/statistics/assets/js');
$tmpl->addScript('jquery-ui', 'libraries/jquery/jquery.ui');
if(IS_ADMIN || (isset($user->userID) && (@$user->userInfo->code == $data->member_code))){
    $isLock = 0;
}else{
    $isLock = 1;
}
?>
<div class="event-title">
    <?php echo FSText::_('Báo cáo hoạt động'); ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading clearfix">
        <?php echo FSText::_('Báo cáo hoạt động'); ?>
        <div style="float: right;">
            <?php if(IS_ADMIN || (isset($user->userID) && (@$user->userInfo->code == $data->member_code)) || (isset($user->userID) && in_array(@$user->userInfo->type, array(1,2)))){ ?>
                <a href="<?php echo FSRoute::_('index.php?module=statistics&view=activate&task=update&id='.$data->id) ?>" class="export edit functions_permission" title="Sửa báo cáo">Sửa báo cáo</a>&nbsp;
                <a href="<?php echo FSRoute::_('index.php?module=statistics&view=activate&raw=1&task=word_activate&id='.$data->id) ?>" class="export word" title="Xuất ra Word">Xuất ra Word</a>&nbsp;
                <a href="<?php echo FSRoute::_('index.php?module=statistics&view=activate&raw=1&task=excel_activate&id='.$data->id) ?>" class="export excel" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
                <a href="javascript:void(0);" class="export print functions_built" title="In trang này">In trang này</a>
            <?php }else{ ?>
                <a href="javascript:void(0);" class="export edit functions_permission" title="Sửa báo cáo">Sửa báo cáo</a>&nbsp;
                <a href="javascript:void(0);" class="export word functions_permission" title="Xuất ra Word">Xuất ra Word</a>&nbsp;
                <a href="javascript:void(0);" class="export excel functions_permission" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
                <a href="javascript:void(0);" class="export print functions_built" title="In trang này">In trang này</a>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix" style="float: right; margin: 7px 0;">
        Use Google Translation <div style="display: inline-block;" id="google_translate_element"></div>
        <script type="text/javascript">
        function googleTranslateElementInit() {
          new google.translate.TranslateElement({pageLanguage: 'vi', includedLanguages: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
        }
        </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </div>
    <form id="frm_activate" action="/index.php?module=statistics&view=activate&task=do_update" method="POST">
    <table class="table-form" style="width: 860px">
        <tr>
            <td class="label"><?php echo FSText::_('Chương trình'); ?>:</td>
            <td class="w355px">
                <select disabled="disabled" id="program" name="program" class="form w215px" onchange="filterOutcome();">
                    <option value="0">-- <?php echo FSText::_('Chọn chương trình'); ?> --</option>
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($data->program == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="note">( <?php echo FSText::_('Bắt buộc'); ?>)</span>
            </td>
            <?php if($data->program == 3){?>
                <td class="label">
                    <span><?php echo FSText::_('Đơn vị')?></span>
                </td>
                <td>
                    <span><?php if($user->userID){ ?>
                        <?php echo $user->userInfo->agencies_title; ?>
                    <?php } ?></span>
                </td>
            <?php }else{ ?>
                <td></td>
                <td></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="label"><?php echo FSText::_('Tên hoạt động'); ?>:</td>
            <td colspan="3">
                <input disabled="disabled" id="title" name="title" type="text" style="width: 716px;" class="form" value="<?php echo $data->title ?>" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Loại hình hoạt động'); ?>:</td>
            <td class="w355px">
                <select disabled="disabled" id="activity_type" name="activity_type" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Chọn loại hình'); ?> --</option>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <option <?php if($data->activity_type == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="note">( <?php echo FSText::_('Bắt buộc'); ?>)</span>
            </td>
            <td class="label"><?php echo FSText::_('Thời gian'); ?>:</td>
            <td>
                <?php echo FSText::_('Từ'); ?> <span class="blue"><?php echo date('d/m/Y', strtotime($data->start_date)) ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo FSText::_('Đến'); ?> <span class="blue"><?php echo date('d/m/Y', strtotime($data->finish_date)) ?></span>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Mã hoạt động'); ?>:</td>
            <td class="w355px">
                <select disabled="disabled" id="activity_plan_id" name="activity_plan_id" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Lựa chọn từ kế hoạch CT'); ?> --</option>
                    <?php foreach($plans as $item){?>
                        <option <?php if($data->activity_plan_id == $item->id) echo 'selected="selected"' ?> value="<?php echo $item->id ?>"><?php echo $item->activity_code.' - '.$item->activity_title ?></option>
                    <?php } ?>
                </select>
                <span class="note">( <?php echo FSText::_('Không bắt buộc'); ?>)</span>
            </td>
            <td class="label"><?php echo FSText::_('Cán bộ phụ trách'); ?>:</td>
            <td>
                <input disabled="disabled" id="city_code" name="city_code" value="<?php if($city) echo $city->fullname; else echo $data->city_code ?>" type="text" class="form w90px" placeholder="Tỉnh (ID)," />&nbsp;&nbsp;
                <input disabled="disabled" id="officers_code" name="officers_code" value="<?php if($officers) echo $officers->fullname; else echo $data->officers_code ?>" type="text" class="form w110px" placeholder="Ngành hàng (ID)" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Ngành hàng'); ?>:</td>
            <td class="w355px">
                <select disabled="disabled" id="commodity_id" name="commodity_id" class="form w215px">
                    <option value="0">-- <?php echo FSText::_('Lựa chọn'); ?> --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option <?php if($data->commodity_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="label"><?php echo FSText::_('Số người tham gia'); ?>:</td>
            <td>
                <input disabled="disabled" id="number_participants" name="number_participants" value="<?php echo $data->number_participants ?>" type="text" class="form w90px" value="20" />&nbsp;Nữ
                <input disabled="disabled" id="number_participants_females" name="number_participants_females" value="<?php echo $data->number_participants_females ?>" type="text" class="form w90px" value="5" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Khác'); ?>:</td>
            <td class="w355px">
                <input disabled="disabled" id="commodities_outside" name="commodities_outside" value="<?php echo $data->commodities_outside ?>" type="text" class="form w215px" placeholder="Ngành hàng/ hoạt động ngoài CT" />
            </td>
            <td class="label"><?php echo FSText::_('Ngân sách chương trình'); ?>:</td>
            <td>
                <input disabled="disabled" id="budget_program" name="budget_program" type="text" class="form w215px" value="<?php echo number_format($data->budget_program, 0, ',', '.') ?> VNĐ" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Địa điểm'); ?>:</td>
            <td class="w355px">
                <input disabled="disabled" id="activity_address" name="activity_address" value="<?php echo $data->activity_address ?>" type="text" class="form w215px" />
                <?php /* <select disabled="disabled" id="activity_region" name="activity_region" class="form w110px">
                    <option value="0">-- Vùng --</option>
                    <?php foreach($arrRegions as $key=>$val){?>
                        <option <?php if($data->activity_region == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <select disabled="disabled" id="activity_city" name="activity_city" class="form w110px">
                    <option value="0">-- Tỉnh --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($data->activity_city == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select> */ ?>
            </td>
            <td class="label"><?php echo FSText::_('Ngân sách đối ứng'); ?>:</td>
            <td>
                <input disabled="disabled" id="budget_reciprocal" name="budget_reciprocal" type="text" class="form w215px" value="<?php echo number_format($data->budget_reciprocal, 0, ',', '.') ?> VNĐ" />
            </td>
        </tr>
        <?php if($data->activity_type == 3 || $data->activity_type == 4){ ?>
            <tr>
                <td class="label"><?php echo FSText::_('Số gian hàng'); ?>:</td>
                <td colspan="3">
                    <input disabled="disabled" id="booth_number" name="booth_number" type="text" class="form w215px" value="<?php echo $data->booth_number ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><?php echo FSText::_('Số lượt khách'); ?>:</td>
                <td colspan="3">
                    <input disabled="disabled" id="number_visitors" name="number_visitors" type="text" class="form w215px" value="<?php echo $data->number_visitors ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><?php echo FSText::_('Số giao dịch'); ?>:</td>
                <td colspan="3">
                    <input disabled="disabled" id="number_transactions" name="number_transactions" type="text" class="form w215px" value="<?php echo $data->number_transactions ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><?php echo FSText::_('Số hợp đồng đã ký kết'); ?>:</td>
                <td colspan="3">
                    <input disabled="disabled" id="number_contracts_signed" name="number_contracts_signed" type="text" class="form w215px" value="<?php echo $data->number_contracts_signed ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><?php echo FSText::_('Doanh thu tại chỗ'); ?>:</td>
                <td colspan="3">
                    <input disabled="disabled" id="revenue_spot_vnd" name="revenue_spot_vnd" type="text" class="form w215px" value="<?php echo number_format($data->revenue_spot_vnd, 0, ',', '.') ?>" />&nbsp;(VNĐ)&nbsp;&nbsp;&nbsp;&nbsp;
                    <input disabled="disabled" id="revenue_spot_usd" name="revenue_spot_usd" type="text" class="form w215px" value="<?php echo number_format($data->revenue_spot_usd, 0, ',', '.') ?>" />&nbsp;(USD)
                </td>
            </tr>
        <?php } ?>
        <?php
        foreach($activityOutcome as $key=>$val){
            if($val == '')
                continue;
        ?>
            <tr>
                <td class="label">
                <?php  
                $data_title = '';
                switch($key){
                    case 'after':
                        echo FSText::_('Kết quả ngay sau hoạt động').':';
                        break;
                    case 'after1month':
                        echo FSText::_('Kết quả đạt được sau 1 tháng').':';
                        $data_title = FSText::_('Báo cáo các doanh nghiệp sau 1 tháng');
                        break;
                    case 'empirical':
                        echo FSText::_('Thách thức/ Rủi ro').':';
                        $data_title = FSText::_('Thách thức/ Rủi ro của các doanh nghiệp');
                        break;    
                    default:
                        $quarter = getQuarterText($data->start_date, $key);
                        echo FSText::_('Kết quả đạt được quý').' '.$quarter['text'].':';
                        $data_title = FSText::_('Báo cáo các doanh nghiệp quý').' '.$quarter['text'];
                }
                ?>
                </td>
                <td colspan="3">
                    <?php if($val != ''){ ?>
                        <div style="max-width: 716px" class="box-text">
                            <?php echo $val; ?>
                        </div>
                        <?php if(!in_array($key, array('empirical', 'after'))){ ?>
                            <input onclick="open_business_report(this);" activity_type="<?php echo $data->activity_type ?>" data-title="<?php echo base64_encode($data_title); ?>" data-id="<?php echo $data->id ?>" data-key="<?php echo $key ?>" style="margin-top: 7px; float: right" class="yellow" type="button" value="<?php echo FSText::_('Xem báo cáo của các doanh nghiệp')?>" />
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td class="label"><?php echo FSText::_('Tình trạng hoạt động'); ?>:</td>
            <td colspan="3">
                <?php foreach($arrOperationalStatus as $key=>$val){ ?>
                    <input <?php if($data->status == $key) echo 'checked="checked"'; ?> type="radio" name="status" id="status<?php echo $key ?>" value="<?php echo $key ?>" /><label for="status<?php echo $key ?>"><?php echo $val ?></label>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Người lập'); ?>:</td>
            <td colspan="3">
                <?php if($creator && IS_ADMIN){ ?>
                    <?php echo $creator->fullname ?>&nbsp;<?php if($creator->agencies_title){ ?>(<?php echo $creator->agencies_title ?>)<?php } ?>
                <?php } ?>
            </td>
        </tr>
        
        <!--<tr>
            <td class="label">&nbsp;</td>
            <td colspan="3">
                <a href="javascript:void(0);" class="export word functions_built" title="Xuất ra Word">Xuất ra Word</a>&nbsp;
                <a href="<?php echo FSRoute::_('index.php?module=statistics&view=activate&raw=1&task=excel_activate&id='.$data->id) ?>" class="export excel" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
                <a href="javascript:void(0);" class="export print functions_built" title="In trang này">In trang này</a>&nbsp;
            </td>
        </tr>-->
    </table>
    <input type="hidden" name="module" value="statistics"/>
    <input type="hidden" name="task" value="do_update"/>
    <input type="hidden" name="view" value="activate"/>
    <input type="hidden" name="data_id" id="data_id" value="<?php echo $data->id ?>"/>
    <input type="hidden" name="data_member_code" id="data_member_code" value="<?php echo $data->member_code ?>"/>
    <input type="hidden" name="start_date" id="start_date" value="<?php echo $data->start_date ?>"/>
    </form>
    <div class="ci-heading"><?php echo FSText::_('Danh sách người tham gia'); ?>:</div>
    <table class="data-table" style="width:900px">
        <tr class="bg-yellow white">
            <td class="bold center"><?php echo FSText::_('Tên'); ?></td>
            <td class="bold center"><?php echo FSText::_('Đơn vị'); ?></td>
            <td class="bold center"><?php echo FSText::_('_Nam_'); ?>/ <?php echo FSText::_('Nữ'); ?></td>
            <td class="bold center"><?php echo FSText::_('Điện thoại'); ?></td>
            <td class="bold center"><?php echo FSText::_('Email'); ?></td>
        </tr>
        <?php foreach($participants as $item){ ?>
            <tr>
                <td><?php echo $item->participants_title ?></td>
                <td><?php echo $item->agencies_title ?></td>
                <td><?php if($item->sex == 1) echo 'Nam'; else echo 'Nữ';  ?></td>
                <td><?php if(!$isLock) echo $item->mobile ?></td>
                <td><?php if(!$isLock) echo $item->email ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="clearfix"></div>
    <?php if(IS_ADMIN || (isset($user->userID) && (@$user->userInfo->code == $data->member_code)) || (isset($user->userID) && in_array($user->userInfo->type, array(1,2)))){ ?>
        <a href="<?php echo FSRoute::_('index.php?module=statistics&view=activate&raw=1&task=excel_activate_persons&id='.$data->id) ?>" class="export excel" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
    <?php }else{ ?>
        <a href="javascript:void(0);" class="export excel functions_permission" title="Xuất ra Excel">Xuất ra Excel</a>&nbsp;
    <?php } ?>
    <?php if($data->activity_participants && !$isLock){ ?>
        <a href="<?php echo URL_ROOT.$data->activity_participants ?>" class="button yellow" title="Download">Download</a>
    <?php } ?>
    <div style="float: right;">
        <b>Người lập: </b><?php echo $data->fullname ?><br />
        <b>Ngày: </b><?php echo date('d/m/Y', strtotime($data->created_time)) ?>
    </div>
    <div class="clearfix"></div>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-activate-list" />