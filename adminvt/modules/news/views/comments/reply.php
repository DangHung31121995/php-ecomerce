<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('back', FSText::_('Cancel'), '', 'back.png');
$this->dt_form_begin();
TemplateHelper::dt_text(FSText::_('Sản phẩm'), $record->title);
TemplateHelper::dt_text(FSText::_('Danh mục'), $record->category_name);
TemplateHelper::dt_text(FSText::_('Tên'), $parent->name);
TemplateHelper::dt_text(FSText::_('Email'), $parent->email);
TemplateHelper::dt_text(FSText::_('Comment'), $parent->comment);
TemplateHelper::dt_edit_text(FSText::_('Trả lời'), 'comment', @$data->comment, '', 60, 5, 1);
TemplateHelper::addInputHidden('reply', 1);
TemplateHelper::addInputHidden('reply_id', @$data->id);
TemplateHelper::addInputHidden('reply_product', $record->id);
TemplateHelper::addInputHidden('reply_parent', $parent->id);
$this->dt_form_end(@$data);
?>