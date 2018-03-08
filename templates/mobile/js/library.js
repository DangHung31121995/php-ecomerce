var is_rewrite = 0;
var root = 'http://localhost:3012/';

function fsAlert($option){
    $option = $option||{};
    var box = $("<div></div>");
    box.html($option.msg).dialog({
        modal: true, 
        title: 'Thông báo', 
        buttons: { 
            Ok: function() {
                $.isFunction($option.func) && ($option.func)();
                $(this).dialog('destroy').remove();
            }
        }
    }).dialog('open');
    return false;
}
function changeCaptcha(){
	var date = new Date();
	var captcha_time = date.getTime();
	$("#imgCaptcha").attr({src:root+'libraries/jquery/ajax_captcha/create_image.php?'+captcha_time});
}
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
function validNewsletter(){
    if(!isEmail($('#newsletter').val())){
		alert('Địa chỉ email không đúng!');
		return false;
	}
    $.ajax({
		type : 'POST',
		url : '/index.php?module=ajax&view=ajax&raw=1&task=registerNewsletter',
		dataType : 'json',
		data: 'email='+$('#newsletter').val(),
		success : function(data){
            $('#newsletter').attr('value', '');
            alert(data.message);
        },
		error : function(XMLHttpRequest, textStatus, errorThrown){
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
	});
	return false;
}
function show_wait(){		
	//Get the A tag
	var id = $(this).attr('href');	
	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();	
	//Set heigth and width to mask to fill up the whole screen
	$('#bw-mask').css({'width':maskWidth,'height':maskHeight});		
	//transition effect		
	$('#bw-mask').fadeIn(500);	
	$('#bw-mask').fadeTo("slow",0.8);		
	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();              
	//Set the popup window to center
	$('#dialog').css('top',  winH/2-$('#dialog').height()/2);
	$('#dialog').css('left', winW/2-$('#dialog').width()/2);	
	//transition effect
	$('#dialog').fadeIn(500); 
}
function hide_wait(){
    $('#bw-mask').hide();
	$('.window').hide();
}
$(document).ready(function() {			
	$(window).resize(function () {	 
 		var box = $('#bw-boxes .window'); 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();      
        //Set height and width to mask to fill up the whole screen
        $('#bw-mask').css({'width':maskWidth,'height':maskHeight});               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();
        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);	 
	});
});	