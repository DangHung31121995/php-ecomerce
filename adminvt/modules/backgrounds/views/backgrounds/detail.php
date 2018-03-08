<!-- HEAD -->
	
	<?php
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Name'); ?>
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Image'); ?>
				</td>
				<td>
					<?php if(@$data->image){?>
						<img alt="<?php echo $data->name?>" src="<?php echo URL_IMG_BACKGROUND.$data->image; ?>" width="200" height="200" /><br/>
					<?php }?>
					<input type="file" name="image"  />
				</td>
			</tr>
			<!--<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Màu nền'); ?>
				</td>
				<td>
					<input type="text" name='background_color' value="<?php echo @$data->background_color; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Repeat x'); ?>
				</td>
				<td>
					<input type="radio" name="repeat_x" value="1" <?php if(@$data->repeat_x) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="repeat_x" value="0" <?php if(!@$data->repeat_x) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Repeat y'); ?>
				</td>
				<td>
					<input type="radio" name="repeat_y" value="1" <?php if(@$data->repeat_y) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="repeat_y" value="0" <?php if(!@$data->repeat_y) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			
			--><tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Published'); ?>
				</td>
				<td>
					<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Default'); ?>
				</td>
				<td>
					<input type="radio" name="is_default" value="1" <?php if(@$data->is_default) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="is_default" value="0" <?php if(!@$data->is_default) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
				</td>
			</tr>
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
