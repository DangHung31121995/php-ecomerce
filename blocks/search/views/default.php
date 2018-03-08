<?php 
$tmpl->addStylesheet($style, 'blocks/search/assets/css');
$text_default = '';
$keyword = $text_default;
$module = FSInput::get('module');
if($module == 'product'){
	$key = FSInput::get('keyword');
	if($key){
		$keyword = $key;
	}
}
$link = FSRoute::_('index.php?module=product&view=search');
?>
<div id="block-<?php echo $blockId?>" class="block-search block-search-<?php echo $style ?>">
    <form id="frm_search" name="frm_search" action="<?php echo $link?>" method="get">
        <input class="txt-search" type="text" id="keyword" name="keyword" placeholder="<?php echo $keyword; ?>" value="" />   
        <input type="submit" value="Tìm kiếm" />
        <input type="hidden" name="module" value="product"/>
    	<input type="hidden" name="view" value="search"/>
    	<input type="hidden" name="Itemid" value="2"/>
    </form>
</div><!--end: #block-<?php echo $blockId?>-->