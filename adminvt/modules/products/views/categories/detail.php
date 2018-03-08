<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin(0);?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><?php echo FSText::_("Thông tin cơ bản"); ?></a></li>
        <li><a href="#fragment-2"><?php echo FSText::_("Chi tiết"); ?></a></li>
        <li><a href="#fragment-3"><?php echo FSText::_("SEO"); ?></a></li>
    </ul>
    <div id="fragment-1">
        <table cellspacing="1" class="admintable" style="width: 100%;">
            <?php
            TemplateHelper::dt_edit_selectbox(FSText::_('Parent'), 'parent_id', @$data -> parent_id, 0, $categories,$field_value = 'id', $field_label='treename', $size = 1, 0, 1);
            TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
            TemplateHelper::dt_edit_selectbox(FSText::_('Bảng liên kết'),'tablename',@$data -> tablename,'',$tables,$field_value = 'table_name', $field_label='table_name',$size = 1, 0, 1);
            //TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',100,9);
            TemplateHelper::dt_edit_image(FSText :: _('Ảnh'),'icon',URL_ROOT.@$data -> icon);
            //TemplateHelper::dt_edit_image(FSText :: _('Banner (width 958px)'),'image',URL_ROOT.@$data -> image, 500);
            TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
            TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0);
            TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published, 1);
            ?>
        </table>
    </div><!--end: #fragment-1-->
    <div id="fragment-2">
        <table cellspacing="1" class="admintable" style="width: 100%;">
            <?php
            TemplateHelper::dt_edit_text(FSText :: _('Chi tiết'), 'content', @$data -> content, '', 700, 600, 1);
            ?>
        </table>
    </div><!--end: #fragment-2-->
    <div id="fragment-3">
        <table cellspacing="1" class="admintable">
            <?php
            TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
            TemplateHelper::dt_edit_text(FSText :: _('Title'),'seo_title',@$data -> seo_title,'',100,1);
            TemplateHelper::dt_edit_text(FSText :: _('Meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
            TemplateHelper::dt_edit_text(FSText :: _('Meta description'),'seo_description',@$data -> seo_description,'',100,9);	
            ?>
        </table>
    </div><!--end: #fragment-3-->
</div><!--end: .tabs-->
<?php $this -> dt_form_end(@$data,1,0); ?>
<script type="text/javascript">
    $(document).ready(function(){ $("#tabs").tabs();});
</script>