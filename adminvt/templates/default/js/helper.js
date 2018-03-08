/**
* Default function.  Usually would be overriden by the component
*/
function submitbutton(pressbutton) {
	submitform(pressbutton);
}
/**
* Submit the admin form
*/
function submitform(pressbutton){
	if (pressbutton) {
		document.adminForm.task.value=pressbutton;
	}
	if (typeof document.adminForm.onsubmit == "function") {
		document.adminForm.onsubmit();
	}
	document.adminForm.submit();
}
/* 
 * Ordering 
 */
function tableOrdering( order, dir, task ) {
	var form = document.adminForm;
	form.sort_field.value 	= order;
	form.sort_direct.value	= dir;
	submitform( task );
}
/*
 * Check checkbox
 */
function isChecked(isitchecked){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
	}
	else {
		document.adminForm.boxchecked.value--;
	}
}
function checkAll( n, fldName ) {
	  if (!fldName) {
	     fldName = 'cb';
	  }
		var f = document.adminForm;
		var c = f.toggle.checked;
		var n2 = 0;
		for (i=0; i < n; i++) {
			cb = eval( 'f.' + fldName + '' + i );
			if (cb) {
				cb.checked = c;
				n2++;
			}
		}
		if (c) {
			document.adminForm.boxchecked.value = n2;
		} else {
			document.adminForm.boxchecked.value = 0;
		}
	}
function listItemTask(id, task)
{
    var f = document.adminForm;
    cb = eval( 'f.' + id );
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task);
    }
    return false;
}
function deleteMenu(id,parent_id,url){
	var r=confirm("Bạn chắc chắn muốn xóa ?")
	if (r==true){
	  $.get(url, { id:id,parent_id:parent_id },
		function(data){
		  $('.'+data).remove();
		  alert("Xóa thành công !");
		});
	}
}
/**** CREATE LINKED*******/
function creat_link(object){
	window.open("index2.php?module=menus&view=items&task=linked&object=" + object, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
function link_to_data(str_link){
	window.opener.document.getElementById("mnu_link").value = str_link;
	window.close();
}
function link_from_linked()
{
	ob = document.getElementById( "linked" );
	if( ob.value == 0 ){
		alert( "You have not created a link !" );
		ob.focus();
		return false;
	}
	window.opener.document.getElementById("mnu_link").value = ob.value;
	window.close();
}
/*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
function notEmpty(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	if(elem.value.length == 0){
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}
//If the element's string matches the regular expression it is all numbers
function isNumeric(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
		elem.focus();
		return false;
	}
}
//If the element's string matches the regular expression it is all letters
function isAlphabet(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
		elem.focus();
		return false;
	}
}
//If the element's string matches the regular expression it is numbers and letters
function isAlphanumeric(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
		elem.focus();
		return false;
	}
}
// Limit length
function lengthRestriction(elemid, min, max){
	elem  = document.getElementById(elemid);
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = "Please enter between " +min+ " and " +max+ " characters";
//		alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}
// Select box ( multi select)
function madeSelection(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	  var i;
	  for (i=0; i<elem.options.length; i++) {
		  console.log(elem.options[i].value);
	    if (elem.options[i].selected && ( elem.options[i].value != "") ){
	      return true;
	    }
	  }
	  document.getElementById('msg_error').innerHTML = helperMsg;
	  return false;
}
// Email
function emailValidator(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		document.getElementById('msg_error').innerHTML = helperMsg;
//		alert(helperMsg);
		elem.focus();
		return false;
	}
}
// Password and repassword
function checkMatchPass(helperMsg){
	elem_value  = document.getElementById('password').value;
	elem2_value  = document.getElementById('repass').value;
	if(elem_value != elem2_value )
	{
		document.getElementById('msg_error').innerHTML = helperMsg;
		return false;
	}
	return true;
}

/* Upgrade */
function init_position_box(box){
    var winH = $(window).height();
    var winW = $(window).width();
    box.css('top',  winH/2 - box.height()/2);
    box.css('left', winW/2 - box.width()/2);
}
$(document).ready(function(){
    /* Tính lại width của toolbar*/
    var $width = $('#box-content').width();
    $('#wrap-toolbar').css('width', $width+'px');
    $(window).resize(function () {	 
        var $width = $('#box-content').width();
        $('#wrap-toolbar').css('width', $width+'px');
	});
    /* Đính thanh toolbar lên top */
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#wrap-toolbar').css({'position':'fixed', 'top':'0', 'z-index': 9999});
		} else {
			$('#wrap-toolbar').css({'position':'relative', 'top':'auto'});
		}
	});
    /* Hiển thị menu hiện tại */
    $current = $('.selected').parent().parent('ul');
	if($current){
		$current.show();
	}
    $current2 = $('.li_has_child .selected').parent().parent().parent().parent('ul');
	if($current2){
		$current2.show();
	}
    $('#menu-bar .has-child .bound').click(function(){
        var $child =  $(this).next('ul:first');
        if($($child).css("display") == "none")
            $($child).css("display", "block");
        else
        	$($child).css("display", "none");
    });
    $('#menu-bar .a_has_child').click(function(){
        var $child =  $(this).next('ul:first');
        if($($child).css("display") == "none")
            $($child).css("display", "block");
        else
        	$($child).css("display", "none");
    });
    /* Gán chiều cao tối thiểu cho Box content */
    var min_height = $('#sidebar').height();
    $('#box-content').css('min-height', min_height+'px'); 
    
    $("#seo_title").charCount({
		allowed: 0,		
		counterText: ' ký tự'	
	});
    $("#seo_keyword").charCount({
		allowed: 0,		
		counterText: ' ký tự'	
	});
	$("#seo_description").charCount({
		allowed: 0,		
		counterText: ' ký tự'	
	});
});