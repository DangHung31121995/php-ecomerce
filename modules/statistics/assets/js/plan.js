function validAddPlan(){
    if($('#outcome_code').val() == ''){
        Boxy.alert('Bạn vui lòng nhập mã outcome!',function(){$('#outcome_code').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }
    if($('#activity_code').val() == ''){
        Boxy.alert('Bạn vui lòng nhập mã hoạt động!',function(){$('#activity_code').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }
    if($('#activity_title').val() == ''){
        Boxy.alert('Bạn vui lòng nhập tên hoạt động!',function(){$('#activity_title').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }
    if($('#activity_type').val() == 0){
        Boxy.alert('Bạn vui lòng chọn loại hoạt động!',function(){$('#activity_type').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }
    if($('#activity_month').val() == 0){
        Boxy.alert('Bạn vui lòng chọn tháng hoạt động!',function(){$('#activity_month').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }
    /*if($('#activity_city').val() == 0){
        Boxy.alert('Bạn vui lòng chọn vùng hoạt động!',function(){$('#activity_city').focus();},{title:'Thông báo.',afterShow: function() { $('#boxy_button_OK').focus();} });
        return false;
    }*/
}
function delPlan($id) {
	var answer = confirm("Bạn có thực sự muốn xóa kế hoạch này?")
	if (answer){
		window.location = "/index.php?module=statistics&view=plan&task=delete&id="+$id;
	}
    return false;
}