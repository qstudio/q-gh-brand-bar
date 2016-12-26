/*
 * $ Calls v0.9 ##
 * (c) 2012 Q Studio - qstudio.us
 */

// jQuery ##
if ( typeof jQuery !== 'undefined' ) {

    (function ($) {

		// clone body classes ##
		if ( $('body').hasClass( 'browsers-mobile' ) ) {
			// console.log( 'adding class..' );
			$('body').addClass("device-mobile");
		}
		if ( $('body').hasClass( 'browsers-desktop' ) ) {
			$('body').addClass("device-desktop");
		}

		if ( $('body').hasClass('install-greenheart-transforms') ) {
			$('body').addClass('device-desktop');
			$('body').removeClass('device-mobile');
		}

		$(document).on('click', '.device-mobile .brand-bar .wrapper-inner .greenheart a', function(e){
			e.preventDefault();
			var popup = $('.device-mobile .brand-bar .branches-open');
			var popupHeight = popup.height() + 200;
			popup.css('min-height', window.innerHeight - getAdminBarHeight() + 'px');
			if ($('body').hasClass('install-cci-greenheart')) {
				popup.css('margin-top', getAdminBarHeight() + 'px');
			}
			popup.show();
			$('html').addClass('popup-open');
			$('body').height(popupHeight - getAdminBarHeight() - 30);
			$('.branches-close').click(function(){
				popup.hide();
				$('html').removeClass('popup-open');
			});
		});

		$(window).on("load resize", function(e){

			if ( $('body').hasClass('install-greenheart-international') ) {
				var windowWidth = window.innerWidth;
				if (windowWidth > 640) {
					$('body').addClass('device-desktop');
					$('body').removeClass('device-mobile');
				} else {
					$('body').addClass('device-mobile');
					$('body').removeClass('device-desktop');
				}
			}
		});

		$(window).on('load scroll', function(){

			if ($('body').hasClass('install-greenheart-international')) {
	        	var fromTop = $(window).scrollTop();
	        	var adminBarHeight = getAdminBarHeight();
				var headerFromTop = 0;
	            if (fromTop < 30 + adminBarHeight)
	            	headerFromTop += 30 + adminBarHeight - fromTop;
				$('.device-mobile #header_wrapper_outer').css('top', headerFromTop + 'px');
			}
		});

		function getAdminBarHeight() {
			return ($('body').hasClass('admin-bar')) ? $('#wpadminbar').height() : 0;
		}

    })(jQuery);

}
