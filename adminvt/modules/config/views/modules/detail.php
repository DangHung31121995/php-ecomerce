<!-- HEAD -->
	<?php 
	$title = FSText :: _('Cấu hình SEO, Module'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
    <div class="form-contents">
	<form action="index.php?module=module" name="adminForm" method="post">
		<strong><?php echo @$data->title; ?></strong>
		<br/>
		<br/>
		<br/>
		<?php   include_once 'detail_seo.php';?>	
		<?php   include_once 'detail_cache.php';?>	
		<?php   include_once 'detail_params.php';?>	
		
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<input type="hidden" value="<?php echo $this->module; ?>" name="module">
		<input type="hidden" value="<?php echo $this->view; ?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->
