var MEETS = function ($) {
	// 初期化
	var _init = function _init() {
		$(function () {
			_viewport.handle();
			_preload.handle();
			_spimage.handle();
			_accordion.handle();
			_scroller.handle();
			_slider.handle();
			_via.handle();
			_efo.handle();
		});
	};

	//viewport
	var _viewport = {
		handle: function handle() {
        	var content = 'width=1100,user-scalable=no';
        	if ( ( navigator.userAgent.indexOf( 'iPhone' ) > 0)
        	    || navigator.userAgent.indexOf( 'iPod' ) > 0
        	    || navigator.userAgent.indexOf( 'Android' ) > 0) {
        		content = 'width=device-width,user-scalable=no';
        	}
        	$( 'meta[name=\'viewport\']' ).attr( 'content', content );
		}
	};

	//スライダー
	var _slider = {
		handle: function handle() {
			$( '.section5__humans' ).slick({
				infinite: true,
				autoplay: true,
				speed: 300,
				slidesToShow: 1,
				centerMode: true,
				variableWidth: true,
				prevArrow: '<button type="button" class="section5__prev"></button>',
				nextArrow: '<button type="button" class="section5__next"></button>'
			});
		}
	};

	//画像のプリロード
	var _preload = {
		handle: function handle() {
			var self = this;
			$( 'img[src *= \'_off\']' ).each(function() {
				var imgSrc = $( this ).attr( 'src' );
				self.getImage( imgSrc );
				if ( $( this ).hasClass( 'js--sp' ) ) {
					imgSrc = imgSrc.replace( '/images/', '/images/sp/' );
					self.getImage( imgSrc );
				}
			});
		},
		getImage: function getImage( imgSrc ) {
			$( '<img>' ).attr( 'src', imgSrc );
		}
	};

	//スムーズスクロール
	var _scroller = {
		handle: function handle() {
			$( 'a[href^="#"]' ).on( 'click', function () {
				var speed = 400;
				var href = $( this ).attr( 'href' );
				var target = $(href == '#' || href == '' ? 'html' : href);
				var position = target.offset().top;
				$( 'body, html' ).animate( { scrollTop: position }, speed );
				return false;
			});
		}
	};

	//スマホの場合の画像切り替え
	var _spimage = {
		handle: function handle() {
			$( window ).on( 'resize', function() {
				$( '.js--sp' ).each(function() {
					var windowWidth = window.innerWidth;
					var src = $( this ).attr( 'src' );
					if( windowWidth >= 767)
						src = src.replace( 'images/sp/', 'images/' );
					if( windowWidth <  767 && src.indexOf( '/sp/' ) == -1)
						src = src.replace( 'images/', 'images/sp/' );
					$( this ).attr( 'src', src );
				});
			}).trigger( 'resize' );
		}
	};

	//利用規約
	var _accordion = {
		handle: function handle() {
			$( '.accordion' ).on( 'click', '.accordion__heading', function () {
				$(this).toggleClass( 'is-open' ).next().stop().slideToggle({
					duration: 400
				});
				return false;
			});
		}
	};

    //経路情報
    var _via = {
        handle: function handle() {
			var parameter = new Object;
			var date = '';
			url = location.search.substring(1).split('&');
			for ( i = 0; url[i]; i++ ) {
		    	var k = url[i].split('=');
				parameter[k[0]] = k[1];
		    }
 			date = parameter.date;
            var formClass = [ '.header__mv__form', '.sectionForm' ];
            $.each(formClass, function(key, value) {
                var trLastChild = value + ' tbody tr:last-child';
                var trLastChild2 = value + ' tbody tr:nth-last-of-type(2)';
                var tableHeader = $( trLastChild + ' th div' ).text();
                var tableHeader2 = $( trLastChild2 + ' th div' ).text();
                var inputName = $( trLastChild + ' td div input' ).attr( 'name' );
                var inputName2 = $( trLastChild2 + ' td div input' ).attr( 'name' );
                if( '経路情報' === tableHeader ) {
                    $( trLastChild ).css( 'display', 'none' );
                    $( 'input[type=\'text\'][name=\'' + inputName + '\']' ).attr( 'value', '' );
                }
                if( '面談希望日' === tableHeader2 ) {
                    var checkboxes = $( 'input[type=\'checkbox\'][name=\'' + inputName2 + '\']' );
                    if ( undefined !== date && 4 === date.length ) {
	                    var month = date.substring( 0, 2 );
	                    var day = date.substring( 2, 4 );
	                    if ( '0' === month.substring( 0, 1 ) ) {
		                    month = month.substring( 1, 2 );
	                    }
	                    if ( '0' === day.substring( 0, 1 ) ) {
		                    day = day.substring( 1, 2 );
	                    }
	                    var monthDayString = month + '月' + day + '日';
	                    checkboxes.each( function() {
		                    var dateString = $( this ).val();
		                    if ( 0 === dateString.indexOf( monthDayString ) ) {
			                    $( this ).prop( 'checked', true );
		                    }
	                    } );
                    }
                    $( trLastChild2 ).css( 'display', 'none' );
                }
            });
		}
	};

	//EFO
    var _efo = {
        handle: function handle() {
            //type
            $( '.contact-form-input input[name=element-2]' ).attr( 'type', 'tel' );
            $( '.contact-form-input input[name=element-3]' ).attr( 'type', 'tel' );

            //autocomplete
            $( '.contact-form-input input[name=element-0]' ).attr( 'autocomplete', 'name' );
            $( '.contact-form-input input[name=element-12]' ).attr( 'autocomplete', 'name' );
            $( '.contact-form-input input[name=element-1]' ).attr( 'autocomplete', 'email' );
            $( '.contact-form-input input[name=element-2]' ).attr( 'autocomplete', 'tel' );
            $( '.contact-form-input input[name=element-3]' ).attr( 'autocomplete', 'bday' );

            //inputmode
            $( '.contact-form-input input[name=element-0]' ).attr( 'inputmode', 'kana-name' );
            $( '.contact-form-input input[name=element-12]' ).attr( 'inputmode', 'kana-name' );

            var formClass = [ '.header__mv__form', '.sectionForm' ];
            $.each(formClass, function(key, value) {
            	$( value + ' form' ).validationEngine( { promptPosition: 'topLeft' } );
            });
		}
	};

	return {
		init: function init() {
			window.console = window.console || {
				log: function log() {}
			};
			_init();
		}
	};
}( jQuery );
MEETS.init();
