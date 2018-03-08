<?php 
	if(isset($_SESSION['menusgroup_sort_field']))
	{
		$sort_field = $_SESSION['menusgroup_sort_field'];
		$sort_direct = $_SESSION['menusgroup_sort_direct'];
		$sort_direct = $sort_direct?$sort_direct:'asc';
	}
?>
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Menu Group List ') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'unpublished.png');
?>

<div class="form_body">
	<form action="index.php?module=menus&view=groups" name="adminForm" method="post">
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5" bordercolor='#CCC'>
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('Name'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Ordering'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Published'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Views Items'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Id'), 'id',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $link_view_items = "index.php?module=menus&view=items&gid=".$row->id; ?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="cid[]" id="cb<?php echo $i; ?>">
							</td>
							<td style="text-align: left;"><?php echo $row->group_name; ?></td>
							<td><?php echo $row->ordering; ?></td>
							<td><?php echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published"); ?></td>
							<td> <?php echo TemplateHelper::views($link_view_items); ?></td>
							<td><?php echo $row->id; ?></td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php echo $pagination->showPagination();?>
		</div>
		<input type="hidden" value="<?php echo $sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo $sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="menus" name="module">
		<input type="hidden" value="groups" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>