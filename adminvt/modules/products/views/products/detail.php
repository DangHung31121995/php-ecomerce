<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
$this -> dt_form_begin(0);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><?php echo FSText::_("Thông tin cơ bản"); ?></a></li>
        <li><a href="#fragment-2"><?php echo FSText::_("Chi tiết"); ?></a></li>
        <li><a href="#fragment-4"><?php echo FSText::_("Trường mở rộng"); ?></a></li>
        <li><a href="#fragment-3"><?php echo FSText::_("SEO"); ?></a></li>
    </ul>
    <div id="fragment-1">
        <table cellspacing="1" class="admintable">
            <?php
            TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
            TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name);
            TemplateHelper::dt_edit_text(FSText :: _('Mã SP'),'code',@$data -> code, '', '15');
            TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price_old',@$data -> price_old, 0, '20');
            TemplateHelper::dt_edit_selectbox('Loại giảm giá','discount_unit',@$data -> discount_unit,0,array('percent'=>'Phần trăm','price'=>'Giá trị'),$field_value = '', $field_label='');
            TemplateHelper::dt_edit_text(FSText :: _('Giảm giá'), 'discount', @$data -> discount, 0, '20');
            TemplateHelper::dt_edit_image(FSText :: _('Ảnh'),'image',str_replace('/original/','/tiny/',URL_ROOT.@$data->image));
            TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
            TemplateHelper::dt_checkbox(FSText::_('Tình trạng'),'status',@$data -> status,1);
            TemplateHelper::dt_checkbox(FSText::_('Mới'),'new',@$data->new,0);
            TemplateHelper::dt_checkbox(FSText::_('Hot'),'hot',@$data->hot,0);
            //TemplateHelper::dt_edit_text(FSText :: _('Xuất xứ'),'made',@$data -> made, 'Hàn Quốc', '30');
            TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'10');
            ?>
            <?php /*<tr>
                <td class="label key">Xuất xứ</td>
                <td class="value">
                    <select name="origin" id="origin" style="width: 200px;">
                        <option>--[Chọn]--</option>
                        <?php foreach($origins as $item){?>
                            <option <?php if(in_array($item->id, $datOrigin)) echo 'selected="selected"';?> value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label key">Color</td>
                <td class="value">
                    <select name="color[]" multiple="multiple" size="7" style="width: 200px;">
                    <?php foreach($colors as $item){?>
                        <option <?php if(in_array($item->id, $datColor)) echo 'selected="selected"';?> value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                    <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label key">Size</td>
                <td class="value">
                    <select name="size[]" multiple="multiple" size="7" style="width: 200px;">
                    <?php foreach($sizes as $item){?>
                        <option <?php if(in_array($item->id, $datSize)) echo 'selected="selected"';?> value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                    <?php }?>
                    </select>
                </td>
            </tr>
            */ ?>
        </table>
    </div><!--end: #fragment-1-->
    <div id="fragment-2">
        <table cellspacing="1" class="admintable" style="width: 100%;">
            <?php
            TemplateHelper::dt_edit_text(FSText :: _('Mô tả'), 'summary', @$data -> summary, '', 700, 600, 1);
            //TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại'), 'gifts', @$data->gifts, '',100,5);
            TemplateHelper::dt_edit_text(FSText :: _('Chi tiết'), 'content', @$data -> content, '', 700, 600, 1);
            //TemplateHelper::dt_edit_text(FSText :: _('Từ khóa tin liên quan'),'related_tags',@$data -> related_tags);
            //TemplateHelper::dt_edit_text(FSText :: _('Hướng dẫn sử dụng'), 'userguid', @$data -> userguid, '', 700, 600, 1);
            ?>
            <tr>
                <td class="label key">Thêm ảnh</td>
                <td class="value">
                    <div id="box-uploadify">
                        <table>
        					<tr>
        						<td style="vertical-align: middle;"><input type="file" name="file_upload" id="file_upload" /></td>
        						<td style="vertical-align: middle;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:$('#file_upload').uploadify('upload','*')"><img src="libraries/uploadify/upload.png" /></a></td>
        					</tr>
        				</table>
                        <script type="text/javascript" src="libraries/uploadify/jquery.uploadify.js"></script>
        				<link rel="stylesheet" type="text/css" href="libraries/uploadify/uploadify.css"/>
                        <div id="fileQueue"></div>
                        <script type="text/javascript">
                            $(function() {
                                $("#file_upload").uploadify({
                                    'auto'     : false,
                                    'fileSizeLimit' : '2048KB',
                                    'fileTypeDesc' : 'Image Files',
                                    'fileTypeExts' : '*.gif; *.jpg; *.png', 
                                    'queueID'  : 'fileQueue',
                                    'swf'         : 'libraries/uploadify/uploadify.swf',
                                    'uploader' : 'index2.php?module=products&view=products&raw=1&task=uploadProductImages&data=<?php echo $uploadConfig;?>',
                                    'onUploadComplete' : function(){
                                        $("#feeds").load("index2.php?module=products&view=products&raw=1&task=getProductImages&data=<?php echo $uploadConfig;?>");
                                    } 
                                });
                            });
                        </script>
                        <div id="feeds"></div><!--end: #feeds-->
                        <script type="text/javascript">$("#feeds").load("index2.php?module=products&view=products&raw=1&task=getProductImages&data=<?php echo $uploadConfig;?>");</script>
                    </div><!--end: #box-uploadify-->
                </td>
            </tr>
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
    <div id="fragment-4">
        <?php include_once 'detail_extend.php';?>
    </div><!--end: #fragment-4-->
</div>
<input type="hidden" name="session_id" value="<?php echo session_id();?>" />
<?php 		        	
$this -> dt_form_end(@$data,0);
?>
<script type="text/javascript">
    $(document).ready(function(){ $("#tabs").tabs();});
</script>