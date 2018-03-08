function saveActivityOutcome($obj){
    if(!isNaN($($obj).val())){
        $($obj).addClass('process');
        $.ajax({
    		type : 'POST',
            dataType: 'json',
    		url : '/index.php?module=statistics&view=business&raw=1&task=save_activity_outcome',
    		data: 'id='+$($obj).attr('data-point')+'&value='+$($obj).val(),
            success : function($json){
                if($json.error == true){
                    alert($json.msg);
                }else{
                    
                }
                $($obj).removeClass('process');
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {$($obj).removeClass('process');}
    	});
    }else{
        alert('Dữ liệu nhập vào phải là số!');
    }
}
$(function() {
    $('input.activity_outcome').keypress(function(event) {
        if (event.keyCode == 13) {
            saveActivityOutcome(this);
        }
    });
    $(".clickedit-outcome").editable("index.php?module=statistics&view=business&raw=1&task=save_activity_outcome", { 
        indicator : "<img src='/images/process.gif'>",
        tooltip   : "Click để nhập...",
        type: 'text'
    });
});