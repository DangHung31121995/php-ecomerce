<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Hạng thành viên') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
//	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
//	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
//	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
//	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
//			$filter_config  = array();
//			$fitler_config['search'] = 1; 
//			$fitler_config['filter_count'] = 1;
//			
//			$fitler_categories['title'] = FSText::_('Categories'); 
//			$fitler_categories['list'] = $categories; 
//			$fitler_categories['field'] = 'treename'; 
			


//			$fitler_config['filter'][] = $fitler_categories;
		
			
//			echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5" bordercolor="#CCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Level'), 'a.level',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Name'), 'a.name',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable('Tiền giao dịch tối thiểu', 'point',$sort_field,$sort_direct) ; ?>
					</th>
					<!--<th class="title">
						<?php echo  TemplateHelper::orderTable('Giảm giá (%)', 'discount',$sort_field,$sort_direct) ; ?>
					</th>
					
					<th class="title" width="7%">
						<?php echo FSText::_('S&#7917;a'); ?>
					</th>
					-->
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
						  
							<?php $link_detail = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?>
								    <input type="hidden" name='<?php echo "id_".$i; ?>' value="<?php echo $row->id; ?>"/>
								</td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td>
									<?php echo $row -> level; ?>
								</td>
								<td>
								    <input type="text" name='<?php echo "name_".$i; ?>' value="<?php echo $row->name; ?>" size="60" />
								    <input type="hidden" name='<?php echo "name_".$i."_original"; ?>' value="<?php echo $row->name; ?>"/>
								 </td>
<!--								 	<td>-->
<!--									 	<input type="text" name='<?php echo "point_".$i; ?>' value="<?php echo $row->point; ?>" size="60" />-->
<!--									    <input type="hidden" name='<?php echo "point_".$i."_original"; ?>' value="<?php echo $row->point; ?>"/>-->
<!--								 	</td>-->
								 	<td>
									 	<input type="text" name='<?php echo "money_".$i; ?>' value="<?php echo $row->money; ?>" size="60" />
<!--									 	<br/>	<?php echo format_money($row->money). ' VNĐ'?>-->
									    <input type="hidden" name='<?php echo "money_".$i."_original"; ?>' value="<?php echo $row->money; ?>"/>
								 	</td>
<!--								<td> <?php echo TemplateHelper::edit($link_detail); ?></td>-->
							</tr>
							<?php $i++; ?>
						<?php }?>
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
		<input type="hidden" value="<?php echo ($i+1);?>" name="total">
		<input type="hidden" value="<?php echo FSInput::get('page',0,'int');?>" name="page">
		<input type="hidden" value="<?php echo 'name,money,discount';?>" name="field_change">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>