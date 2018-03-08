<?php 
$title = @$data ? FSText :: _('S&#7917;a v&#7883; tr&#237; hi&#7875;n th&#7883;'): FSText :: _('T&#7841;o m&#7899;i v&#7883; tr&#237; hi&#7875;n th&#7883;'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
?>
<div class="form_body">
    <div class="form-contents">
	<form action="index.php?module=module" name="adminForm" method="post">
					<?php global $position; ?>
					<table cellspacing="1" class="admintable">
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Title'); ?>
							</td>
							<td>
								<input type="text" name='title' value="<?php echo @$data->title; ?>">
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
								<?php echo FSText :: _('Hiển thị tiêu đề'); ?>
							</td>
							<td>
								<input type="radio" name="showTitle" value="1" <?php if(@$data->showTitle) echo "checked=\"checked\"" ;?> />
								<?php echo FSText :: _('Yes'); ?>
								<input type="radio" name="showTitle" value="0" <?php if(!@$data->showTitle) echo "checked=\"checked\"" ;?> />
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
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('N&#417;i xu&#7845;t hi&#7879;n'); ?>
							</td>
							<td>
								<div>
									<input type="radio" id = 'check_none' name='area_select' value='none' <?php echo (!@$data->listItemid||@$data->listItemid == 'none')? 'checked="checked"':'';?> /> Kh&#244;ng n&#417;i n&#224;o
									<input type="radio" id = 'check_select' name='area_select' value='select' <?php echo (@$data->listItemid && @$data->listItemid != 'none' && @$data->listItemid != 'all')? 'checked="checked"':'';?> /> L&#7921;a ch&#7885;n
									<input type="radio" id = 'check_all' name='area_select'  value='all' <?php echo (@$data->listItemid == 'all')? 'checked="checked"':'';?> /> T&#7845;t c&#7843;
								</div>
								<?php 
									$listItemid = @$data->listItemid;
									$checked = 0;
									$checked_all = 0;
									if((!@$data->listItemid) || @$data->listItemid === 'none' || @$data->listItemid === '0'){
										$checked = 0;
									} else if(@$data->listItemid === 'all'){
										$checked_all = 1;
									} else {
										$checked = 1;
										$checked_all = 0;
										$arr_menu_item = explode(',',@$data->listItemid);
									}
								?>
								<select name ="menus_items[]" size="10" multiple="multiple" class='listItem' <?php echo (!@$data->listItemid || @$data->listItemid == 'none' || @$data->listItemid == 'all')? 'disabled="disabled"':'';?> >
									<?php 
									foreach($menus_items_all as $item) {
										$html_check = "";
										if($checked_all){
											$html_check = "' selected='selected' ";
										} else {
											if($checked){
												if(in_array($item->id,$arr_menu_item)) {
													$html_check = "' selected='selected' ";
												}
											}
										}
									?>
										<option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item -> name; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
                        <tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Module và danh mục'); ?>
							</td>
							<td>
								<div>
									<input type="radio" id = 'module_check_none' name='module_select' value='none' <?php echo (@$data->module_categories == 'none')? 'checked="checked"':'';?> /> Kh&#244;ng n&#417;i n&#224;o
									<input type="radio" id = 'module_check_select' name='module_select' value='select' <?php echo (@$data->module_categories && @$data->module_categories != 'none' && @$data->module_categories != 'all')? 'checked="checked"':'';?> /> L&#7921;a ch&#7885;n
									<input type="radio" id = 'module_check_all' name='module_select'  value='all' <?php echo (!@$data->module_categories||@$data->module_categories == 'all')? 'checked="checked"':'';?> /> T&#7845;t c&#7843;
								</div>
								<?php 
								//$module_categories = @$data->module_categories;
								$checked = 0;
								$checked_all = 0;
								if((!@$data->module_categories) || @$data->module_categories === 'none' || @$data->module_categories === '0'){
									$checked = 0;
								} else if(@$data->module_categories === 'all'){
									$checked_all = 1;
								} else {
									$checked = 1;
									$checked_all = 0;
									$arr_menu_item = explode(',',@$data->module_categories);
								}
								?>
								<select id="module_categories" name ="module_categories[]" size="10" multiple="multiple" <?php echo (!@$data->module_categories || @$data->module_categories == 'none' || @$data->module_categories == 'all')? 'disabled="disabled"':'';?> >
									<?php 
									foreach($module_categories as $module) {
                                    ?>
                                        <optgroup label="<?php echo $module['label'] ?>">
                                            <?php 
                                            foreach($module['categories'] as $item){ 
                                                $item_value = $module['module'].'_'.$item->alias;
                                            ?>
                                                <?php
            										$html_check = "";
            										if($checked_all){
            											$html_check = "' selected='selected' ";
            										} else {
            											if($checked){
                                                            
            												if(in_array($item_value, $arr_menu_item)) {
            													$html_check = "' selected='selected' ";
            												}
            											}
            										}
            									?>
        										<option value="<?php echo $item_value?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
                                            <?php } ?>
                                        </optgroup>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Kiểu'); ?>
							</td>
							<td>
								<select name="type" class="type" >
										<?php
										$block_select = isset($data->module)?$data->module:'contents';
										foreach($listmoduletype as $item){
											if( $item->block == $block_select ){
												echo "<option value='" . $item -> block. "' selected='selected'>" . $item->name . "</option>";
											}
											else{
												echo "<option value='" . $item -> block . "'>" . $item->name . "</option>";
											}
										} 
										?>
									</select>
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('V&#7883; tr&#237;'); ?>
							</td>
							<td>
								<select name="position" class="pos" >
										<?php
										foreach($positions as $p){
											if( (@$data->position) && $p == @$data->position ){
												echo "<option value='" . $p . "' selected='selected'>" . $p . "</option>";
											}
											else{
												echo "<option value='" . $p . "'>" . $p . "</option>";
											}
										} 
										?>
									</select>
							</td>
						</tr>
						<?php if( @$data->module == 'contents'){?>
						<tr>	
							<td valign="top" class="key">
									<?php echo FSText :: _('Content'); ?>
							</td>
							<td>
								<?php
									$oFCKeditor = new FCKeditor('content') ;
									$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
									$oFCKeditor->Value		= @$data->content;
									$oFCKeditor->Width = 650;
									$oFCKeditor->Height = 450;
									$oFCKeditor->Create() ;
									?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Parameters'); ?>
							</td>
							<td   valign="top">
								<?php   include_once 'detail_params.php';?>	
							</td>
						</tr>
					</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id" />
		<?php }?>
		<input type="hidden" value="module" name="module" />
		<input type="hidden" value="" name="task" />
		<input type="hidden" value="0" name="boxchecked" />
	</form>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#check_none').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', '');
			});
			$('.listItem').attr('disabled','disabled');
		});
		$('#check_all').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.listItem').attr('disabled','disabled');
		});
		$('#check_select').click(function(){
			$('.listItem').removeAttr('disabled');
		});
        $('#module_check_none').click(function(){
			$('#module_categories option').each(function(){
				$(this).attr('selected', '');
			});
			$('#module_categories').attr('disabled','disabled');
		});
		$('#module_check_all').click(function(){
			$('#module_categories option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('#module_categories').attr('disabled','disabled');
		});
		$('#module_check_select').click(function(){
			$('#module_categories').removeAttr('disabled');
		});
	});
</script>