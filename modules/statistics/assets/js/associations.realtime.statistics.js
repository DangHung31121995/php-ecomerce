$(document).ready(function(){
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=associations&raw=1&task=get_realtime_statistics',
        success : function($json){
            $($json).each(function( index, element){
                $('td#'+element.id+'-in').text(element.in);
                $('td#'+element.id+'-out').text(element.out);
                $('td#'+element.id+'-total').text(element.total);
            });
        }
	});
});