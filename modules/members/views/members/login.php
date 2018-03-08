<?php
global $tmpl, $arrActivityType, $arrIndustries, $arrMemType;
$tmpl->addScript('members', 'modules/members/assets/js');
?>
<div class="event-title">
    Đăng nhập tài khoản
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading">Đăng nhập tài khoản</div>
    <form onsubmit="return validLogin();" id="frm_members" action="<?php echo FSRoute::_('index.php?module=members&view=members&task=do_login'); ?>" method="POST">
    <table class="table-form">
        <tr>
            <td class="label">Tài khoản:</td>
            <td>
                <input id="username" name="username" type="text" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label">Mật khẩu:</td>
            <td>
                <input id="password" name="password" type="password" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td>
                <input type="submit" value="Đăng nhập" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="module" value="members"/>
    <input type="hidden" name="view" value="members"/>
    <input type="hidden" name="task" value="do_login"/>
    </form>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="members-members-login" />