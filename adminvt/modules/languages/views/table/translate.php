<!-- HEAD -->
<?php 
	$title = 'Dịch sang ngôn ngữ: '.$language -> language; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body translate">
	<div id="msg_error"></div>
	<form action="index.php?module=languages&view=table" name="adminForm" method="post" enctype="multipart/form-data">
			
	<!--	BASE FIELDS    -->
			<table cellspacing="5" class="admintable" width="100%" align="left"  >
				<?php 
				$j = 0;
				for($i = 0; $i < count($fields_in_table); $i ++){
					$item = $fields_in_table[$i];
					$type = $item -> Type;
					$field  = $item -> Field;
					if($field == 'images' || $field == 'image' || $field == 'picture' || $field == 'img'|| $field == 'pictures' )
						continue;
					if(strpos($table -> field_not_display, ','.$field.',') !== false)
						continue;
						
					if(strpos($type,'text') !== false){
						
				?>
				<!--	TYPE == TEXT			-->
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  colspan="3">
						<strong>Field: <?php echo ucfirst($field)?></strong>
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  >
						Original
					</td>
					<td valign="top"  >
						<div id='<?php echo $field.'_old'; ?>'>
							<?php echo $data_old ->$field;  ?>
						</div>
					</td>
					<td valign="top"  >
<!--						<a href="javascript: copy_field('<?php echo $field; ?>')" >Copy</a>-->
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'>
					<td valign="top"  >
						Translate
					</td>
					<td valign="top"  colspan="2" >
						<?php 
							$oFCKeditor = new FCKeditor("$field") ;
							$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
							$oFCKeditor->Value		= @$data_new->$field;
							$oFCKeditor->Width = 150;
							$oFCKeditor->Height = 450;
							$oFCKeditor->Create() ;
						?>
					</td> 
				</tr>
				<tr class='row<?php echo $j%2;?>'>
					<td valign="top"   colspan="3" >
						<hr/>
					</td>
				</tr>
				<!--	end TYPE == TEXT			-->
						<?php $j++; ?>
					<?php } else if(strpos($type,'varchar') !== false){?>
					
				<!--	TYPE == VARCHAR			-->
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  colspan="1" align="left">
						Field:<strong> <?php echo ucfirst(FSText::_($field))?> </strong>
					</td>
					<td valign="top" align="left" >
						<a href="javascript: copy_field('<?php echo $field; ?>')" title="Copy" ><img src="templates/default/images/toolbar/copy.png" alt="Copy" /></a>
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  align="left" width="150" >
						Original
					</td>
					<td valign="top"  align="left">
						<div class='<?php echo $field.'_old'; ?>'>
							<?php echo $data_old ->$field;  ?>
						</div>
						<input type="hidden" id='<?php echo $field.'_old'; ?>' value="<?php echo $data_old ->$field;  ?>">
					</td>
				</tr>
				<tr  class='row<?php echo $j%2;?>' >
					<td valign="top"  >
						Translate
					</td>
					<td valign="top"  colspan="2" >
						<input type="text" value="<?php echo @$data_new ->$field;  ?>" name='<?php echo $field?>' id='<?php echo $field?>' size="80" />	
					</td>
					
				</tr>
				<tr  class='row<?php echo $j%2;?>' >
					<td valign="top"   colspan="3" >
						<hr/>
					</td>
				</tr>
				<!--	end TYPE == VARCHAR			-->
					<?php $j++; ?>
					<?php }?>
				<?php } ?>
			</table>
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $table_id;?>" name="table">
		<input type="hidden" value="<?php echo $language -> lang_sort;?>" name="lang_sort">
		<input type="hidden" value="<?php echo $language -> id;?>" name="lang_id">
		<input type="hidden" value="<?php echo $id;?>" name="id">
		<input type="hidden" value="<?php echo @$data_new -> rid;?>" name="rid">
		<input type="hidden" value="table" name="view">
		<input type="hidden" value="languages" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
<script type="text/javascript">
	function copy_field(field){
		value = $('#'+field+'_old').val();
		console.log(value);
		$('#'+field).val(value);
	}
</script>


