<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	?>
<!-- END HEAD-->


<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
    <div class="form-contents">
	<form action="index.php?module=users&view=users" name="adminForm" method="post">
		<fieldset>
			<legend><?php echo FSText :: _("user info");?></legend>
		
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Username'); ?>
					</td>
					<td>
						<input type="text" name='username' value="<?php echo @$data->username; ?>"  id="username">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Password'); ?>
					</td>
					<td>
						<input type="password" name='password' value="" id="password">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Re-password'); ?>
					</td>
					<td>
						<input type="password" name='repass' value="" id="repass">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<input type="text" name='email' value="<?php echo @$data->email; ?>" id="email" >
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('User group'); ?>
					</td>
					<td>
						<select name="group_ids[]" multiple="multiple" id="groups">
							<option value=""><?php echo FSText :: _('User group'); ?>
							<?php for ($i = 0 ; $i< count($groups_all) ;$i ++ ){?>
								<?php 
								if(isset($groups_contain_user) && (in_array($groups_all[$i]->id,@$groups_contain_user)))
									$checked = "selected=\"selected\"";
								else
									$checked = "";
								?>
								<option value="<?php echo $groups_all[$i]->id; ?>" <?php echo $checked; ?> ><?php echo $groups_all[$i]->group_name;  ?> </option>	
							<?php }?>
						</select>
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
			</fieldset>
			<fieldset>
				<legend><?php echo FSText :: _("Other information");?></legend>
				<table cellspacing="1" class="admintable">
					
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('First name'); ?>
						</td>
						<td>
							<input type="text" name='fname' value="<?php echo @$data->fname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Middle-last name'); ?>
						</td>
						<td>
							<input type="text" name='lname' value="<?php echo @$data->lname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Phone'); ?>
						</td>
						<td>
							<input type="text" name='phone' value="<?php echo @$data->phone; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Address'); ?>
						</td>
						<td>
							<input type="text" name='address' value="<?php echo @$data->address; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Country'); ?>
						</td>
						<td>
							<input type="text" name='country' value="<?php echo @$data->country; ?>" >
							
						</td>
					</tr>
				</table>
			</fieldset>
			
		
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="users" name="view">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->

<script type="text/javascript">
	function formValidator()
	{
		
		if(!notEmpty('username','T&#234;n &#273;&#259;ng nh&#7853;p kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; tr&#7889;ng'))
			return false;
		if(!checkMatchPass('M&#7853;t kh&#7849;u nh&#7853;p l&#7841;i kh&#244;ng &#273;&#250;ng'))
			return false;
		if(!emailValidator('email','B&#7841;n ph&#7843;i nh&#7853;p &#273;&#7883;a ch&#7881; Email'))
			return false;
		if(!madeSelection('groups','B&#7841;n ph&#7843;i ch&#7885;n nh&#243;m cho th&#224;nh vi&#234;n n&#224;y'))
			return false;
		return true;
		
	}
</script>

