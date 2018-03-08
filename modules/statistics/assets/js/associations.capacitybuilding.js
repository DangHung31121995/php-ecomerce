$(function() {
    $(".edit-capacity-building").editable("index.php?module=statistics&view=associations&raw=1&task=save_capacity_building", { 
        indicator : "<img src='/images/process.gif'>",
        tooltip   : "Click để nhập...",
        type: 'text'
    });
    
    $('.checkbox-capacity-building').click(function(){
        var $value = 0;
        if($(this).is(':checked'))
            $value = 1;
        $.ajax({
    		type : 'POST',
            dataType: 'json',
    		url : '/index.php?module=statistics&view=associations&raw=1&task=save_capacity_building',
    		data: 'id='+$(this).attr('id')+'&value='+$value,
            success : function($json){
            }
    	});
    });
});
