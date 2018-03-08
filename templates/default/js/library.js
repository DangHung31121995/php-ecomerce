function isEmail(email) {
	var re = /^(\w|[^_]\.[^_]|[\-])+(([^_])(\@){1}([^_]))(([a-z]|[\d]|[_]|[\-])+|([^_]\.[^_])*)+\.[a-z]{2,3}$/i
	return re.test(email);
}

function isPhone(elemid){
	elem  = $('#'+elemid);
	var numericExpression = /^[0-9 .]+$/;
	if(elem.val().match(numericExpression)){
		return true;
	}else{
		return false;
	}
}

function isEmpty(elemid){
	elem  = $('#'+elemid);
	if(elem.val().length == 0){
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		return true;
	}
}

function isInteger(value) {
    for (i = 0; i < value.length; i++) {
        if ((value.charAt(i) < '0') || (value.charAt(i) > '9')) return false
    }
    return true;
}	
$('#main-nav .has-child a').click(function(){
    var $obj = $(this).parent('li');
    if($obj.hasClass('selected'))
        $obj.removeClass('selected');
    else
        $obj.addClass('selected');
});
$('.functions_built').click(function(){
   alert('Chức năng này đang hoàn thiện'); 
});
$('.functions_permission').click(function(){
   alert('Liên hệ admin để thực hiện thao tác này!'); 
});

$(document).ready(function() {
    /* */
    var $role = $('#data-role').val();
    if($role != 'undefined'){
        $('#main-nav li').each(function(){
            if($role == $(this).attr('role')) {
                $(this).addClass('selected').addClass('curent');
                $(this).parent().parent('li').addClass('selected');
                $(this).parent().parent('li').parent().parent('li').addClass('selected');
            }
        });
    }
    /* Tính chiều cao */
    var $sHeight = $('#sidebar').height();
    var $cHeight = $('#content').height();
    if($sHeight > $cHeight)
        $('#content .content-inner').height(($sHeight-35)+'px');
    else
        $('#sidebar').height($cHeight+'px');
});