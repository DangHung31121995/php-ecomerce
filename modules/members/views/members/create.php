<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrMemType, $arrProgram, $arrOperationalStatus;
$tmpl->addScript('members', 'modules/members/assets/js');
?>
<div class="event-title">
    Quản lý thành viên 
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading">Cấp tài khoản mới</div>
    <div><i>Những ô có dấu (<span class="red">*</span>) là bắt buộc</i></div>
    <form id="frm_members" action="" method="POST">
    <table class="table-form">
        <tr>
            <td class="label">Loại thành viên:</td>
            <td>
                <select id="type" name="type" class="form w215px">
                    <option value="0">-- Chọn --</option>
                    <?php foreach($arrMemType as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="red">*</span>
            </td>
            <td rowspan="10" style="vertical-align: top;">
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
            <td class="label">Tỉnh:</td>
            <td>
                <select id="city_id" name="city_id" class="form w215px">
                    <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                    <?php foreach($cities as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Ngành hàng:</td>
            <td>
                <select id="commodity_id" name="commodity_id" class="form w215px">
                    <option value="0">-- Lựa chọn --</option>
                    <?php foreach($arrIndustries as $key=>$val){?>
                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Tài khoản đăng nhập:</td>
            <td>
                <input id="username" name="username" type="text" class="form w215px" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Mật khẩu:</td>
            <td>
                <input id="password" name="password" type="password" class="form w215px" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Họ & tên:</td>
            <td>
                <input id="fullname" name="fullname" type="text" class="form w215px" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Giới tính:</td>
            <td>
                <select id="sex" name="sex" class="form w215px">
                    <option value="0">--Chọn--</option>
                    <option value="1">--<?php echo FSText::_('_Nam_') ?>--</option>
                    <option value="2">--<?php echo FSText::_('Nữ') ?>--</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td>
                <input id="email" name="email" type="text" class="form w215px" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Email 2:</td>
            <td>
                <input id="email_other" name="email_other" type="text" class="form w215px" value="" />
            </td>
        </tr>
        <tr>
            <td class="label">Điện thoại:</td>
            <td>
                <input id="mobile" name="mobile" type="text" class="form w215px" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td class="label">Đơn vị:</td>
            <td>
                <input id="agencies_title" name="agencies_title" type="text" class="form w355px" />
            </td>
        </tr>
        <tr>
            <td class="label">Địa chỉ:</td>
            <td>
                <input id="address" name="address" type="text" class="form w355px" />
            </td>
        </tr>
        <tr>
            <td class="label">Số cán bộ/ lao động:</td>
            <td>
                <input id="some_staff" name="some_staff" type="text" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label">Chương trình:</td>
            <td>
                <?php foreach($arrProgram as $key=>$val){ ?>
                    <input id="program<?php echo $key ?>" name="program[]" type="checkbox" value="<?php echo $key ?>" /><label for="program<?php echo $key ?>"><?php echo $val ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<br />
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td>
                <input type="button" value="Thêm mới" onclick="addMembers();" />
            </td>
        </tr>
    </table>
    </form>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="members-members-create" />