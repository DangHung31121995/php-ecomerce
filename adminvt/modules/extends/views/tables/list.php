<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Danh s&#225;ch c&#225;c b&#7843;ng ') );
	$toolbar->addButton('table_add',FSText::_('Th&#234;m  b&#7843;ng'),'','add.png');
	$toolbar->addButton('remove',FSText::_('X&#243;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'remove.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" width="100%" cellpadding="5" bordercolor="#cccccc">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('T&#234;n'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Đã tạo bảng'); ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $link_view_items = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&tablename=".$row->table_name; ?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->table_name; ?>"  name="cid[]" id="cb<?php echo $i; ?>">
							</td>
							<td align="left">
								<a href='<?php echo $link_view_items?>' >
									<?php echo $row->table_name; ?>
								</a>
							</td>
							<td>
								<?php 
									if($row->created_table)
									{
										echo "C&#243;";
									}
									else
									{
										echo "Kh&#244;ng";
									}
								?>
							</td>
							
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>