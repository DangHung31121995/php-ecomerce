<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Name'),'title',@$data -> title);
TemplateHelper::dt_edit_image(FSText :: _('Image'), 'image', URL_ROOT.@$data -> image);
TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
$this -> dt_form_end(@$data, 1, 0);
?>
