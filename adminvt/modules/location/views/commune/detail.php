	<?php
	// HEAD		
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');
	// end HEAD
	   
	// BODY
	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_selectbox(FSText::_('Country'),'country_id',@$data -> country_id,66,$countries,$field_value = 'id', $field_label='name',$size = 1,$multi  = 0);
	TemplateHelper::dt_edit_selectbox(FSText::_('City'),'city_id',@$data -> city_id,66,$cities,$field_value = 'id', $field_label='name',$size = 1,$multi  = 0);
	TemplateHelper::dt_edit_selectbox(FSText::_('District'),'district_id',@$data -> district_id,66,$districts,$field_value = 'id', $field_label='name',$size = 1,$multi  = 0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering);
	
	$this -> dt_form_end(@$data);
	// END BODY
?>
	
<script  type="text/javascript" language="javascript">
$(function(){
	$("select#country_id").change(function(){
		country_id = $(this).val();
		country_change(country_id);
	})			
	$("select#city_id").change(function(){
		city_id = $(this).val();
		city_change(city_id);
	})			
})
function country_change(country_id){
	$.getJSON("index.php?module=location&view=districts&task=get_cities_follow_country&raw=1",{cid: country_id}, function(j){
		
		var options = '';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
		}
		$("#city_id").html(options);
		$('#city_id option:first').attr('selected', 'selected');

		// change district follow city
		city_fisrt = $('#city_id option:first').val();
		city_change(city_fisrt);
		
	})
}
function city_change(city_id){
	$.getJSON("index.php?module=location&view=districts&task=district&raw=1",{cid: city_id}, function(j){
		var options = '';
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
		}
		$("#district_id").html(options);
		$('#district_id option:first').attr('selected', 'selected');
	})
}
</script>
