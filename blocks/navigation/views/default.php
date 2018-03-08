<?php
global $tmpl; 
//$tmpl->addStylesheet($style, 'blocks/navigation/assets/css');
if(!$list) 
    return;
$Itemid = FSInput::get('Itemid', 1);
?>
<ul  class="<?php echo $class?>">
    <li class="home">
        <a rel="nofollow" href="<?php echo URL_ROOT?>"><span class="menu-title" title="Trang chủ">Trang chủ</span></a>
    </li>
    <?php 
    foreach($list as $item){ 
        $link = FSRoute::_($item->link.'&Itemid='.$item->id);
    ?>
        <?php if($item->children){ ?>
            <?php if($item->is_html){?>
                <li class="parent dropdown">
                    <a href="<?php echo $link?>" data-toggle="dropdown" class="dropdown-toggle" title="<?php echo htmlspecialchars($item->name)?>">
                        <span class="menu-title"><?php echo $item->name; ?></span>
                    </a>
                    <div style="width:850px" class="dropdown-menu level1">
                        <div class="dropdown-menu-inner">
                            <div class="row-fluid">
                                <?php 
                                $htmlLi1 = '';
                                $htmlLi2 = '';
                                $totalSub = count($item->children);
                                $halfTotal = ceil($totalSub/2);
                                $tmp = 0;
                                foreach($item->children as $li){
                                    $link = FSRoute::_($li->link.'&Itemid='.$li->id);
                                    $html = '<li>';
                                    if($Itemid == 1){
                                        $html .= '    <h2><a href="'.$link.'" class="dropdown-toggle" title="'.htmlspecialchars($li->name).'">';
                                        $html .= '        <span class="menu-title">'.$li->name.'</span>';
                                        $html .= '    </a></h2>';
                                    }else{
                                        $html .= '    <a href="'.$link.'" class="dropdown-toggle" title="'.htmlspecialchars($li->name).'">';
                                        $html .= '        <span class="menu-title">'.$li->name.'</span>';
                                        $html .= '    </a>';
                                    }
                                    $html .= '</li>';
                                    if($tmp < $halfTotal)
                                        $htmlLi1 .= $html;
                                    else
                                        $htmlLi2 .= $html;
                                    $tmp++;
                                }
                                ?>
                                <div data-type="menu" class="mega-col span3 col-1">
                                    <div class="mega-col-inner">
                                        <ul>
                                            <?php echo $htmlLi1; ?>
                                        </ul>
                                    </div><!--end: .mega-col-inner-->
                                </div><!--end: .mega-col.span3.col-1-->
                                <div data-type="menu" class="mega-col span3 col-2">
                                    <div class="mega-col-inner">
                                        <ul>
                                            <?php echo $htmlLi2; ?>
                                        </ul>
                                    </div><!--end: .mega-col-inner-->
                                </div><!--end: .mega-col.span3.col-2-->
                                <div data-type="menu" class="mega-col span6 col-3">
                                    <div class="mega-col-inner">
                                        <ul>
                                            <li>
                                                <div class="menu-content">
                                                    <div class="pav-menu-video">
                                                        <?php echo $item->html; ?>
                                                    </div>
                                                </div><!--end: .menu-content-->
                                            </li>
                                        </ul>
                                    </div><!--end: .mega-col-inner-->
                                </div>
                            </div><!--end: .row-fluid-->
                        </div><!--end: .dropdown-menu-inner-->
                    </div><!--end: .dropdown-menu-->
                <?php }else{ ?>
                    <li class="parent dropdown pav-parrent singlesub">
                        <a href="<?php echo $link?>" data-toggle="dropdown" class="dropdown-toggle" title="<?php echo htmlspecialchars($item->name); ?>">
                            <span class="menu-title"><?php echo $item->name; ?></span>
                        </a>
                        <div class="dropdown-menu level1">
                            <div class="dropdown-menu-inner">
                                <div class="row-fluid">
                                    <div data-type="menu" class="mega-col span12">
                                        <div class="mega-col-inner">
                                            <ul>
                                                <?php foreach($item->children as $li){
                                                    $link = FSRoute::_($li->link.'&Itemid='.$li->id); ?>
                                                    <li class=" ">
                                                        <?php if($Itemid == 1){ ?>
                                                            <h2><a rel="nofollow" href="<?php echo $link?>" title="<?php echo htmlspecialchars($li->name); ?>">
                                                                <span class="menu-title"><?php echo $li->name; ?></span>
                                                            </a></h2>
                                                        <?php }else{ ?>
                                                            <a rel="nofollow" href="<?php echo $link?>" title="<?php echo htmlspecialchars($li->name); ?>">
                                                                <span class="menu-title"><?php echo $li->name; ?></span>
                                                            </a>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div><!--end: .mega-col-inner-->
                                    </div><!--end: .mega-col.span12-->
                                </div><!--end: .row-fluid-->
                            </div><!--end: .dropdown-menu-inner-->
                        </div><!--end: .dropdown-menu.level1-->
                <?php }//end: if($item->is_html) ?>
        <?php } else{ ?>
            <li>
                <a href="<?php echo $link?>" class="dropdown-toggle" title="<?php echo htmlspecialchars($item->name)?>">
                    <span class="menu-title"><?php echo $item->name; ?></span>
                </a>
        <?php }//end: if($item->children) ?>
            </li>
    <?php }//end: foreach($list as $item) ?>
</ul>