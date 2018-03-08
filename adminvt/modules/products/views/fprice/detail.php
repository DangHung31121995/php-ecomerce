<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Name'),'title',@$data -> title);
TemplateHelper::dt_edit_text(FSText :: _('Min'), 'value_min', @$data -> value_min, 0, 15, 1, 0);
TemplateHelper::dt_edit_text(FSText :: _('Max'), 'value_max', @$data -> value_max, 0, 15, 1, 0);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering, @$maxOrdering, '5');
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published, 1);
$this -> dt_form_end(@$data, 1, 0);
?>
