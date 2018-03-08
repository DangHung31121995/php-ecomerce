function open_participants_box(){
    tb_show('Finalstyle box', '/index.php?module=statistics&view=activate&raw=1&task=open_participants_box&height=625&width=930&modal=true');
    return false;
}
function open_participants_edit($id){
    tb_show('Finalstyle box', '/index.php?module=statistics&view=activate&raw=1&task=open_participants_box&height=625&width=930&modal=true&id='+$id);
    return false;
}
$('form#frm_activate #activity_type').change(function(){
    if($(this).val() == 3 || $(this).val() == 4){
        $('.for-fair').show();
    }else{
        $('.for-fair').hide();
    }
});

function validReportActivity(){
    
}

function addParticipants(){
    if($('#participants_title').val() == ''){
        alert('Bạn vui lòng nhập tên người tham gia!'); return false;
    }
    if($('#agencies_title').val() == ''){
        alert('Bạn vui lòng nhập đơn vị tham gia!'); return false;
    }
    /* if($('#mobile').val() == ''){
        alert('Bạn vui lòng nhập số điện thoại!'); return false;
    }
    if(!isPhone('mobile')){
        alert('Số điện thoại không đúng!'); return false;
    } 
    if($('#email').val() == ''){
        alert('Bạn vui lòng nhập email!'); return false;
    }
    if(!isEmail($('#email').val())){
        alert('Email không đúng!'); return false;
    }*/
    var $data = $('form#add_participants').serialize();
    var $data_id = $('#data_id').val();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=activate&raw=1&task=add_participants',
		data: $data+'&data_id='+$data_id,
        success : function($json){
            if($json.error == true){
                alert($json.msg);
            }else{
                var $tr = '';
                $tr += '<tr id="tr_'+$json.id+'">';
                $tr += '    <td>'+$('#participants_title').val()+'</td>';
                $tr += '    <td>'+$('#agencies_title').val()+'</td>';
                $tr += '    <td>'+$("#sex option:selected").text()+'</td>';
                $tr += '    <td>'+$('#mobile').val()+'</td>';
                $tr += '    <td>'+$('#email').val()+'</td>';
                $tr += '    <td class="center"><a onclick="delParticipants(\''+$json.id+'\');" class="btn-delete" href="javascipt:void(0);"></a></td>';
                $tr += '</tr>';
                $("#tbl_participants tr:last").after($tr);
                $('#number_participants').val(parseInt($('#number_participants').val())+1);
            }
            
            document.getElementById("add_participants").reset();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}

function delParticipants($id){
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=activate&raw=1&task=del_participants',
		data: 'id='+$id,
        success : function($json){
            if($json.error == false)
                $('tr#tr_'+$id).remove();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}

function open_business_report($obj){
    var $id = $($obj).attr('data-id');
    var $key = $($obj).attr('data-key');
    var $title = $($obj).attr('data-title');
    var $activity_type = $($obj).attr('activity_type');
    tb_show('Finalstyle box', '/index.php?module=statistics&view=activate&raw=1&task=open_business_report&activity_type='+$activity_type+'&id='+$id+'&key='+$key+'&title='+$title+'&height=625&width=930&modal=true');
    return false;
}
function open_risk_box(){
    tb_show('Finalstyle box', '/index.php?module=statistics&view=activate&raw=1&task=open_risk_box&height=625&width=930&modal=true');
    return false;
}
function open_risk_edit($id){
    tb_show('Finalstyle box', '/index.php?module=statistics&view=activate&raw=1&task=open_risk_box&height=625&width=930&modal=true&id='+$id);
    return false;
}
function addRisk(){
    if($('textarea#risk').val() == ''){
        alert('Bạn vui lòng nhập rủi ro!'); return false;
    }
    var $data = $('form#add_risk').serialize();
    var $data_id = $('#data_id').val();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=activate&raw=1&task=add_risk',
		data: $data+'&data_id='+$data_id,
        success : function($json){
            if($json.error == true){
                alert($json.msg);
            }else{
                var $tr = '';
                $tr += '<tr id="tr_'+$json.id+'">';
                $tr += '    <td>'+$("#type option:selected").text()+'</td>';
                $tr += '    <td>'+$('#risk').val()+'</td>';
                $tr += '    <td>'+$('#solution').val()+'</td>';
                $tr += '    <td class="center"><a onclick="delRisk(\''+$json.id+'\');" class="btn-delete" href="javascipt:void(0);"></a></td>';
                $tr += '</tr>';
                $("#tbl_risks tr:last").after($tr);
            }
            document.getElementById("add_risk").reset();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}

function delRisk($id){
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=activate&raw=1&task=del_risk',
		data: 'id='+$id,
        success : function($json){
            if($json.error == false)
                $('tr#tr_'+$id).remove();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}