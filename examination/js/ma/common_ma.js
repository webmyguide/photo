// smooth scroll
(function ($) {
	$('a[href^="#"]').click(function() {
		var speed = 650;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});

// 「今すぐエントリー」ボタン制御
	$( window ).on( 'load resize', function() {
		wW = window.innerWidth;
		if ( wW > 1149 ) {
			$( 'body' ).find( '.anchor' ).css( 'display', 'none' );
			$( window ).off( 'scroll' );
		} else {
			$( 'body' ).find( '.anchor' ).fadeIn( 'fast' );
			$( window ).on( 'scroll', function() {
				if ( $( window ).scrollTop() < 8000 ) {
					$( 'body' ).find( '.anchor' ).fadeIn( 'fast' );
				} else {
					$( 'body' ).find( '.anchor' ).fadeOut( 'fast' );
				}
			});
		}
	});

// form check ※暫定
	$( '#tp_agree_privacy' ).on( 'click', function() {
		if ($('#tp_agree_privacy').is(':checked')) {
			$("#tp_submit").prop('disabled', false);
		} else {
			$("#tp_submit").prop('disabled', true);
		}
	});
	$( '#btm_agree_privacy' ).on( 'click', function() {
		if ( $('#btm_agree_privacy').is(':checked')) {
			$("#btm_submit").prop('disabled', false);
		} else {
			$("#btm_submit").prop('disabled', true);
		}
	});
})(jQuery);
