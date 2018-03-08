<?php 
global $tmpl;
$tmpl->addStylesheet($style, 'blocks/newsletter/assets/css');
$tmpl->addScript($style, 'blocks/newsletter/assets/js');
?>
<div class="block-newsletter">
    <form method="post" id="frmNewsletter" name="frmNewsletter" onsubmit="return validNewsletter();">
        <input id="newsletter" name="newsletter" class="fl" type="text" type="text" onblur="if(this.value=='') this.value='Đăng ký nhận bản tin'" onfocus="if(this.value=='Đăng ký nhận bản tin') this.value=''" value="Đăng ký nhận bản tin" />
        <a href="javascript:void(0);" onclick="$('#frmNewsletter').submit();" title="Gửi đi">Gửi đi</a>
    </form>
</div><!--end: .block-newsletter-->