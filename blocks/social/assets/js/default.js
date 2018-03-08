$(document).ready(function(){
    $.ajax({
		type : 'POST',
		url : '/index.php?module=ajax&view=ajax&raw=1&task=getSocial',
		dataType : 'json',
		success : function(data){
            $('#facebook_like').html(data.facebook_like);
            $('#google_plusones').html(data.google_plusones);
        }
	});
});
function fb_like(){
    url = 'http://sieuthibaokhang.vn';
    title=document.title;
    window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent(title),'sharer','toolbar=0,status=0,width=626,height=436');
    return false;
}
function g_plusone(){
    url = 'http://sieuthibaokhang.vn';
    title=document.title;
    window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&t='+encodeURIComponent(title),'plusone','toolbar=0,status=0,width=626,height=436');
    return false;
}