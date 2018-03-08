<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Save'),'','cancel.png'); 
	?>
<!-- END HEAD-->


<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=menus&view=groups" name="adminForm" method="post">
		<?php global $position; ?>
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Name'); ?>
				</td>
				<td>
					<input type="text" name='group_name' value="<?php echo @$data->group_name; ?>">
				</td>
			</tr>
			<tr>
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
					<?php echo FSText :: _('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo @$data->ordering; ?>">
				</td>
			</tr>
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="menus" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
