<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save', FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel', FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin(0);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin cơ bản"); ?></span></a></li>
        <li><a href="#fragment-2"><span><?php echo FSText::_("Cấu hình SEO"); ?></span></a></li>
    </ul>
    <div id="fragment-1">
        <table cellspacing="1" class="admintable">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
        //TemplateHelper::dt_edit_image(FSText :: _('Image'),'icon',URL_ROOT.str_replace('/original/', '/small/', @$data->icon));
        TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        ?>
            </table>
    </div><!--end: #fragment-1-->
    <div id="fragment-2">
        <table cellspacing="1" class="admintable">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
        ?>
        </table>
    </div><!--end: #fragment-2-->
</div><!--end: #tabs-->
<?php
$this -> dt_form_end(@$data,0,0);	
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#tabs").tabs();
    });
</script>