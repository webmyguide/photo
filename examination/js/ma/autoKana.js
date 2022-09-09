(function ($) {
	$.fn.autoKana('.header__mv__form input[name="element-0"]', '.header__mv__form input[name="element-12"]', {
		katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
	$.fn.autoKana('#sectionForm input[name="element-0"]', '#sectionForm input[name="element-12"]', {
		katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
	});
})(jQuery);
