$('.view-business').click(function(){
    var $key = $(this).attr('data-key');
    var $city = $('#member_city').val();
    var $member_code = $('#member_code').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=associations&raw=1&task=open_business_box&height=600&width=1000&modal=true&key='+$key+'&city='+$city+'&member_code='+$member_code);
});
$('.view-city').click(function(){
    var $key = $(this).attr('data-key');
    var $city = $('#member_city').val();
    var $member_code = $('#member_code').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=associations&raw=1&task=open_city_box&height=600&width=1000&modal=true&key='+$key+'&city='+$city+'&member_code='+$member_code);
});
function saveBusiness(){
    var $member_code = $('#member_code').val();
    var $key = $('#key').val();
    var $lessons_learned = $('#lessons_learned').val();
    var $cr_id = $('#cr_id').val();
    $.ajax({
		type : 'POST',
        dataType: 'json',
        data: 'member_code='+$member_code+'&key='+$key+'&lessons_learned='+$lessons_learned+'&cr_id='+$cr_id,
		url : '/index.php?module=statistics&view=associations&raw=1&task=save_business',
        success : function($json){
            if($json.error == false){
                alert($json.message);
                $('#cr_id').val($json.id);
            }
        }
	});
} 