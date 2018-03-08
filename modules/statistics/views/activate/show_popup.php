<div class="tbpopup-title">
    <?php echo FSText::_('Chi tiết số người tham gia'); ?>
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <form id="add_participants" name="add_participants" action="/">
    <table class="table-form">
        <tr>
            <td class="label"><?php echo FSText::_('ID') ?>:</td>
            <td>
                <input type="text" id="member_code" name="member_code" value="" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Đơn vị') ?>:</td>
            <td>
                <input id="agencies_title" name="agencies_title" type="text" class="form w215px" />
                <span class="note">(<?php echo FSText::_('Có thể nhập theo ID') ?>)</span>
                <!--<input type="hidden" id="member_code" name="member_code" value="0" />-->
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Tên người tham gia') ?>:</td>
            <td>
                <input id="participants_title" name="participants_title" type="text" class="form w215px" />
                <!--<span class="note">(Có thể nhập theo ID)</span>-->
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Giới tính') ?>:</td>
            <td>
                <select id="sex" name="sex" class="form w215px">
                    <option value="1">--<?php echo FSText::_('_Nam_') ?>--</option>
                    <option value="2">--<?php echo FSText::_('Nữ') ?>--</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Điện thoại') ?>:</td>
            <td>
                <input id="mobile" name="mobile" type="text" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label"><?php echo FSText::_('Email') ?>:</td>
            <td>
                <input id="email" name="email" type="text" class="form w215px" />
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td>
                <input type="button" value="<?php echo FSText::_('Thêm mới') ?>" onclick="addParticipants();" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="data_id" id="data_id" value="<?php echo $id ?>" />
    </form><br /><br />
    <div class="heading">
        <?php echo FSText::_('Danh sách người tham gia') ?>:
    </div>
    <table id="tbl_participants" class="data-table">
        <tr class="bg-yellow white center bold">
            <td><?php echo FSText::_('Tên') ?></td>
            <td><?php echo FSText::_('Đơn vị') ?></td>
            <td><?php echo FSText::_('Nam/ Nữ') ?></td>
            <td><?php echo FSText::_('Điện thoại') ?></td>
            <td><?php echo FSText::_('Email') ?></td>
            <td style="width: 50px;"></td>
        </tr>
        <?php foreach($list as $item){ ?>
            <tr id="tr_<?php echo fsEncode($item->id); ?>">
                <td><?php echo $item->participants_title ?></td>
                <td><?php echo $item->agencies_title ?></td>
                <td><?php if($item->sex == 1) echo 'Nam'; else echo 'Nữ';  ?></td>
                <td><?php echo $item->mobile ?></td>
                <td><?php echo $item->email ?></td>
                <td class="center"><a onclick="delParticipants('<?php echo fsEncode($item->id); ?>');" class="btn-delete" href="javascipt:void(0);"></a></td>
            </tr>
        <?php } ?>
    </table>
    <div class="heading">
        <?php echo FSText::_('Nhập số người tham gia') ?>:
    </div>
    <table id="tbl_participants" class="data-table" style="table-layout: fixed;">
        <tr class="bg-gray center bold">
           <td style="width: 12.5%;">Tổng số người tham gia</td> 
           <td style="width: 12.5%;">Số cán bộ Trung tâm, Hiệp hội tham gia</td>
           <td style="width: 12.5%;">Số Trung tâm, Hiệp hội tham gia</td>
           <td style="width: 12.5%;">Số cán bộ doanh nghiệp tham gia</td>
           <td style="width: 12.5%;">Số doanh nghiệp tham gia</td>
           <td style="width: 12.5%;">Số cơ quan báo chí</td>
           <td style="width: 12.5%;">Số cán bộ BQL dự án</td>
           <td style="width: 12.5%;">Số cán bộ Vietrade</td>
        </tr>
        <tr>
           <td style="width: 12.5%;"><input id="pop_number_participants" type="text" class="form w100pc" value="<?php echo intval(@$data->number_participants) ?>" /></td> 
           <td style="width: 12.5%;"><input id="pop_number_centre_staff" type="text" class="form w100pc" value="<?php echo intval(@$data->number_centre_staff) ?>" /></td>
           <td style="width: 12.5%;"><input id="pop_number_center" type="text" class="form w100pc" value="<?php echo intval(@$data->number_center) ?>" /></td>
           <td style="width: 12.5%;"><input id="pop_number_business_staff" type="text" class="form w100pc" value="<?php echo intval(@$data->number_business_staff) ?>" /></td>
           <td style="width: 12.5%;"><input id="pop_number_businesses" type="text" class="form w100pc" value="<?php echo intval(@$data->number_businesses) ?>" /></td>
           <td style="width: 12.5%;"><input id="pop_number_press_agencies" type="text" class="form w100pc" value="<?php echo intval(@$data->number_press_agencies) ?>" /></td>
           <td style="width: 12.5%;"><input id="pop_number_project_managers" type="text" class="form w100pc" value="<?php echo intval(@$data->number_project_managers) ?>" /></td>
           <td style="width: 12.5%;"><input id="number_vietrade" type="text" class="form w100pc" value="<?php echo intval(@$data->number_vietrade) ?>" /></td>
        </tr>
     </table>
     <div class="heading">
        <?php echo FSText::_('Số khách thăm quan') ?>:
    </div>
    <table id="tbl_participants" class="data-table" style="table-layout: fixed; margin: 0 auto;">
        <tr class="bg-gray center bold">
           <td style="width: 50%;">Số khách thăm quan</td> 
           <td style="width: 50%;">Nữ</td>
        </tr>
        <tr>
           <td style="width: 50%;"><input id="pop_number_visitors_activity" type="text" class="form w100pc" value="<?php echo intval(@$data->number_visitors_activity) ?>" /></td> 
           <td style="width: 50%;"><input id="pop_number_visitors_activity_females" type="text" class="form w100pc" value="<?php echo intval(@$data->number_visitors_activity_females) ?>" /></td>
        </tr>
     </table>
