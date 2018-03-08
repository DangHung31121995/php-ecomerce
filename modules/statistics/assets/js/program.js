function showReportCity(){
    var $id = $('#ccity').val();
    var $quarter = $('#cquarter').val();
    var $program = $('#program').attr('cvalue'); 
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_report_city&height=1100&width=1235&modal=true&id='+$id+'&quarter='+$quarter+'&program='+$program);
    return false;
}
function showReportRegion(){
    var $id = $('#rregions').val();
    var $quarter = $('#rquarter').val();
    var $program = $('#program').attr('cvalue'); 
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_report_region&height=1100&width=1235&modal=true&id='+$id+'&quarter='+$quarter+'&program='+$program);
    return false;
}
function showReportIndustry(){
    var $id = $('#iindustries').val();
    var $quarter = $('#iquarter').val();
    var $program = $('#program').attr('cvalue'); 
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_report_industry&height=1100&width=1235&modal=true&id='+$id+'&quarter='+$quarter+'&program='+$program);
    return false;
}
function showLessonsLearned(){
    var $program = $('#program').attr('cvalue'); 
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_lessons_learned&height=500&width=1235&modal=true&program='+$program);
    return false;
}
function showBasicIndices(){
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_basic_indices&height=1600&width=1255&modal=true');
    return false;
}
function showCityReportProgram($obj){
    $key = $($obj).attr('data-key');
    $quarter = $('#quarter').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_city_report_program&height=800&width=800&modal=true&quarter='+$quarter+'&key='+$key);
}
function showCityOutcomeProgram($obj){
    $key = $($obj).attr('data-key');
    $quarter = $('#quarter').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_city_outcome_program&height=800&width=800&modal=true&quarter='+$quarter+'&key='+$key);
}
function showReportBusiness($obj){
    $key = $($obj).attr('data-key');
    $quarter = $('#quarter').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=business&raw=1&task=show_report_business&height=800&width=800&modal=true&quarter='+$quarter+'&key='+$key);
}
function showReportBusinessCities($obj){
    $key = $($obj).attr('data-key');
    $quarter = $('#quarter').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_report_business_cities&height=800&width=800&modal=true&quarter='+$quarter+'&key='+$key);
}
function showReportBusinessIndustries($obj){
    $key = $($obj).attr('data-key');
    $quarter = $('#quarter').val();
    tb_show('Finalstyle box', '/index.php?module=statistics&view=program&raw=1&task=show_report_business_industries&height=800&width=800&modal=true&quarter='+$quarter+'&key='+$key);
}

function showSynthesisReport(){
    $quarter = $('#quarter').val();
    $.ajax({
		type : 'POST',
        dataType: 'json',
        data: 'quarter='+$quarter,
		url : '/index.php?module=statistics&view=program&raw=1&task=get_synthesis_report',
        success : function($json){
            $('#synthesis_report .officials_knowledge').html($json.officials_knowledge);
            $('#synthesis_report .officials_xttm').html($json.officials_xttm);
            $('#synthesis_report .officials_customer').html($json.officials_customer);
            $('#synthesis_report .provincial_building_strategy').html($json.provincial_building_strategy);
            $('#synthesis_report .business_benchmarking').html($json.business_benchmarking);
            $('#synthesis_report .export_sales').html($json.export_sales);
            $('#synthesis_report .new_markets').html($json.new_markets);
            $('#synthesis_report .new_clients').html($json.new_clients);
        }
	});
}

function get_lessons_learned(){
    $activity_city = $('#frm_lessons_learned #activity_city').val();
    $activity_type = $('#frm_lessons_learned #activity_type').val();
    $commodity_id = $('#frm_lessons_learned #commodity_id').val();
    var $program = $('#program').attr('cvalue'); 
    $.ajax({
		type : 'POST',
        dataType: 'html',
        data: 'activity_city='+$activity_city+'&activity_type='+$activity_type+'&commodity_id='+$commodity_id+'&program='+$program,
		url : '/index.php?module=statistics&view=program&raw=1&task=get_lessons_learned',
        success : function($json){
            $('#tbl_participants tr.tr-item').remove();
            $('#tbl_participants tr:last').after($json);
        }
	});
    return false;
}