<?php
    global $setting_common;


	$is_section = true;
	$is_mv = false;


	//TOPページの場合
	if(is_front_page() || is_home()){
		$is_section = true;
	}

	// //パンクズ
	// if( !(is_front_page() || is_home()) ){
	// 	$is_breadcrumb = true;
	// }

	//カスタムフィールドでmvを指定している場合
	$thumb_path_pc = get_post_field('cf_mv_pc',$post->ID);
	$thumb_path_sp = get_post_field('cf_mv_sp',$post->ID);
	if($thumb_path_pc || $thumb_path_sp){
		$is_section = true;
		$is_mv = true;
		$thumb_pc = wp_get_attachment_image_src($thumb_path_pc,'full');
		$thumb_sp = wp_get_attachment_image_src($thumb_path_sp,'full');
	}


	global $template; // テンプレートファイルのパスを取得
    $temp_name = basename($template); // パスの最後の名前（ファイル名）を取得
    if($temp_name == 'page-index.php') {
		$is_section = true;
	}
	var_dump($setting_common['mv_img']);
	var_dump('aaaaaaaaaa');
?>

<?php if($is_section){ ?>
	<div class="contentMv">
		<?php if(is_front_page() || is_home()){ ?>
			<div class="contentMv__side" id="targetMv">
				<figure class="contentMv__figure-main">
					<img src="<?php echo get_template_directory_uri(); ?>/images/mv_top_main_01.jpg" alt="<?php bloginfo('title'); ?>" width="1318" height="2160" class="contentMv__sideimg verAlign-b"/>
				</figure>
			</div>
			<figure class="contentMv__figure-top">
				<img src="<?php echo get_template_directory_uri(); ?>/images/mv_top_01.jpg" alt="<?php bloginfo('title'); ?>" width="788" height="448" class="contentMv__figureImg verAlign-b"/>
			</figure>
			<article class="contentMv__contact">
				<ul class="listContact">
					<li class="listContact__itams">
						FOLLOW US
						<img src="<?php echo get_template_directory_uri(); ?>/images/ico_twitter_01.svg" alt="<?php bloginfo('title'); ?>" alt="twitter" width="20" height="17" class="listContact__icoSns img-r verAlign-m"/>
						<img src="<?php echo get_template_directory_uri(); ?>/images/ico_instagram_01.svg" alt="<?php bloginfo('title'); ?>" alt="instagram" width="19" height="19" class="listContact__icoSns img-r verAlign-m"/>
					</li>
					<li class="listContact__itams">
						<a href="#" class="listContact__link">撮影予約・お問い合わせ</a>
					</li>
				</ul>
			</article>

			<figure class="contentMv__figure-left">
				<img src="<?php echo get_template_directory_uri(); ?>/images/mv_top_02.png" alt="<?php bloginfo('title'); ?>" width="394" height="224" class="contentMv__figureImg contentMv__figureImg-bottom img-r verAlign-b"/>
			</figure>
			<figure class="contentMv__figure-right">
				<img src="<?php echo get_template_directory_uri(); ?>/images/mv_top_03.png" alt="<?php bloginfo('title'); ?>" width="394" height="224" class="contentMv__figureImg contentMv__figureImg-bottom img-r verAlign-b"/>
			</figure>


		<?php }else if($is_mv){ ?>
			<img src="<?php echo $thumb_pc[0]; ?>" alt="<?php echo $thumb_pc[3]; ?>" width="<?php echo $thumb_pc[1]; ?>" height="<?php echo $thumb_pc[2]; ?>" class="img-r img-pc"/>
			<img src="<?php echo $thumb_sp[0]; ?>" alt="<?php echo $thumb_sp[3]; ?>" width="<?php echo $thumb_sp[1]; ?>" height="<?php echo $thumb_sp[2]; ?>" class="img-r img-sp"/>
		<?php } ?>

	</div>
<?php } ?>
