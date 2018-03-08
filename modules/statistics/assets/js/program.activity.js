function showMainActivities(){
    $mquarter = $('#mquarter').val();
    $.ajax({
		type : 'POST',
        dataType: 'json',
		url : '/index.php?module=statistics&view=program&raw=1&task=get_program_activity&quarter='+$mquarter,
        success : function($json){
            $($json).each(function( index, element){
                $($json).each(function( index, element){
                    $('#program-activity td.'+element.class+'-in').text(element.in);
                    $('#program-activity td.'+element.class+'-quarter').text(element.quarter);
                    $('#program-activity td.'+element.class+'-implemented').text(element.implemented);
                    $('#program-activity td.'+element.class+'-out').text(element.out);
                });
            });
        }
	});
}

$(document).ready(function(){
    showMainActivities();
});