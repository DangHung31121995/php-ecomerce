function addMembers(){
    if($('#type').val() == '0'){
        alert('Bạn vui lòng chọn loại thành viên!'); return false;
    }
    if($('#city_id').val() == '0'){
        alert('Bạn vui lòng chọn tỉnh thành!'); return false;
    }
    /* if($('#commodity_id').val() == '0'){
        alert('Bạn vui lòng chọn ngành hàng!'); return false;
    } */
    if($('#email').val() == ''){
        alert('Bạn vui lòng nhập email!'); return false;
    }
    if(!isPhone('mobile')){
        alert('Bạn vui lòng nhập số điện thoại!'); return false;
    }
    if(!isEmail($('#email').val())){
        alert('Email không đúng!'); return false;
    }
    if($('#username').val() == ''){
        alert('Bạn vui lòng nhập tên đăng nhập!'); return false;
    }
    if($('#fullname').val() == ''){
        alert('Bạn vui lòng nhập tên!'); return false;
    }
    if($('#password').val() == ''){
        alert('Bạn vui lòng nhập mật khẩu!'); return false;
    }
    var $data = $('form#frm_members').serialize();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=members&view=members&raw=1&task=add_members',
		data: $data,
        success : function($json){
            alert($json.msg);
            if($json.error == false)
                window.location = $json.url;
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
function delMembers($id) {
	var answer = confirm("Bạn có thực sự muốn xóa thành viên này?")
	if (answer){
		window.location = "/index.php?module=members&view=members&task=delete&id="+$id;
	}
    return false;
}
function updateMembers(){
    if($('#type').val() == '0'){
        alert('Bạn vui lòng chọn loại thành viên!'); return false;
    }
    if($('#city_id').val() == '0'){
        alert('Bạn vui lòng chọn tỉnh thành!'); return false;
    }
    /*if($('#commodity_id').val() == '0'){
        alert('Bạn vui lòng chọn ngành hàng!'); return false;
    }*/
    if($('#email').val() == ''){
        alert('Bạn vui lòng nhập email!'); return false;
    }
    if(!isEmail($('#email').val())){
        alert('Email không đúng!'); return false;
    }
    if($('#username').val() == ''){
        alert('Bạn vui lòng nhập tên đăng nhập!'); return false;
    }
    if($('#fullname').val() == ''){
        alert('Bạn vui lòng nhập tên!'); return false;
    }
    var $data = $('form#frm_members').serialize();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=members&view=members&raw=1&task=update_members',
		data: $data,
        success : function($json){
            alert($json.msg);
            if($json.error == false)
                window.location = $json.url;
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
function validLogin(){
    if($('#username').val() == ''){
        alert('Bạn vui lòng nhập tên đăng nhập!'); return false;
    }
    if($('#password').val() == ''){
        alert('Bạn vui lòng nhập mật khẩu!'); return false;
    }
    document.forms['frm_members'].submit();
    /* var $data = $('form#frm_members').serialize();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=members&view=members&raw=1&task=login_save',
		data: $data,
        success : function($json){
            if ($json.error==true){
                alert($json.message);
            }else{
                $(window.location).attr('href', $json.redirect);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});*/
}