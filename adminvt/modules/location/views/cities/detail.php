<!-- HEAD -->
	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
    $regions = array(
        array('id'=>'1', 'name' => 'Miền Bắc'),
        array('id'=>'2', 'name' => 'Miền Trung'),
        array('id'=>'3', 'name' => 'Miền Nam')
    );
    $regions = json_decode(json_encode($regions)); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
            <?php TemplateHelper::dt_edit_selectbox(FSText::_('Country'),'country_id',@$data -> country_id,66,$countries,$field_value = 'id', $field_label='name',$size = 1,$multi  = 0);?>
            <?php TemplateHelper::dt_edit_selectbox(FSText::_('Miền'),'region',@$data->region, 66, $regions, $field_value = 'id', $field_label='name', $size = 1, $multi  = 0, 1);?>
			<?php TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);?>
			<?php TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);?>
			<?php TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering);?>
            <?php TemplateHelper::dt_edit_text(FSText :: _('Phí ship'),'shipping',@$data -> shipping, 0);?>
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
