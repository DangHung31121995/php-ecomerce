<link href="../libraries/autocomplete/jquery.autocomplete.css" media="screen" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../libraries/autocomplete/jquery.autocomplete.js"></script>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Sửa thông tin thành viên'): FSText::_('Thêm thành viên'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=sale&view=members" name="adminForm" method="post" enctype="multipart/form-data">
			
			<!--	BASE FIELDS    -->
			<table cellpadding="6" cellspacing="0">
				<tr>
					<td class="label1"><span>H&#7885; </span></td>
					<td class="value1">
							<input type="text" name="fname" id="fname" value="<?php echo @$data->fname; ?>" />
					</td>
				</tr>
				<tr>
					<td class="label1"><span>T&ecirc;n &#273;&#7879;m </span></td>
					<td class="value1">
						<input type="text" name="mname" id="mname" value="<?php echo @$data->mname; ?>" />
					</td>
				</tr>
				<tr>
					<td class="label1"><span>T&ecirc;n </span></td>
					<td class="value1">
						<input type="text" name="lname" id="lname" value="<?php echo @$data->lname; ?>" />
					</td>
				</tr>
				<tr>
					<td class="label1"><span>Ng&agrave;y sinh</span></td>
					<td class="value1">
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
					<td class="label1"><span>Gi&#7899;i t&iacute;nh</span></td>
					<td class="value1">
							<span><?php echo FSText::_("N&#7919;");?></span>
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
							
							<span><?php echo FSText::_("Nam");?></span> 
							<input type="radio" name="sex" id="sex" value = "male" <?php echo $checkM; ?>/>
					</td>
					
				</tr>
				<tr>
					<td class="label1"><span>S&#7889; CMND</span></td>
					<td class="value1">
					<input type="text" name="identity_card" value="<?php echo @$data->identity_card; ?>" />
				</tr>
				<tr>
					<td class="label1"><span>Scan CMND</span></td>
					<td class="value1">
						<input type="file" name="identity_img" title="<?php echo FSText::_("Identity"); ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="label1"><span>&#7842;nh &#273;&#7841;i di&#7879;n</span></td>
					<td class="value1">
						<input type="file" name="avatar" title="<?php echo FSText::_("Avatar"); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label1"><span>&#272;&#7883;a ch&#7881; th&#432;&#7901;ng ch&uacute;</span></td>
					<td class="value1">
						<input type="text" name="origin_address" id="origin_address" value="<?php echo @$data->origin_address; ?>" />
						<span><?php echo FSText::_("Trong CMND"); ?></span>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>T&#7881;nh/th&agrave;nh ph&#7889;</span></td>
					<td class="value1">
						<select name="province" id = "province">
							<?php foreach($cities as $city){?>
								<?php $checked =  (@$data->province == $city->id)? " selected = 'selected'": ""; ?>
								<option value="<?php echo $city->id; ?>" <?php echo $checked; ?>><?php echo $city->name ; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>Qu&#7853;n/huy&#7879;n</span></td>
					<td class="value1">
						<select name="district" id = "district">
							<?php foreach($districts as $district){?>
								<?php $checked =  (@$data->district == $district->id)?  " selected = 'selected'": ""; ?>
								<option value="<?php echo $district->id; ?>" <?php echo $checked; ?> ><?php echo $district->name ; ?></option>
							<?php } ?>
						</select>
				</tr>
				<tr>
					<td class="label1"><span>&#272;i&#7879;n tho&#7841;i</span></td>
					<td class="value1">
						<input type="text" name="phone" id="phone"  value="<?php echo @$data-> phone; ?>" />
				</tr>
				<tr>
					<td class="label1"><span>Email</span></td>
					<td class="value1">
						<input type="text" name="email" id="email" value="<?php echo @$data-> email; ?>" />
					</td>
				</tr>
					<tr>
					<td class="label1"><span>Nh&#7853;p l&#7841;i email</span></td>
					<td class="value1">
						<input type="text" name="re_email" id="re_email" value="<?php echo @$data-> email; ?>" />
					</td>
				</tr>
				<tr>
					<td class="label1"><span>S&#7889; sim </span></td>
					<td class="value1">
						<span><?php echo @$data->sim_number; ?></span>
						<br/>
						<span>&#272;&#7893;i s&#7889; sim  </span><input type="checkbox" name="change_sim" id="change_sim" value="<?php echo @$data->sim_number; ?>" >
						<br/>
						<span>H&#7911;y sim sau khi &#273;&#7893;i </span><input type="checkbox" name="del_sim" id="del_sim" value="1" >
						<br/>
						<div id="change_sim_area">
						<input type='text' name='sim_number' id='sim_number'  value='917'  />
						</div>
					</td>
				</tr>
			
				<tr>
					<td class="label1"><span>C&#7845;p &#273;&#7897; th&agrave;nh vi&ecirc;n</span></td>
					<?php $Itemid = FSInput::get('Itemid');
						$link_upgrade = Route::_("index.php?module=users&task=upgrade&Itemid=$Itemid"); 
					?>
					<td class="value1">
						<select name="level" >
							<option value='0' <?php if(!@$data -> level) echo "selected='selected'";?>  >Th&agrave;nh vi&ecirc;n th&#432;&#7901;ng</option>
							<option value='1' <?php if(@$data -> level == 1) echo "selected='selected'";?>  >Th&agrave;nh vi&ecirc;n Silver</option>
							<option value='2' <?php if(@$data -> level == 2) echo "selected='selected'";?>  >Th&agrave;nh vi&ecirc;n Gold</option>
						</select>
				

					</td>
				</tr>
				<tr>
					<td class="label1"><span>Y&ecirc;u c&#7847;u n&acirc;ng c&#7845;p</span></td>
					<td class="value1">
					<?php
					if(@$data -> upgrade_level > @$data -> level)
					{
						echo "<strong class='red'>C&oacute;</strong>"; 
					}
					else
					{
						echo "Kh&ocirc;ng";
					}
					?>
					</td>
				</tr>
				<?php if(isset($data) && (@$data -> upgrade_level > @$data -> level)) { ?>
				<tr>
					<td class="label1"><span>&#272;&#7891;ng &yacute; n&acirc;ng c&#7845;p</span></td>
					<td class="value1">
						<input type="radio" name="upgrade" id="upgrade0"  value="1"/> &#272;&#7891;ng&yacute;
						<input type="radio" name="upgrade" id="upgrade1"  value="0"/> Kh&ocirc;ng &#273;&#7891;ng&yacute;
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="label1"><span>S&#272;T ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
					<td class="value1">
						<input type="text" name="referrer" id="referrer"  value="<?php echo @$data -> referrer_sim; ?>"/> 
				</tr>
				<tr>
					<td class="label1"><span>T&ecirc;n ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
					<td class="value1"><span id = "referrer_name"><?php echo @$data->re_fname. " ".@$data -> re_mname." ". @$data -> re_lname; ?></span></td>
				</tr>
				<tr>
					<td class="label1"><span>Activated</span></td>
					<td class="value1">
					<?php 
					$check_Y = @$data -> isActivated == 1 ?  "checked='checked'":"";
					$check_N = @$data -> isActivated == 1 ?  "":"checked='checked'";
					?>
						<input type="radio" name="isActivated" id="isActivated0"  value="1" <?php echo $check_Y; ?>/> Có
						<input type="radio" name="isActivated" id="isActivated1"  value="0" <?php echo $check_N; ?>/> Không
					</td>
				</tr>
				<tr>
					<td class="label1"><span>Kh&oacute;a</span></td>
					<td class="value1">
					<?php 
					$check_1 = @$data -> block == 1 ?  "checked='checked'":"";
					$check_0 = @$data -> block == 1 ?  "":"checked='checked'";
					?>
						<input type="radio" name="block" id="block0"  value="1" /> Kh&oacute;a
						<input type="radio" name="block" id="block1"  value="0"  /> Kh&ocirc;ng kh&oacute;a 
					</td>
				</tr>
				<tr>
					<td class='label1'><font>*</font><?php echo FSText::_("Password")?></td>
					<td class='value1'>
						<input type="password" name="password" id="password" />
					</td>
				</tr>
				<tr>
					<td class='label1'><font>*</font><?php echo FSText::_("Re-Password")?></td>
					<td class='value1'>
						<input type="password" name="re-password" id="re-password" />
					</td>
				</tr>
			</table>	
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo @$data->id; ?>" name="cid">
		<?php }?>
		<input type="hidden" value="members" name="view">
		<input type="hidden" value="members" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">

//sim number
var sim_unactivated = [
                 <?php for($i=0;$i < count($sim_unactivated); $i++ ) { ?>
                 { num:"<?php echo $sim_unactivated[$i]-> sim_number; ?>"} <?php if($i < (count($sim_unactivated)-1)) echo "," ; ?>
                 <?php } ?>
                                 ];

function check_simnumber()
{
	sim_number = $("#sim_number").val();
	if(!sim_number)
	{
		alert('Bạn cần nhập số điện thoại');
	}
	else
	{
		$.ajax({
			  url: "index.php?module=members&task=check_sim_number&raw=1&sim="+sim_number+"",
			  cache: false,
			  success: function(json){
			    	if(json == 0)
			    	{
			    		helperMsg = "<?php echo FSText::_("Sim n&agrave;y kh&ocirc;ng t&#7891;n t&#7841;i"); ?>" ;
			    		alert(helperMsg);
			    	}
			    	else if( json == '-1' )
			    	{
			    		helperMsg = "<?php echo FSText::_("Sim n&agrave;y ch&#432;a k&iacute;ch ho&#7841;t"); ?>" ;
			    		alert(helperMsg);
			    	}
			    	else
			    	{
			    		$("#fullname").html(json);
			    	}
			  },
			  error: function()
			  {
				 alert('error');
				 return false;
			  }
			});
		return false;
	}
}

	
          
              $().ready(function() {

                  // auto referrer
		

	              // sim_number
	              $("#sim_number").focus().autocomplete(sim_unactivated,{
	              	minChars: 0,
	              	scrollHeight: 300,
	              	formatItem: function(row, i, max) {
	              	return  row.num ;
	              	},
	              	formatResult: function(row) {
	              		return row.num;
	              	}
	              	});
	              	
          	
              });
			
             
$(function(){
//	$("#change_sim").click(function(){
//		if($("#change_sim").is(':checked'))
//		{
//			$("#change_sim_area").html("<input type='text' name='sim_number' id='sim_number'  value='917'  />");
//		}
//		else
//		{
//			$("#change_sim_area").html("");
//		}
//	});
	
	$("select#province").change(function(){
		$.getJSON("index.php?module=members&task=district&raw=1",{cid: $(this).val()}, function(j){
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				
			}
			$("#district").html(options);
			$('#district option:first').attr('selected', 'selected');
		})
	})		

	
		
})
</script>
