<?php

//--------------------------------------------------------------------------------------------------
// メインビュジュアル
//--------------------------------------------------------------------------------------------------

function vie_main_visual(){
    global $int_post_id;
	global $int_setting_ids;
    global $setting_common;
	global $setting_page;

	$is_section = true;
	$is_mv = false;
    $margin_bottom = '';

    //コンテンツのメイン画像の取得
    $main_thumbs = get_img_main();
    if(!empty($main_thumbs[0])) $margin_bottom = 'contentMv-mb';;

	//メインビュジュアルの取得
	if(is_front_page() || is_home()){
        $img_post_id = $int_setting_ids['top'];
	}else {
		$img_post_id = $post->ID;
	}
    $mv_thums = get_img_mv($img_post_id);


    //FOLLOW US/撮影予約・お問い合わせの処理
	if(is_front_page() || is_home()){
		$is_contact_fixed_sp = true;
	}else {
		$is_contact_fixed_sp = false;
	}

?>

    <?php if($is_section){ ?>
    	<div class="contentMv <?php echo $margin_bottom; ?>">
            <div class="contentMv__side" id="targetMv" data-mv-id="<?php echo $img_post_id;?>">
                <div class="contentMv__loader loader">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
            </div>

    		<?php if( !empty($main_thumbs[0]) ){ ?>
    			<figure class="contentMv__figure-top">
    				<img src="<?php echo $main_thumbs[0][0]; ?>" alt="<?php echo $main_thumbs[0][3]; ?>" width="<?php echo $main_thumbs[0][1]; ?>" height="<?php echo $main_thumbs[0][2]; ?>" class="contentMv__figureImg verAlign-b msimg"/>
    			</figure>
    		<?php } ?>

    		<div class="contentMv__contact <?php if($is_contact_fixed_sp){ ?>contentMv__contact-nf<?php } ?>" <?php if($is_contact_fixed_sp){ ?>id="contact_fixed"<?php } ?>>
    			<ul class="listContact">
    				<li class="listContact__itams listContact__itams-sns">
                        <a href="https://www.instagram.com/<?php echo $setting_common['common_instagram'];?>/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_instagram_01.svg" alt="instagram" width="19" height="19" class="listContact__icoSns img-r verAlign-m"/></a>
    					<a href="https://lin.ee/<?php echo $setting_common['common_line'];?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_line_01.svg" alt="LINE" width="20" height="17" class="listContact__icoSns img-r verAlign-m"/></a>
    				</li>
    				<li class="listContact__itams listContact__itams-contact">
                        <a href="<?php echo get_link_page('reserve'); ?>" class="listContact__link">撮影予約・お問い合わせ</a>
    				</li>
    			</ul>
    		</div>

    		<?php if( !empty($main_thumbs[1]) || !empty($main_thumbs[2]) ){ ?>
    			<figure class="contentMv__figure-left">
    				<img src="<?php echo $main_thumbs[1][0]; ?>" alt="<?php echo $main_thumbs[1][3]; ?>" width="<?php echo $main_thumbs[1][1]; ?>" height="<?php echo $main_thumbs[1][2]; ?>" class="contentMv__figureImg contentMv__figureImg-bottom verAlign-b msimg"/>
    			</figure>
    			<figure class="contentMv__figure-right">
    				<img src="<?php echo $main_thumbs[2][0]; ?>" alt="<?php echo $main_thumbs[2][3]; ?>" width="<?php echo $main_thumbs[2][1]; ?>" height="<?php echo $main_thumbs[2][2]; ?>" class="contentMv__figureImg contentMv__figureImg-bottom verAlign-b msimg"/>
    			</figure>
    		<?php } ?>
    	</div>
    <?php } ?>


<?php } ?>
