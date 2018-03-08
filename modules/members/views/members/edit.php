<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrMemType, $arrProgram;
$tmpl->addScript('members', 'modules/members/assets/js');
?>
<div class="event-title">
    Quản lý thành viên 
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading">Cấp tài khoản mới</div>
    <form id="frm_members" action="" method="POST">
    <table class="table-form">
        <tr>
            <td class="label">Loại thành viên:</td>
            <td>
                <select id="type" name="type" class="form w215px">
                    <option value="0">-- Chọn --</option>
                    <?php foreach($arrMemType as $key=>$val){?>
                        <option <?php if($data->type == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Tỉnh:</td>
            <td>
                <select id="city_id" name="city_id" class="form w215px">
                    <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option <?php if($data->city_id == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Ngành hàng:</td>
            <td>
                <select id="commodity_id" name="commodity_id" class="form w215px">
                    <option value="0">-- Lựa chọn --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option <?php if($data->commodity_id == $key) echo 'selected="selected"'; ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Tài khoản đăng nhập:</td>
            <td>
                <input id="username" name="username" type="text" class="form w215px" value="<?php echo $data->username ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Mật khẩu:</td>
            <td>
                <input id="password" name="password" type="password" class="form w215px" value="" />
            </td>
        </tr>
        <tr>
            <td class="label">Họ & tên:</td>
            <td>
                <input id="fullname" name="fullname" type="text" class="form w215px" value="<?php echo $data->fullname ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Giới tính:</td>
            <td>
                <select id="sex" name="sex" class="form w215px">
                    <option value="0">--Chọn--</option>
                    <option <?php if($data->sex == 1) echo 'selected="selected"' ?> value="1">--<?php echo FSText::_('_Nam_') ?>--</option>
                    <option <?php if($data->sex == 2) echo 'selected="selected"' ?> value="2">--<?php echo FSText::_('Nữ') ?>--</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td>
                <input id="email" name="email" type="text" class="form w215px" value="<?php echo $data->email ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Email 2:</td>
            <td>
                <input id="email_other" name="email_other" type="text" class="form w215px" value="<?php echo $data->email_other ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Điện thoại:</td>
            <td>
                <input id="mobile" name="mobile" type="text" class="form w215px" value="<?php echo $data->mobile ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Đơn vị:</td>
            <td>
                <input id="agencies_title" name="agencies_title" type="text" class="form w355px" value="<?php echo $data->agencies_title ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Số cán bộ/ lao động:</td>
            <td>
                <input id="some_staff" name="some_staff" type="text" class="form w355px" value="<?php echo $data->some_staff ?>" />
            </td>
        </tr>
        <tr>
            <td class="label">Chương trình:</td>
            <td>
                <?php 
                $program = explode(',', $data->program);
                foreach($arrProgram as $key=>$val){ 
                ?>
                    <input <?php if(in_array($key, $program)) echo 'checked="checked"'; ?> id="program<?php echo $key ?>" name="program[]" type="checkbox" value="<?php echo $key ?>" /><label for="program<?php echo $key ?>"><?php echo $val ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td>
                <input type="button" value="Cập nhật" onclick="updateMembers();" />
                <input type="hidden" name="id" id="id" value="<?php echo $data->id ?>" />
            </td>
        </tr>
    </table>
    </form>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="members-members-create" />