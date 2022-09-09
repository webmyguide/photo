<?php
    global $setting_common;
    global $enable_blog;
    $nav_url = array();

    if( is_home() || is_front_page() ) {
		$nav_url = array(
			'plan' => '#top_plan',
			'gallarey' => '#top_gallarey',
		);
	}else {
		$nav_url = array(
			'plan' => esc_url(home_url( '/#top_plan' )),
			'gallarey' => esc_url(home_url( '/#top_gallarey' )),
		);
	}

?>


<footer class="footer">
	<a href="#pageHeader" class="footer__pagetop"><img src="<?php echo get_template_directory_uri(); ?>/images/btn_pagetop_01.svg" width="52" height="52" alt="pagetop" class="img-r verAlign-b"></a>
	<div class="footer__wrap">
        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="footer__logo">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo_common_01.png" alt="<?php bloginfo('title'); ?>" width="530" height="247" class="img-r verAlign-b" />
		</a>
		<div class="footer__info">
			<p>
				<span class="footer__emphasis"><?php echo $setting_common['common_conpany_name'];?></span><br>
				〒<?php echo $setting_common['common_postal_code'];?>&nbsp;<?php echo $setting_common['common_street_address'];?><br>
			</p>
			<p>
				受付時間&nbsp;<?php echo $setting_common['common_reception_time_1'];?>〜<?php echo $setting_common['common_reception_time_2'];?>&nbsp;/&nbsp;定休日&nbsp;<?php echo $setting_common['common_regular_holiday'];?><br>
				<?php if(!empty($setting_common['common_phone_number'])){ ?><span class="footer__emphasis">TEL&nbsp;<?php echo $setting_common['common_phone_number'];?></span><?php } ?>
			</p>
		</div>

        <nav class="footer__nav">
    		<ul class="navFooter">
    			<li class="navFooter__items"><a href="<?php echo esc_url( get_home_url('/') ); ?>" class="navFooter__link">ホーム</a></li>
                <li class="navFooter__items"><a href="<?php echo $nav_url['plan']; ?>" class="navFooter__link">撮影プラン</a></li>
                <li class="navFooter__items"><a href="<?php echo $nav_url['gallarey']; ?>" class="navFooter__link">ギャラリー</a></li>
                <li class="navFooter__items"><a href="<?php echo esc_url(get_post_type_archive_link( 'costume-list' ));?>" class="navFooter__link">衣装・小物</a></li>
                <li class="navFooter__items"><a href="<?php echo esc_url(home_url( '/company/' ));?>" class="navFooter__link">会社概要・アクセス</a></li>
    			<?php if(!empty($enable_blog)){ ?><li class="navFooter__items"><a href="<?php echo esc_url(home_url('/blogs/'));?>" class="navFooter__link">ブログ</a></li><?php } ?>
    		</ul>
        </nav>

		<p class="footer__copyright">Copyright (C) <?php echo $setting_common['common_site_name'];?>. All Rights Reserved</p>
	</div>
</footer><!-- /.footer -->

<?php wp_footer();?>
<script>
    var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    var img_url = '<?php echo get_template_directory_uri(); ?>/images/';
    const images = document.querySelectorAll('img[loading="lazy"],iframe[loading="lazy"]');

    if (images) {
        if ('loading' in HTMLImageElement.prototype) {
            images.forEach(img => {
                if (img.dataset.src) img.src = img.dataset.src;
                if (img.dataset.srcset) img.srcset = img.dataset.srcset;
                if (img.dataset.sizes) img.sizes = img.dataset.sizes;
                if (img.parentElement.tagName == 'PICTURE') {
                    const sources = img.parentElement.querySelectorAll('source[data-srcset]');
                    if (sources) {
                        sources.forEach(source => {
                            source.srcset = source.dataset.srcset;
                        });
                    }
                }
            });
        } else {
            images.forEach(img => {
                img.classList.add('lazyload');
            });
            let script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/lazysizes@5.2.0/lazysizes.min.js';
            document.body.appendChild(script);
        }
    }
</script>







</body>
</html>
