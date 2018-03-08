<?php
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/products_filter/assets/css');
//$tmpl->addScript($style, 'blocks/products_filter/assets/js');
$html = '';
foreach($arr_filter_by_field as $field_show=>$filters){
    $html .= '<div class="filter filter-'.$filters[0]->field_name.'">';
    $html .= '    <div class="filter-title">'.$filters[0]->field_show.'</div>';
    $html .= '    <ul>';
    switch($filters[0]->field_name){
        case 'price':
            foreach($filters as $filter){
                $link = $this->create_link($filter);
                $html .= '        <li class="'.($filter->has_selected?'selected':'').'"><a href="'.$link.'" title="'.htmlspecialchars($filter->filter_show).'">'.$filter->filter_show.'</a></li>';
            }
        break;	
        case 'color':
            foreach($filters as $filter){ 
                $link = $this->create_link($filter);
                $html .= '        <li class="'.($filter->has_selected?'selected':'').'"><a href="'.$link.'" title="'.htmlspecialchars($filter->filter_show).'">'.$filter->filter_show.'</a></li>';
            }
        break;    
        default:
            foreach($filters as $filter){ 
                $link = $this->create_link($filter);
                $html .= '        <li class="check '.($filter->has_selected?'selected':'').'"><a href="'.$link.'" title="'.htmlspecialchars($filter->filter_show).'">'.$filter->filter_show.'</a></li>';
            }
    }
    $html .= '    </ul>';
    $html .= '</div>';
}
?>
<div id="block-<?php echo $blockId ?>" class="block-products-filter block-products-filter-<?php echo $style ?>">
    <div class="span3-title">
        Tìm kiếm theo
    </div><!--end: .span3-title-->
    <?php echo $html; ?>
    <input id="root_id" type="hidden" value="<?php echo $cat->id?>" />
</div><!--end: #block-<?php echo $blockId ?>-->