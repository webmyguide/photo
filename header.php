<?php
	global $int_post_id;
	global $int_setting_ids;
	global $setting_common;
	global $setting_page;

	//ヘッダーのclass
	$class_header = '';
	if( is_home() || is_front_page() ) {
		$class_header = 'header-top';
	}

	$nav_url = array();
	if( is_home() || is_front_page() ) {
		$nav_url = array(
			'plan' => '#top_plan',
			'gallarey' => '#top_gallarey',
			'costume' => esc_url(get_post_type_archive_link( 'costume-list' )),
			'access' => esc_url(home_url( '/company/' )),
		);
	}else {
		$nav_url = array(
			'plan' => esc_url(home_url( '/#top_plan' )),
			'gallarey' => esc_url(home_url( '/#top_gallarey' )),
			'costume' => esc_url(get_post_type_archive_link( 'costume-list' )),
			'access' => esc_url(home_url( '/company/' )),
		);
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">

	<?php wp_head();?>
	<meta name="description" content="<?php echo get_meta_description(); ?>" />
	<?php
		$robots = get_meta_robots();
		if(!empty($robots)){
	?>
		<meta name="robots" content="<?php echo $robots; ?>">
	<?php } ?>

  	<link rel="apple-touch-icon" href="icon.png">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">


<!-- Google Tag Manager -->
<?php
	global $int_post_id;

	$gtm_id =  get_post_meta($int_post_id,'common_gtm',true);
?>
<?php if(!empty($gtm_id)){ ?>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo $gtm_id;?>');</script>
	<!-- End Google Tag Manager -->
<?php } ?>


	<?php get_template_part('ogp'); ?>
</head>
<body>

	<!-- IE9未満への注意文 -->
	<!--[if lte IE 9]>
			<p class="browserAlert">IE9未満用のメッセージ</p>
	<![endif]-->

<?php if(!empty($gtm_id)){ ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src=""https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_id;?>""
	height=""0"" width=""0"" style=""display:none;visibility:hidden""></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php } ?>

<header class="header <?php echo $class_header;?>" id="pageHeader">
	<nav class="navHeader">
		<?php
			$non_nav = false;
			$req_url = $_SERVER["REQUEST_URI"];
			if( (strpos($req_url, 'reserve/error/') !== false ) || (strpos($req_url, 'reserve/confirm/') !== false ) || (strpos($req_url, 'reserve/thanks/') !== false) ){
				$non_nav = true;
			}
		 ?>
		<div class="navHeader__box boxNav" id="targetMenu" <?php if(!empty($non_nav)){ ?>style="display:none;"<?php } ?>>
			<div class="boxNav__close btnMenu" id="offMenu">
				<img src="<?php echo get_template_directory_uri(); ?>/images/btn_menuClose_01.svg" alt="メニュークローズ" width="100" height="100" class="img-r verAlign-b" />
			</div>
			<a href="<?php echo esc_url(home_url( '/' )); ?>" class="boxNav__home">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo_common_01.png" alt="<?php bloginfo('title'); ?>" width="530" height="247" class="img-r verAlign-b" />
			</a>
			<h2 class="boxNav__tit titCommon">MENU</h2>
			<ul class="navHeader__list listNav">
				<li class="listNav__items">
					<a href="<?php echo esc_url(home_url( '/' )); ?>" class="listNav__link">TOP</a>
				</li>
				<li class="listNav__items listNav__items-plan">
					<a href="<?php echo $nav_url['plan']; ?>" class="listNav__link listNav__link-archive">撮影プラン</a>
					<ul class="listNav__subNav listSubNav">
						<?php
							$post_plan = get_post_plan();
						 ?>
						<?php foreach ($post_plan as $plan_key => $plan_value) { ?>
							<?php
								$name_plan = str_replace('<br>', '',$plan_value->post_title);
								$is_detail_page = get_post_meta($plan_value->ID,'plan_is_detail',true);
							 ?>
						 	<?php if (!empty($is_detail_page)) { ?>
								<li class="listSubNav__items">
									<a href="<?php echo get_permalink( $plan_value->ID );?>" class="listNav__link"><?php echo $name_plan;?></a>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				</li>
				<li class="listNav__items">
					<a href="<?php echo $nav_url['gallarey']; ?>" class="listNav__link">ギャラリー</a>
				</li>
				<li class="listNav__items">
					<a href="<?php echo $nav_url['costume']; ?>" class="listNav__link">衣装・小物</a>
				</li>


				<li class="listNav__items">
					<a href="<?php echo $nav_url['access']; ?>" class="listNav__link">会社概要・アクセス</a>
				</li>
				<li class="listNav__items listNav__items-contact">
					<a href="<?php echo get_link_page('reserve'); ?>" class="listNav__link-contact">お問い合わせ/撮影予約</a>
				</li>
			</ul>
			<div class="boxNav__sns">
				FOLLOW US<br>
				<a href="https://www.instagram.com/<?php echo $setting_common['common_instagram'];?>/" target="_blank"  class="boxNav__icoSns img-r verAlign-m"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_instagram_01.svg" alt="instagram" width="19" height="19" class="listContact__icoSns img-r verAlign-m"/></a>
				<a href="https://lin.ee/<?php echo $setting_common['common_line'];?>" target="_blank"  class="boxNav__icoSns img-r verAlign-m"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_line_01.svg" alt="LINE" width="20" height="17" class="listContact__icoSns img-r verAlign-m"/></a>
			</div>
		</div>


		<div class="navHeader__navfixed navfixed">
			<div class="navfixed__wrap">
				<a href="<?php echo esc_url(home_url( '/' )); ?>" class="navfixed__logo">
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo_common_02.png" alt="<?php bloginfo('title'); ?>" width="530" height="247" class="img-r verAlign-b" />
				</a>
				<a href="<?php echo get_link_page('reserve'); ?>" class="navfixed__contact">撮影予約<div>Reserve</div></a>
			</div>
		</div>
		<div class="navHeader__menu btnMenu" id="onMenu">
			<img src="<?php echo get_template_directory_uri(); ?>/images/btn_menuOpen_01.svg" alt="メニューオープン" width="100" height="100" class="img-r verAlign-b" />
		</div>
	</nav>

	<?php if( !(is_home() || is_front_page()) ) { ?>
		<?php $post_type = $post->post_type; ?>
		<div class="header__breadcrumb breadcrumb">
			<ul class="breadcrumb__list">
				<li class="breadcrumb__item">
					<a href="<?php echo esc_url(home_url( '/' )); ?>" class="breadcrumb__link">TOP</a>
				</li>
				<?php if( in_array($post->ID, array($int_setting_ids['contact'],$int_setting_ids['contact_confirm'],$int_setting_ids['contact_thanks'],$int_setting_ids['contact_error'])) ) { ?>
					<?php
						$post_contact = get_post($int_setting_ids['contact']);
					 ?>
					 <li class="breadcrumb__item">
						<a href="<?php echo get_permalink( $post_contact->ID );?>" class="breadcrumb__link"><?php echo $post_contact->post_title;?></a>
					</li>

				<?php }elseif ( in_array($post->ID, array($int_setting_ids['reserve'],$int_setting_ids['reserve_confirm'],$int_setting_ids['reserve_thanks'],$int_setting_ids['reserve_error'])) ){ ?>
					<?php
						$post_contact = get_post($int_setting_ids['reserve']);
					 ?>
					<li class="breadcrumb__item">
						<a href="<?php echo get_permalink( $post_contact->ID );?>" class="breadcrumb__link"><?php echo $post_contact->post_title;?></a>
					</li>
				<?php }elseif ( $post_type == 'plan' && is_single() ) { ?>
					<?php
						$title_plan = str_replace('<br>', '',$post->post_title);
					 ?>
					<li class="breadcrumb__item">
						<a href="<?php echo get_permalink( $post->ID );?>" class="breadcrumb__link"><?php echo $title_plan;?></a>
					</li>
				<?php }elseif ( is_page() ) { ?>
					<li class="breadcrumb__item">
						<a href="<?php echo get_permalink( $post->ID );?>" class="breadcrumb__link"><?php echo $post->post_title;?></a>
					</li>
				<?php }elseif ( $post_type == 'post' && is_archive() ) { ?>
					<li class="breadcrumb__item">
						<a href="<?php echo home_url('/blogs/'); ?>" class="breadcrumb__link">ブログ一覧</a>
					</li>
				<?php }elseif ( $post_type == 'costume-list' && is_archive() ) { ?>
					<li class="breadcrumb__item">
						<a href="<?php echo get_post_type_archive_link( 'costume-list' ); ?>" class="breadcrumb__link"><?php echo post_type_archive_title( '', false );?></a>
					</li>
				<?php }elseif ( $post_type == 'post' && is_single() ) { ?>
					<li class="breadcrumb__item">
						<a href="<?php echo home_url('/blogs/'); ?>" class="breadcrumb__link">ブログ一覧</a>
					</li>
					<li class="breadcrumb__item">
						<a href="<?php echo get_permalink( $post->ID );?>" class="breadcrumb__link"><?php echo $post->post_title;?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>


	<?php
		$class_logo = 'div';
		if( is_home() || is_front_page() ) {
			$class_logo = 'h1';
		}
	?>

	<<?php echo $class_logo; ?> class="header__logo">
		<a href="<?php echo esc_url(home_url( '/' )); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo_common_01.png" alt="<?php bloginfo('title'); ?>" width="530" height="247" class="img-r verAlign-b" />
		</a>
	</<?php echo $class_logo; ?>>

	<?php
		//headerCatchのデータ取得
		$data_catch = get_header_catch();
	?>
	<?php if(!empty($data_catch)){ ?>
		<div class="header__title headerCatch">
			<?php if(!empty($data_catch['page_text'])){ ?><h1 class="headerCatch__page"><?php echo $data_catch['page_text']; ?></h1><?php } ?>
			<?php if(!empty($data_catch['page_text_en'])){ ?><p class="headerCatch__page-en"><?php echo $data_catch['page_text_en']; ?></p><?php } ?>
			<?php if(!empty($data_catch['tit_tag'])){ ?><<?php echo $data_catch['tit_tag']; ?> class="<?php echo $data_catch['tit_class']; ?>"><?php echo $data_catch['tit_text']; ?></<?php echo $data_catch['tit_tag']; ?>><?php } ?>
			<?php if(!empty($data_catch['catch_text'])){ ?><p class="headerCatch__emp"><?php echo $data_catch['catch_text']; ?></p><?php } ?>
			<?php if(!empty($data_catch['catch_text_en'])){ ?><p class="headerCatch__en"><?php echo $data_catch['catch_text_en']; ?></p><?php } ?>
			<?php if(!empty($data_catch['catch_detail'])){ ?><div class="headerCatch__detail <?php echo $data_catch['detail_class']; ?>"><?php echo apply_filters('the_content',$data_catch['catch_detail']); ?></div><?php } ?>
			<?php if(!empty($data_catch['btn_class'])){ ?>
				<a href="<?php echo $data_catch['btn_url']; ?>" class="headerCatch__btn <?php echo $data_catch['btn_class']; ?>">
					<?php if(!empty($data_catch['is_deco_btn'])){ ?><div class="ani-deco-btn"></div><?php } ?>
					<?php echo $data_catch['btn_text']; ?>
				</a>
			<?php } ?>
		</div>
	<?php } ?>

</header>
