<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrMemType, $arrProgram, $user;
$tmpl->addScript('members', 'modules/members/assets/js');
$tmpl->addScript('jquery.dataTables');
$tmpl->addScript('dataTables.fixedColumns');
?>
<div class="event-title">
    Quản lý thành viên
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading">Danh sách tài khoản</div>
    <form id="frm_members" action="<?php echo FSRoute::_('index.php?module=members&view=members'); ?>" method="GET">
    <table class="table-form">
        <tr>
            <td>
                <b>Lọc kết quả theo:</b>&nbsp;
                <?php $city_id = FSInput::get('city_id', 0); ?>
                <select id="city_id" name="city_id" class="form">
                    <option value="0">-- Tỉnh/Tp --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($city_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $commodity_id = FSInput::get('commodity_id', 0); ?>
                <select id="commodity_id" name="commodity_id" class="form">
                    <option value="0">-- Ngành hàng --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option <?php if($commodity_id == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $type = FSInput::get('type', 0); ?>
                <select id="type" name="type" class="form">
                    <option value="0">-- Loại hình --</option>
                    <?php foreach($arrMemType as $key=>$val){?>
                        <option <?php if($type == $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>&nbsp;
                <?php $keyword = FSInput::get('keyword', ''); ?>
                <input type="text" name="keyword" id="keyword" class="form w215px" value="<?php echo $keyword ?>" placeholder="<?php echo FSText::_('Nhập tên người cần tìm'); ?>..." />&nbsp;
                <input type="submit" value="<?php echo FSText::_('Tìm kiếm'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;Số lượng: <?php echo $total ?> (<?php echo $totalBusiness ?> doanh nghiệp)
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="members"/>
    <input type="hidden" name="view" value="members"/>
    </form>
    <div class="box-relative">
        <table class="data-table data-table-hover">
            <tr class="center bold bg-gray">
                <td style="width: 70px;">ID</td>
                <td>Tên đơn vị</td>
                <td style="width: 120px;">Người liên hệ</td>
                <td style="width: 90px;">Điện thoại</td>
                <td style="width: 100px;">Tỉnh/Tp</td>
                <td style="width: 100px;">Ngành hàng</td>
                <td style="width: 120px;">Loại hình</td>
                <td style="width: 90px;">Trạng thái</td>
                <td style="width: 75px;">Sửa</td>
                <td style="width: 75px;">Xóa</td>
            </tr>
            <?php foreach($list as $item){ ?>
                <tr class="hover">
                    <td><?php echo $item->code ?></td>
                    <td class="member-name">
                        <?php if($item->type == 5){ ?>
                            <a href="/index.php?module=statistics&view=business&task=view&id=<?php echo $item->id?>"><?php echo $item->agencies_title ?></a>
                        <?php }else{ ?>
                            <?php echo $item->agencies_title ?>
                        <?php } ?>
                        <div class="box-member-absolute">
                            <div class="bma-title">Thông tin và hoạt động</div>
                            <div class="bma-content">
                                <p><span>Người liên hệ:</span><?php echo $item->fullname ?></p>
                                <p><span>Email:</span><?php echo $item->email ?></p>
                                <?php if(IS_ADMIN || ($user->userID && in_array($user->userInfo->type, array(1,2,3)) && $user->userInfo->city_id == $item->city_id)){ ?>
                                    <p><span>Điện thoại:</span><?php echo $item->mobile ?></p>
                                <?php } ?>
                                <p><span>Tỉnh:</span><?php echo $cities[$item->city_id] ?></p>
                                <p><span>Ngành hàng:</span><?php echo @$arrIndustries[$item->commodity_id] ?></p>
                                <p><span>Ngày cấp:</span><?php echo date('d/m/Y', strtotime($item->created_time)); ?></p>
                                <p><span>Các chương trình đã tham gia:</span></p>
                                <p>
                                    <?php 
                                    $program = explode(',', $item->program);
                                    foreach($program as $key){
                                        if(isset($arrProgram[$key]))
                                            echo $arrProgram[$key].'<br />';
                                    }
                                    ?>
                                </p>
                            </div><!--end: .bma-content-->
                        </div><!--end: .box-member-absolute-->
                    </td>
                    <td><?php echo $item->fullname ?></td>
                    <td>
                        <?php if(IS_ADMIN || ($user->userID && in_array($user->userInfo->type, array(1,2,3)) && $user->userInfo->city_id == $item->city_id)){ ?>
                            <?php echo $item->mobile ?>
                        <?php } ?>
                    </td>
                    <td><?php echo @$cities[$item->city_id] ?></td>
                    <td><?php echo @$arrIndustries[$item->commodity_id] ?></td>
                    <td><?php echo $arrMemType[$item->type] ?></td>
                    <td class="center"><a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=published&id='.$item->id.'&value='.abs($item->published-1)); ?>"><img src="/images/check_<?php echo $item->published ?>.png" /></a></td>
                    <td class="center"><a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=edit&id='.$item->id); ?>"><img src="/images/edit.png" /></a></td>
                    <td class="center"><a onclick="delMembers(<?php echo $item->id ?>);" href="javascript:void(0);"><img src="/images/delete.png" /></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php if($pagination) echo $pagination->showPagination(); ?>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="members-members-display" />