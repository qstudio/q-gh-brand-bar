/*
 * $ Calls v0.9 ##
 * (c) 2012 Q Studio - qstudio.us
 */

// jQuery ##
if ( typeof jQuery !== 'undefined' ) {

    (function ($) {

		// clone body class ##
		if ( $('body').hasClass( 'browsers-mobile' ) ) {
			// console.log( 'adding class..' );
			$('body').addClass("device-mobile");
		} 

		$('.device-mobile .brand-bar .wrapper-inner .greenheart a').click(function(e){
			e.preventDefault();
			var popup = $('.device-mobile .brand-bar .branches-open');
			var popupHeight = popup.height() + 200;
			popup.css({
				'min-height': window.innerHeight - adminBarHeight() + 'px',
				'margin-top': adminBarHeight() + 'px'
			}).show();
			$('html').addClass('popup-open');
			$('body').height(popupHeight - adminBarHeight() - 30);
			$('.branches-close').click(function(){
				popup.hide();
				$('html').removeClass('popup-open');
			});
		});

		function adminBarHeight() {
			return ($('body').hasClass('admin-bar')) ? $('#wpadminbar').height() : 0;
		}

		jQuery(window).on("load",function(e){
			$('.brand-bar').show();
		});

    })(jQuery);

}
