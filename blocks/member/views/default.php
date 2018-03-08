<?php 
global $tmpl; 
$tmpl->addStylesheet($style, 'blocks/member/assets/css');
$Itemid = 10;
$redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<?php if(!isset($_SESSION['username'])){?>
    <div class="block-member block-member-<?php echo $style; ?>">
        <a class="a24h" href="<?php echo FSRoute::_('index.php?module=users&task=register&Itemid='.$Itemid);?>" title="Đăng ký"><?php echo FSText::_('Đăng ký')?></a>      
        <a class="a24h" href="<?php echo FSRoute::_('index.php?module=users&task=login&Itemid='.$Itemid.'&redirect='.base64_encode($redirect));?>" title="Đăng nhập"><?php echo FSText::_('Đăng nhập')?></a>
    </div>
<?php }else{ ?>
    <div class="block-member block-member-<?php echo $style; ?>">
        <span><?php echo FSText::_('Chào')?></span> <a class="df bold" href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logged&Itemid='.$Itemid);?>" title="<?php echo $_SESSION['fullname']; ?>"><?php echo $_SESSION['fullname']; ?></a>      
        <a class="df" href="<?php echo FSRoute::_('index.php?module=users&task=logout&Itemid='.$Itemid);?>" title="Thoát">(<?php echo FSText::_('Thoát')?>)</a>
    </div>
<?php } ?>