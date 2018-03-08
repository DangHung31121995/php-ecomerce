function validNewsletter(){
    if(!isEmail($('#newsletter').val())){
        hideWaitting();
		alert('Địa chỉ email không đúng!');
		return false;
	}
    showWaitting();
    $.ajax({
		type : 'POST',
		url : '/index.php?module=ajax&view=ajax&raw=1&task=registerNewsletter',
		dataType : 'json',
		data: 'email='+$('#newsletter').val(),
		success : function(data){
            hideWaitting();
            $('#newsletter').attr('value', '');
            alert(data.message);
        },
		error : function(XMLHttpRequest, textStatus, errorThrown){
            hideWaitting();
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
	});
	return false;
}