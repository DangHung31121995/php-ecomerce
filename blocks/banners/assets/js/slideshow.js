$(document).ready(function() {
    $('.block-banner-slideshow ul').carouFredSel({
		auto:{
            play :true,
            pauseDuration   : 5000
		},
        scroll: 1,
        items: {
			width: 942,
            height: 321
        },
        prev        : ".block-caroufredsel-prev",
        next        : ".block-caroufredsel-next"
	});
});