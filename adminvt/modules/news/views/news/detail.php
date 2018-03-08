<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
$this -> dt_form_begin(0);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin cơ bản"); ?></span></a></li>
        <li><a href="#fragment-2"><span><?php echo FSText::_("Mô tả"); ?></span></a></li>
        <li><a href="#fragment-3"><span><?php echo FSText::_("Chi tiết"); ?></span></a></li>
        <li><a href="#fragment-4"><span><?php echo FSText::_("Cấu hình SEO"); ?></span></a></li>
    </ul>
    <div id="fragment-1">
        <table cellspacing="1" class="admintable">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
        TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
        TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/', '/tiny/', @$data->image));
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        TemplateHelper::dt_date_pick ( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20);
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        ?>
        </table>
    </div><!--end: #fragment-1-->
    <div id="fragment-2">
        <table cellspacing="1" class="admintable">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
        ?>
        </table>
    </div><!--end: #fragment-2-->
    <div id="fragment-3">
        <table cellspacing="1" class="admintable" style="width: 100%;">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
        ?>
        </table>
    </div><!--end: #fragment-3-->
    <div id="fragment-4">
        <table cellspacing="1" class="admintable">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
        TemplateHelper::dt_edit_text(FSText :: _('Alias gốc'),'old_url',@$data -> old_url,'',100,1);
        ?>
        </table>
    </div><!--end: #fragment-4-->
</div><!--end: #tabs-->
<?php
$this -> dt_form_end(@$data,0);
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#tabs").tabs();
    });
</script>