<?php

//--------------------------------------------------------------------------------------------------
// 案件情報
//--------------------------------------------------------------------------------------------------
function view_product($product = null,$setting = null) {

    //コンテンツの有無
    //int
    $is_title_out = false;
    $is_title_sp_out = true;
    $is_title_in = true;
    $is_balloon_out = false;
    $is_balloon_in = true;
    $is_catch_title_in = true;
    $is_data_text = false;
    $is_detail = false;
    $is_action = false;
    $is_wordMouth = true;
    $reputation_type = '';
    $ranking_num = false;
    $is_reputation_col = false;
    //詳細ページ
    if ( isset($setting['page_detail']) ) {
        $is_title_out = true;
        $is_title_sp_out = false;
        $is_title_in = false;
        $is_balloon_out = true;
        $is_balloon_in = false;
        $is_catch_title_in = false;
        $is_data_text = true;
        $is_detail = true;
        $is_action = true;
        $is_wordMouth = true;
        $reputation_type = 'detail';
        $is_reputation_col = true;
    }elseif ( isset($setting['page_archive']) ) {
        $is_title_out = false;
        $is_title_sp_out = true;
        $is_title_in = true;
        $is_balloon_out = false;
        $is_balloon_in = true;
        $is_catch_title_in = true;
        $is_data_text = false;
        $is_detail = false;
        $is_action = false;
        $is_wordMouth = true;
        $reputation_type = '';
        $is_reputation_col = true;
    }elseif ( isset($setting['page_search']) ) {
        $is_title_out = false;
        $is_title_sp_out = true;
        $is_title_in = true;
        $is_balloon_out = false;
        $is_balloon_in = true;
        $is_catch_title_in = true;
        $is_data_text = false;
        $is_detail = false;
        $is_action = false;
        $is_wordMouth = true;
        $reputation_type = '';
        $is_reputation_col = false;
    }

    $official_url = get_cushion_url($product->ID);
    $thumb = wp_get_attachment_image_src(get_post_field('product_thumb',$product->ID),'full');
    $reputation_com = get_field_object('product_reputation_0',$product->ID);
    $reputation_list = get_reputation_field($product->ID,$reputation_type);
    $is_detail_btn = get_post_meta($product->ID,'is_product_detail_btn',true);
    if($is_data_text) $data_text_list = get_product_data_text_field($product->ID);
    if($is_detail) $recommend_point_list = get_product_recommend_point_field($product->ID);
    if($is_detail) $detail_text = get_post_meta($product->ID,'product_detail',ture);

    if(isset($setting['ranking'])) $ranking_num = $setting['ranking'];

?>
    <article class="product">
        <?php if ($is_title_out) { //title ?>
            <h1 class="titleProduct titleProduct-top"><?php echo $product->post_title;?></h1>
        <?php  } ?>
        <?php if ($is_balloon_out) { //吹き出し ?>
            <div class="product__balloon-top balloonCommonTop">
                <?php echo get_post_meta($product->ID,'product_catchcopy_title',true); ?>
            </div>
        <?php } ?>

        <?php if ($is_title_sp_out) { //title ?>
            <h3 class="titleProduct titleProduct-sp <?php if ( $ranking_num && ($ranking_num < 4) ) {  ?>titleProduct-ranking titleProduct-ranking-0<?php echo $ranking_num; ?><?php  } ?>">
                <div class="titleProduct__main"><?php echo $product->post_title;?></div>
            </h3>
        <?php  } ?>

        <div class="product__figure">
            <figure class="">
                <a href="<?php echo $official_url; ?>"><img src="<?php echo $thumb[0]; ?>" alt="<?php echo $thumb[3]; ?>" width="<?php echo $thumb[1]; ?>" height="<?php echo $thumb[2]; ?>" class="img-r"/></a>
            </figure>
        </div>
        <div class="product__info">
            <?php if ($is_title_in) { //title ?>
                <h3 class="titleProduct titleProduct-pc <?php if ( $ranking_num && ($ranking_num < 4) ) {  ?>titleProduct-ranking titleProduct-ranking-0<?php echo $ranking_num; ?><?php  } ?>">
                    <div class="titleProduct__main"><?php echo $product->post_title;?></div>
                </h3>
            <?php } ?>
            <div class="catchProduct">
                <?php if ($is_catch_title_in) {  ?>
                    <h4 class="catchProduct__title"><?php echo get_post_meta($product->ID,'product_catchcopy_title',true); ?></h4>
                <?php } ?>
                <div class="catchProduct__deital">
                    <?php echo get_post_meta($product->ID,'product_catchcopy_deital',true); ?>
                </div>
            </div>


            <?php
                if ( isset($setting['page_detail']) ) {
                    $class_reputation = 'listReputationDetail';
                }else {
                    $class_reputation = 'listReputation';
                }
            ?>
            <div class="boxReputation">
                <h4 class="boxReputation__title <?php if ( isset($setting['page_detail']) ) { ?>boxReputation__title-detail<?php } ?>"><span class="boxReputation__label"><?php echo $reputation_com['label'];?></span><div class="boxReputation__img"><?php get_reputation($reputation_com['value']); ?></div></h4>
                <ul class="boxReputation__list <?php echo $class_reputation; ?>">
                    <?php foreach ($reputation_list as $key => $reputation) { ?>
                        <li class="<?php echo $class_reputation; ?>__item">
                            <div class="<?php echo $class_reputation; ?>__row">
                                <div class="<?php echo $class_reputation; ?>__label"><?php echo $reputation['label'];?></div>
                                <div class="<?php echo $class_reputation; ?>__value"><div class="<?php echo $class_reputation; ?>__ico"><?php get_reputation($reputation['value']); ?></div></div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php if($is_balloon_in) { //吹き出し ?>
                <div class="product__balloon balloonCommon">
                    <div class="balloonCommon__wrap">
                        <?php echo get_post_meta($product->ID,'product_balloon',true); ?>
                    </div>
                </div>
            <?php } ?>

        </div>

        <?php if ($is_data_text && $data_text_list) { ?>
            <div class="product__data">
                <ul class="listDataText">
                    <?php foreach ($data_text_list as $data_text_key => $data_text) { ?>
                        <li class="listDataText__item <?php if ($data_text_key < 4) echo "listDataText__item-column"; ?>">
                            <div class="listDataText__label"><?php echo $data_text['label'];?></div>
                            <div class="listDataText__value"><?php echo $data_text['value']?$data_text['value']:'---';?></div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <?php if ($is_wordMouth) { ?>
            <?php
                $args = array(
                    'posts_per_page' => 2,
                    'post_type' => 'word-mouth',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'cf_wordmouth_id',
                            'value' => $product->ID,
                            'compare' => 'LIKE',
                        ),
                    ),
                );
                $word_mouth_posts = get_posts( $args );
            ?>

            <?php if (!empty($word_mouth_posts)) { ?>
                <div class="product__wordMouth boxWordMouth">
                    <?php if ( isset($setting['page_detail']) ) { ?>
                        <h2 class="titleCommon">口コミ</h2>
                    <?php }else{ ?>
                        <div class="boxWordMouth__toggle">
                            <a href="javascript:void(0)" class="btnMain btnWordMouth" data-Wordmouth-id="<?php echo $product->ID ?>">
                                口コミを見る
                            </a>
                        </div>
                    <?php } ?>
                    <ul class="boxWordMouth__list listWordMouth ani-disp-1" <?php if ( !isset($setting['page_detail']) ) { ?>data-Wordmouth-target="<?php echo $product->ID ?>" style="display:none;"<?php } ?>>
                        <?php foreach ($word_mouth_posts as $word_mouth) { ?>
                            <?php $wordmouth_reputation = get_post_field('cf_wordmouth_reputation',$word_mouth->ID); ?>
                            <li class="listWordMouth__item">
                                <div class="listWordMouth__label">
                                    <?php echo get_post_meta($word_mouth->ID,'cf_wordmouth_area',true); ?>&nbsp;<?php echo get_post_meta($word_mouth->ID,'cf_wordmouth_age',true); ?><?php echo get_post_meta($word_mouth->ID,'cf_wordmouth_sex',true); ?><br>
                                    <?php echo get_post_meta($word_mouth->ID,'cf_wordmouth_name',true); ?><br>
                                    <div class="listWordMouth__reputation"><?php get_reputation($wordmouth_reputation); ?></div>
                                </div>
                                <div class="listWordMouth__detail">
                                    <?php echo get_post_meta($word_mouth->ID,'cf_wordmouth_detail',true); ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if ( isset($setting['page_detail']) && count($word_mouth_posts) > 1 ) { ?>
                        <!-- <div class="boxWordMouth__more">
                            <a href="<?php echo esc_url( home_url( '/word-mouth/?wm='.$product->ID ) ); ?>" class="btnMain btnWordMouth btnWordMouth-more">
                                もっと見る
                            </a>
                        </div> -->
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if ($is_detail) { ?>
            <div class="product__detail">
                <?php if ($recommend_point_list) { ?>
                    <h2><?php echo $product->post_title;?>はこんな人にオススメです！</h2>
                    <div class="bgCommon">
                        <ul>
                            <?php foreach ($recommend_point_list as $data_text_key => $recommend_point) { ?>
                                <li><?php echo $recommend_point;?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php if ($detail_text) { ?>
                    <?php echo apply_filters('the_content',$detail_text); ?>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($is_action) { ?>
            <div class="product__action">
                <p class="txtCol-m1 txtSiz-l txtWeight-b"><?php echo $product->post_title;?></p>
                <div>
                    <a href="<?php echo $official_url;?>" class="btnMain btnOfficial btnOfficial-l">
                        公式サイトをチェック
                        <span class="ani-deco-gura"></span>
                    </a>
                </div>
            </div>
        <?php }else{ ?>
            <div class="product__action product__action-internal actionProduct">
                <div class="actionProduct__official <?php if (!$is_detail_btn) { ?>actionProduct__official-w100<?php  } ?>">
                    <a href="<?php echo $official_url;?>" class="btnMain btnOfficial">
                        公式サイトをチェック
                        <span class="ani-deco-gura"></span>
                    </a>
                </div>
                <?php if ($is_detail_btn) { ?>
                    <div class="actionProduct__detail"><a href="<?php echo get_permalink($product->ID); ?>" class="btnSub btnDetail">詳細を見る</a></div>
                <?php  } ?>
            </div>
        <?php } ?>
    </article>

<?php
}
