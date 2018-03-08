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
					<?php echo FSText :: _('Alias'); ?>
				</td>
				<td>
					<input type="text" name='alias' value="<?php echo @$data->alias; ?>" /><font> (<?php echo FSText :: _("Can auto generate");?> )</font>
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
					<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Left content'); ?>
				</td>
				<td>
					<?php
					$oFCKeditor1 = new FCKeditor('content_left') ;
					$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
					$oFCKeditor1->Value		= @$data->content_left;
					$oFCKeditor1->Width = 650;
					$oFCKeditor1->Height = 450;
					$oFCKeditor1->Create() ;
					?>
				</td>

			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Right content'); ?>
				</td>
				<td>
					<?php
					$oFCKeditor = new FCKeditor('content_right') ;
					$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
					$oFCKeditor->Value		= @$data->content_right;
					$oFCKeditor->Width = 650;
					$oFCKeditor->Height = 450;
					$oFCKeditor->Create() ;
					?>
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
