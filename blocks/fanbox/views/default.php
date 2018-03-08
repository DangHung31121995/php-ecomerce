<div id="block-<?php echo $blockId ?>" class="share-face">
    <a href="" title="" class="tl-share-face">Facebook</a>
    <div class="cont-share-face">
        <div id="fb-root"></div>
        <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=162891027218791";
            fjs.parentNode.insertBefore(js, fjs);
        }
        (document, 'script', 'facebook-jssdk'));
        </script>
        <div class="fb-like-box" data-href="<?php echo $link;?>" data-width="278" data-height="281" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
    </div>
</div><!-- .share-face-->