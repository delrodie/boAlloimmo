$(function () {
	$('head').append('<link rel="stylesheet" href="css/style-0.css" rel="stylesheet">');
	$('.js-colorswatch').on('click',function (e){
		$('.colorswatch').toggleClass('opened');
	})
	$('.js-swatch-color').on('click',function (e){
		var color = $(this).attr('data-color');
		if(color != undefined){
			$('link[href*="css/style-"]').attr('href','css/style-'+color+'.css');
			$('.header-logo img').attr('src','images/logo-color-'+color+'.png');
		} else {
			$('link[href*="css/style-"]').attr('href','css/style-0.css');
			$('.header-logo img').attr('src','images/logo.png');
		}
		$('.js-swatch-color').removeClass('active');
		$(this).toggleClass('active');
		e.preventDefault();
	});

})