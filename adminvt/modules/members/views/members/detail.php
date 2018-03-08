<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Sửa thông tin thành viên'): FSText::_('Thêm thành viên'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
			
			<!--	BASE FIELDS    -->
			<table cellpadding="6" cellspacing="0" class="admintable">
				<tr>
					<td class="label key"><span>Username </span></td>
					<td class="value">
							<input type="text" name="username" id="username" value="<?php echo @$data->username; ?>" />
					</td>
				</tr>
				<tr>
					<td class="label key"><span>Họ tên </span></td>
					<td class="value">
							<input type="text" name="fullname" id="fullname" value="<?php echo @$data->fullname; ?>" />
					</td>
				</tr>
				<?php /* <tr>
					<td class="label key"><span>Ng&agrave;y sinh</span></td>
					<td class="value">
						<span><?php echo FSText::_("Day"); ?></span>		
						<select name="birth_day">
							<?php 
								$day = date('d',strtotime(@$data->birthday));
								$month = date('m',strtotime(@$data->birthday));
								$year = date('Y',strtotime(@$data->birthday));
							?>
							<?php for($i = 1 ; $i < 32 ; $i ++ ) {?>
								<?php $check = ($i == $day) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
							<?php }?>
						</select>	
						
						<span><?php echo FSText::_("Month"); ?></span>		
						<select name="birth_month">
							<?php for($i = 1 ; $i < 13 ; $i ++ ) {?>
							<?php $check = ($i == $month) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
							<?php }?>
						</select>	
						
						<span><?php echo FSText::_("Year"); ?></span>		
						<select name="birth_year">
							<?php $current_year = date("Y");?>
							<?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
							<?php $check = ($i == $year) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
							<?php }?>
						</select>	
					
					</td>
				</tr> 
				<tr>
					<td class="label key"><span>Gi&#7899;i t&iacute;nh</span></td>
					<td class="value">
							<span><?php echo FSText::_("Female");?></span>
								<?php 
								if(@$data->sex == 'female')
								{
									$checkF = "checked='checked'";
									$checkM = "";
								}
								else
								{
									$checkM = "checked='checked'";
									$checkF = "";
								}

								?>
							<input type="radio" name="sex" id="sex" value = "female"  <?php echo $checkF; ?>  />
							
							<span><?php echo FSText::_("Male");?></span> 
							<input type="radio" name="sex" id="sex" value = "male" <?php echo $checkM; ?>/>
					</td>
					
				</tr>
				<tr>
					<td class="label key"><span>S&#7889; CMND</span></td>
					<td class="value">
					<input type="text" name="identity_card" value="<?php echo @$data->identity_card; ?>" />
				</tr>*/ ?>
				<tr>
					<td class="label key"><span>&#7842;nh &#273;&#7841;i di&#7879;n</span></td>
					<td class="value">
						<input type="file" name="avatar" title="<?php echo FSText::_("Avatar"); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label key"><span>&#272;&#7883;a ch&#7881; th&#432;&#7901;ng ch&uacute;</span></td>
					<td class="value">
						<input type="text" name="address" id="address" value="<?php echo @$data->address; ?>" />
						<span><?php echo FSText::_("In the identity card"); ?></span>
					</td>
				</tr>
				<tr>
					<td class="label key"><span>T&#7881;nh/th&agrave;nh ph&#7889;</span></td>
					<td class="value">
						<select name="city_id" id = "city_id">
							<?php foreach($cities as $city){?>
								<?php $checked =  (@$data->city_id == $city->id)? " selected = 'selected'": ""; ?>
								<option value="<?php echo $city->id; ?>" <?php echo $checked; ?>><?php echo $city->name ; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label key"><span>Qu&#7853;n/huy&#7879;n</span></td>
					<td class="value">
						<select name="district_id" id = "district_id">
							<?php foreach($districts as $district){?>
								<?php $checked =  (@$data->district == $district->id)?  " selected = 'selected'": ""; ?>
								<option value="<?php echo $district->id; ?>" <?php echo $checked; ?> ><?php echo $district->name ; ?></option>
							<?php } ?>
						</select>
				</tr>
				<tr>
					<td class="label key"><span>&#272;i&#7879;n tho&#7841;i</span></td>
					<td class="value">
						<input type="text" name="mobile" id="mobile"  value="<?php echo @$data-> mobile; ?>" />
				</tr>
				<tr>
					<td class="label key"><span>Email</span></td>
					<td class="value">
						<input type="text" name="email" id="email" value="<?php echo @$data-> email; ?>" />
					</td>
				</tr>
                <?php /* 
				<tr>
					<td class="label key"><span>Tiền giao dịch</span></td>
					<td class="value">
						<?php echo format_money($data->money).' VNĐ'; ?> 
						<a href="javascript:view_order_fast(<?php echo $data -> id; ?>)"><strong class='red'>Xem lịch sử giao dịch</strong></a>
					</td>
				</tr>
				<tr>
					<td class="label key"><span  class='red'>C&#7845;p &#273;&#7897; th&agrave;nh vi&ecirc;n</span></td>
					<td class="value">
						<select name="level" id = "level">
							<?php foreach($arr_level as $item){?>
								<?php $checked =  (@$data->level == $item->level)?  " selected = 'selected'": ""; ?>
								<option value="<?php echo $item->level; ?>" <?php echo $checked; ?> ><?php echo $item->name ; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr> */?>
				
                <tr>
					<td class="label key"><span><?php echo FSText::_('Published')?></span></td>
					<td class="value">
					<?php 
					$check_Y = @$data -> isActivated == 1 ?  "checked='checked'":"";
					$check_N = @$data -> isActivated == 1 ?  "":"checked='checked'";
					?>
						<input type="radio" name="isActivated" id="isActivated0"  value="1" <?php echo $check_Y; ?>/> Có
						<input type="radio" name="isActivated" id="isActivated1"  value="0" <?php echo $check_N; ?>/> Không
					</td>
				</tr> 
                <?php /*<tr>
					<td colspan="2"><hr/></td>
				</tr>
				<tr>
					<td class="label key"><span><?php echo FSText::_('Sửa password')?></span></td>
					<td class="value">
						<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> Có
						<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" checked="checked"/> Không
					</td>
				</tr>
                */?>
				<tr class='password_area'>
					<td class='label key'><font>*</font><?php echo FSText::_("Password")?></td>
					<td class='value'>
						<input type="password" name="password1" id="password" />
					</td>
				</tr>
				<tr class='password_area'>
					<td class='label key'><font>*</font><?php echo FSText::_("Re-Password")?></td>
					<td class='value'>
						<input type="password" name="re-password1" id="re-password" />
					</td>
				</tr>
			</table>	
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo @$data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="members" name="view">
		<input type="hidden" value="members" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">
$(function(){
	$("select#city_id").change(function(){
		$.getJSON("index.php?module=members&task=district&raw=1",{cid: $(this).val()}, function(j){
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				
			}
			$("#district_id").html(options);
			$('#district_id option:first').attr('selected', 'selected');
		})
	});
	$('.password_area').hide();
	$('#edit_pass0').click(function(){
		$('.password_area').hide();
	});
	$('#edit_pass1').click(function(){
		$('.password_area').show();
	});
})

function view_order_fast(id){
	if(id)
		window.open("index2.php?module=order&view=order_fast&uid="+id, "","height=600,width=900,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
</script>