</div><!--end: .tbpopup-content-->
<script type="text/javascript">

$("input#pop_number_participants").keyup(function(){
    $("input#number_participants").val($("input#pop_number_participants").val());
});
$("input#pop_number_centre_staff").keyup(function(){
    $("input#number_centre_staff").val($("input#pop_number_centre_staff").val());
});
$("input#pop_number_center").keyup(function(){
    $("input#number_center").val($("input#pop_number_center").val());
});
$("input#pop_number_business_staff").keyup(function(){
    $("input#number_business_staff").val($("input#pop_number_business_staff").val());
});
$("input#pop_number_businesses").keyup(function(){
    $("input#number_businesses").val($("input#pop_number_businesses").val());
});
$("input#pop_number_press_agencies").keyup(function(){
    $("input#number_press_agencies").val($("input#pop_number_press_agencies").val());
});
$("input#pop_number_project_managers").keyup(function(){
    $("input#number_project_managers").val($("input#pop_number_project_managers").val());
});
$("input#pop_number_visitors_activity").keyup(function(){
    $("input#number_visitors_activity").val($("input#pop_number_visitors_activity").val());
});
$("input#pop_number_visitors_activity_females").keyup(function(){
    $("input#number_visitors_activity_females").val($("input#pop_number_visitors_activity_females").val());
});

$("#agencies_title").autocomplete({ 
    source: function (request, response){
        $.ajax({
            url: 'index.php?module=members&view=members&raw=1&task=get_members_json',
            dataType: "json",
            data:{
                term: request.term,
            },
            success: function (data)
            {
                response(data);
            }
        });
    }, 
    select: function( event, ui ) {
        $('#member_code').val(ui.item.id);
        $('#participants_title').val(ui.item.participants_title);
        $('#mobile').val(ui.item.mobile);
        $('#email').val(ui.item.email);
        $('#sex').val(ui.item.sex);
    },
    minLength: 0
}).focus(function () {
    if (this.value == "")
        $("input#agencies_title").autocomplete("search","");
});
</script>