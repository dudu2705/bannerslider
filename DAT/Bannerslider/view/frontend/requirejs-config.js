var config = {
	map: {
		'*': {
			'DAT/note': 'DAT_Bannerslider/js/jquery/slider/jquery-ads-note',
			'DAT/impress': 'DAT_Bannerslider/js/report/impress',
			'DAT/clickbanner': 'DAT_Bannerslider/js/report/clickbanner',
		},
	},
	paths: {
		'DAT/flexslider': 'DAT_Bannerslider/js/jquery/slider/jquery-flexslider-min',
		'DAT/evolutionslider': 'DAT_Bannerslider/js/jquery/slider/jquery-slider-min',
		'DAT/popup': 'DAT_Bannerslider/js/jquery.bpopup.min',
	},
	shim: {
		'DAT/flexslider': {
			deps: ['jquery']
		},
		'DAT/evolutionslider': {
			deps: ['jquery']
		},
		'DAT/zebra-tooltips': {
			deps: ['jquery']
		},
	}
};
