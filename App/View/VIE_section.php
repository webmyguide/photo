<?php

//--------------------------------------------------------------------------------------------------
// コンセプト
//--------------------------------------------------------------------------------------------------

function vie_concept_common($is_movie = true){
    global $setting_common;
    $res = get_cf_concept();
?>

    <section class="contentCommon secConcept" <?php if (is_home() || is_front_page()) { ?>id="top_concept"<?php } ?>>
        <h2 class="titCommon secConcept__tit">CONCEPT</h2>
        <div class="contentCommon__wrap">
            <?php if($res['thumb']){ ?>
                <figure class="secConcept__figure figureCommon">
                    <img src="<?php echo $res['thumb'][0]; ?>" alt="<?php echo $res['thumb'][3]; ?>" width="<?php echo $res['thumb'][1]; ?>" height="<?php echo $res['thumb'][2]; ?>" class="figureCommon__img verAlign-b msimg"/>
                </figure>
            <?php } ?>
            <?php if($res['title']){ ?>
                <p class="secConcept__appeal"><?php echo $res['title']; ?></p>
            <?php } ?>
            <?php if($res['detail']){ ?>
                <div class="secConcept__detail">
                    <?php echo apply_filters('the_content',$res['detail']); ?>
                </div>
            <?php } ?>
            <?php if($res['is_movie'] && $is_movie && !empty($res['movie_id'])){ ?>
                <div class="secConcept__movie">
                    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $res['movie_id']; ?>?autoplay=1&mute=1&playsinline=1&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php } ?>
        </div>
    </section>


<?php }


//--------------------------------------------------------------------------------------------------
// スライドショー
//--------------------------------------------------------------------------------------------------

function vie_slideshow_common(){
    global $setting_common;
    $res = get_cf_slideshow();
?>
    <?php if( !empty($res['movie_id']) ){ ?>
        <section class="contentCommon secConcept" <?php if (is_home() || is_front_page()) { ?>id="top_concept"<?php } ?>>
            <h2 class="titCommon secConcept__tit">SLIDESHOW</h2>
            <div class="contentCommon__wrap">
                <?php if($res['detail']){ ?>
                    <div class="secConcept__detail">
                        <?php echo apply_filters('the_content',$res['detail']); ?>
                    </div>
                <?php } ?>

                <div class="secConcept__movie">
                    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $res['movie_id']; ?>?autoplay=1&mute=1&playsinline=1&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </section>
    <?php } ?>

<?php }

//--------------------------------------------------------------------------------------------------
// ギャラリー
//--------------------------------------------------------------------------------------------------

function vie_gallarey_common(){
    global $setting_common;
    global $post;

    $res = get_post_gallarey();
    $count = get_count_gallarey();

    $post_type = $post->post_type;
    if ($post_type == 'plan' && is_single()){
        $type_gallarey = 'plan';
    }else {
        $type_gallarey = '';
    }


?>

    <section class="contentCommon secGallarey" <?php if (is_home() || is_front_page()) { ?>id="top_gallarey"<?php } ?> data-pitchout-group="">
        <h2 class="titCommon secGallarey__tit">GALLAREY</h2>
        <ul class="listGallarey secGallarey__list" data-gallarey-target="" data-paged="0" data-count="<?php echo $count;?>" data-type="<?php echo $type_gallarey;?>"  data-id="<?php echo $post->ID;?>">
        </ul>
        <div class="secGallarey__loader loader">
          <div></div>
          <div></div>
          <div></div>
        </div>
        <?php if ($count > 12) { ?>
            <div class="secGallarey__more" data-more="1">more</div>
        <?php } ?>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// プラン
//--------------------------------------------------------------------------------------------------

function vie_plan_common(){
    global $setting_common;

    $args = array(
        'post_type' => 'plan',
        'posts_per_page' => -1,
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
    );
    $res = get_posts($args);

    $class_list = '';
    if(count($res)%3 == 1){
        $class_list = 'listPlan-mb1';
    }elseif (count($res)%3 == 2) {
        $class_list = 'istPlan-mb2';
    }
?>
    <section class="contentCommon secMenu" <?php if (is_home() || is_front_page()) { ?>id="top_plan"<?php } ?>>
        <h2 class="titCommon secMenu__tit"><?php echo $setting_common['top_menu_title']; ?></h2>
        <p class="secMenu__appeal"><?php echo $setting_common['top_menu_catch']; ?></p>
        <div class="secMenu__plan listPlan <?php echo $class_list; ?>">
            <?php foreach ($res as $key => $value) { ?>
                <?php
                    $title_short = get_post_meta($value->ID,'plan_title_short',true);
                    $title_plans = $value->post_title;
                    // $title_plans = (!empty($title_short))? $title_short: $value->post_title;
                    if($key == 0) $caution = get_post_meta($value->ID,'plan_fee_attention',true);
                    $is_detail_page = get_post_meta($value->ID,'plan_is_detail',true);
                ?>

                <article class="listPlan__items boxPlan">
                    <?php if (!empty($is_detail_page)) { ?>
                        <a href="<?php echo get_post_permalink($value->ID); ?>" class="boxPlan__figure">
                            <?php echo get_thumb( $value->ID, 'medium', array( 'class' => 'boxPlan__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
                        </a>
                    <?php }else{ ?>
                        <figure class="boxPlan__figure">
                            <?php echo get_thumb( $value->ID, 'medium', array( 'class' => 'boxPlan__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
                        </figure>
                    <?php } ?>

                    <div class="boxPlan__cat icoCommon">PLAN <?php echo $key+1;?></div>
                    <?php if (!empty($is_detail_page)) { ?>
                        <h3 class="boxPlan__name"><a href="<?php echo get_post_permalink($value->ID); ?>" class="boxPlan__link">→&nbsp;<?php echo $title_plans;?></a></h3>
                    <?php }else{ ?>
                        <h3 class="boxPlan__name"><?php echo $title_plans;?></h3>
                    <?php } ?>
                    <p class="boxPlan__name-en"><?php echo get_post_meta($value->ID,'plan_title_en',true);?></p>
                </article>
            <?php } ?>
        </div>


        <!-- <?php
            //タイムゾーンの設定
            date_default_timezone_set('Asia/Tokyo');
            if (strtotime(date('Y-m-d H:i')) <= strtotime('2020-10-31 23:59')){
                $campaign_name = 'プレOPENキャンペーン';
                $campaign_balloon = '8,000';
                $campaign_price_before = '33,000';
                $campaign_price = '25,000';
            }else {
                $campaign_name = '【平日限定】キャンペーン';
                $campaign_balloon = '5,200';
                $campaign_price_before = '35,000';
                $campaign_price = '29,800';
            }

        ?>
        <article class="boxPlanService">
            <div class="boxPlanService__areaPrice">
                <h3 class="boxPlanService__title">プラン料金</h3>
                <p class="boxPlanService__campaign"><span class="marker-01"><?php echo $campaign_name; ?></span></p>
                <div class="boxPlanService__discountAmount"><p class="boxPlanService__balloon"><?php echo $campaign_balloon; ?>円引き</p></div>
                <p class="boxPlanService__price-before"><span class="boxPlanService__discount">￥<?php echo $campaign_price_before; ?></span>&nbsp;→&nbsp;</p>
                <p class="boxPlanService__price">￥<?php echo $campaign_price; ?><span class="boxPlanService__tax">（税込）</span></p>
            </div>
            <div class="boxPlanService__areaService">
                <h3 class="boxPlanService__title boxPlanService__title-service">プラン内容</h3>
                <ul class="listPlanService">
                    <li class="listPlanService__items listPlanService__items-fee">撮影料金</li>
                    <li class="listPlanService__items listPlanService__items-data">撮影データ<br>65枚</li>
                    <li class="listPlanService__items listPlanService__items-costume">選べる衣装<br>2着まで無料</li>
                    <li class="listPlanService__items listPlanService__items-goods">お気に入り<br>グッズ持込無料</li>
                </ul>
            </div>
            <div class="boxPlanService__areaCaution">
                <?php echo apply_filters('the_content',$caution); ?>
            </div>
        </article> -->

    </section>
<?php }

//--------------------------------------------------------------------------------------------------
// ポイント
//--------------------------------------------------------------------------------------------------

function vie_point_common(){
    global $setting_common;
    global $post;

    $res = get_common_point();
?>

    <section class="contentCommon secPoint" <?php if (is_home() || is_front_page()) { ?>id="top_point"<?php } ?>>
        <h2 class="titCommon titCommon-sl secPoint__tit"><?php echo $res['title']; ?></h2>

        <?php foreach ($res['list'] as $key => $value) { ?>
            <?php if(!empty($value['thumb'])) { ?>
                <article class="boxPoint">
                    <div class="boxPoint__lead">
                        <h3 class="boxPoint__tit"><?php echo $value['title']; ?></h3>
                        <p class="boxPoint__tit-en">POINT&nbsp;:&nbsp;<?php echo $value['title_en']; ?></p>
                        <p class="boxPoint__detail"><?php echo $value['detail']; ?></p>
                    </div>
                    <figure class="boxPoint__figure">
                        <img src="<?php echo $value['thumb'][0]; ?>" alt="<?php echo $value['thumb'][3]; ?>" width="<?php echo $value['thumb'][1]; ?>" height="<?php echo $value['thumb'][2]; ?>" class="boxPoint__img verAlign-b msimg" loading="lazy" <?php echo $value['style']; ?> />
                    </figure>
                </article>
            <?php }?>
        <?php }?>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// レビュー
//--------------------------------------------------------------------------------------------------

function vie_review_common(){
    global $setting_common;


    $res = get_post_review();

?>

    <section class="contentCommon secReview" <?php if (is_home() || is_front_page()) { ?>id="top_review"<?php } ?>>
        <h2 class="titCommon secReview__tit">口コミ</h2>
        <div class="secReview__list listReview">
            <?php foreach ($res as $key => $value) { ?>
                <?php
                    $terms = get_the_terms($value->ID,'cat-review');

                ?>
                <article class="listReview__items boxReview">
                    <figure class="boxReview__figure figureCommon">
                        <?php echo get_thumb( $value->ID, 'medium', array( 'class' => 'figureCommon__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
                    </figure>
                    <div class="boxReview__lead">
                        <div class="boxReview__plan icoCommon"><?php echo $terms[0]->name; ?></div>
                        <h3 class="boxReview__tit"><?php echo $value->post_title; ?></h3>

                        <div class="boxReview__name"><?php echo get_post_meta($value->ID,'cf_review_name',true);?>&nbsp;<?php echo get_post_meta($value->ID,'cf_review_age',true);?>歳&nbsp;<?php echo get_post_meta($value->ID,'cf_review_cities',true);?></div>

                        <p class="boxReview__detail"><?php echo $value->post_content; ?></p>
                    </div>
                </article>
            <?php } ?>
        </div>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// ブログ
//--------------------------------------------------------------------------------------------------

function vie_blog_common($exclude_id = '',$max = 3,$sec_title = 'ブログ'){
    global $setting_common;
    global $enable_blog;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $max,
        'exclude' => $exclude_id,
    );

    $res = get_posts($args);
?>

    <?php if(!empty($enable_blog)){ ?>
        <section class="contentCommon secBlog" <?php if (is_home() || is_front_page()) { ?>id="top_blog"<?php } ?>>
            <h2 class="titCommon secBlog__tit"><?php echo $sec_title; ?></h2>
            <div class="secBlog__list listBlog">
                <?php foreach ($res as $key => $value) {
                    vie_article_blog($value->ID);
                 } ?>
            </div>
            <a href="<?php echo home_url('/blogs/'); ?>" class="secBlog__more btnMore">more</a>
        </section>
    <?php } ?>

<?php }

//--------------------------------------------------------------------------------------------------
// アクセス
//--------------------------------------------------------------------------------------------------

function vie_access_common(){
    global $setting_common;
?>

    <section class="contentCommon secAccess" <?php if (is_home() || is_front_page()) { ?>id="top_access"<?php } ?>>
        <h2 class="titCommon secAccess__tit">ACCESS</h2>
        <div class="secAccess__detail">
            <p class="secAccess__address">〒<?php echo $setting_common['common_postal_code'];?>&nbsp;<?php echo $setting_common['common_street_address'];?></p>
            <p class="secAccess__direction"><?php echo $setting_common['common_access'];?></p>
        </div>
        <div class="secAccess__map">
            <iframe src="<?php echo $setting_common['common_google_map'];?>" width="600" height="450" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"  class="secAccess__iframe"></iframe>
        </div>

        <div class="secAccess__btn">
            <a href="<?php echo get_link_page('reserve'); ?>" class="btnContact">撮影予約・お問い合わせ</a>
        </div>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// コロナウイルス対策
//--------------------------------------------------------------------------------------------------

function vie_covid_common(){
?>

    <section class="contentCommon secCovid">
        <h2 class="secCovid__tit">新型コロナウイルス対策実施中</h2>
        <ul class="listCovid secCovid__list">
            <li class="listCovid__items">
                <img src="<?php echo get_template_directory_uri(); ?>/images/ico_covid_01.svg" alt="マスク" width="180" height="180" class="secCovid__ico img-r verAlign-b"/><br>
                マスク
            </li>
            <li class="listCovid__items">
                <img src="<?php echo get_template_directory_uri(); ?>/images/ico_covid_02.svg" alt="マスク" width="180" height="180" class="secCovid__ico img-r verAlign-b"/><br>
                手洗い
            </li>
            <li class="listCovid__items">
                <img src="<?php echo get_template_directory_uri(); ?>/images/ico_covid_03.svg" alt="マスク" width="180" height="180" class="secCovid__ico img-r verAlign-b"/><br>
                消毒
            </li>
        </ul>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// プランについて
//--------------------------------------------------------------------------------------------------

function vie_about_plan(){
    $id = get_the_ID();


    $is_about = get_post_meta($value->ID,'plan_is_about',true);

?>
    <?php if(!empty($is_about)) { ?>
        <section class="contentCommon secAboutPlan">
            <h2 class="titCommon titCommon-sl secAboutPlan__tit"><?php echo get_post_field('plan_about_title',$id);?></h2>
            <div class="secAboutPlan__list">
                <?php for ($i=1; $i <= 3; $i++) { ?>
                    <?php
                        $key = 'plan_about_'.$i;
                        $thumb = get_thumb_plan( $id, $key, array( 'class' => 'boxAboutPlan__img verAlign-b msimg', 'loading' => 'lazy' ) );
                    ?>
                    <?php if(!empty($thumb)) { ?>
                        <article class="boxAboutPlan">
                            <figure class="boxAboutPlan__figure">
                                <?php echo $thumb; ?>
                            </figure>
                            <h3 class="boxAboutPlan__tit"><?php echo get_post_field($key.'_title',$id); ?></h3>
                            <p class="boxAboutPlan__detail"><?php echo get_post_field($key.'_detail',$id); ?></p>
                        </article>
                    <?php }?>
                <?php }?>
            </div>
            <div class="secAboutPlan__movie">
                <video loop autoplay muted playsinline src="<?php echo get_template_directory_uri(); ?>/movie/movie_concept_01.mp4" class="img-r"></video>
            </div>
        </section>
    <?php }?>
<?php }

//--------------------------------------------------------------------------------------------------
// プラン価格
//--------------------------------------------------------------------------------------------------

function vie_plan_price(){
    global $setting_common;
    global $is_plan_ui;
    $id = get_the_ID();
    //情報の取得
    $info_price = get_cf_plan_price($id);
?>
    <section class="contentCommon secPlanService">
        <h2 class="titCommon secPlanService__tit">プラン価格</h2>
        <article class="boxPlanService">
            <div class="boxPlanService__areaPrice">
                <h3 class="boxPlanService__title">プラン料金</h3>
                <?php if(!empty($info_price['name'])){?><p class="boxPlanService__campaign"><span class="marker-01"><?php echo $info_price['name'];?></span></p><?php } ?>
                <?php if(!empty($info_price['balloon'])){?><div class="boxPlanService__discountAmount"><p class="boxPlanService__balloon"><?php echo $info_price['balloon'];?></p></div><?php } ?>
                <?php if(!empty($info_price['price_before'])){?><p class="boxPlanService__price-before"><span class="boxPlanService__discount">￥<?php echo number_format($info_price['price_before']);?></span>&nbsp;→&nbsp;</p><?php } ?>
                <div class="boxPlanService__price <?php if(!empty($is_plan_ui)){?>boxPlanService__price-type1<?php } ?>">
                    <div><?php if(!empty($is_plan_ui)){?><span class="boxPlanService__commodity">撮影料 </span><?php } ?>￥<?php echo (!empty($info_price['price']))?number_format($info_price['price']): 0;?><span class="boxPlanService__tax">（税込）</span></div><?php if(!empty($is_plan_ui)){?><div><span class="boxPlanService__commodity">+商品代</span></div><?php } ?>
                </div>
                <?php if(!empty($is_plan_ui) && !empty($info_price['holiday'])){?><div class="boxPlanService__holiday">※土日祝+<?php echo number_format($info_price['holiday']);?>円</div><?php } ?>
            </div>
            <div class="boxPlanService__areaService">
                <h3 class="boxPlanService__title boxPlanService__title-service">プラン内容</h3>
                <ul class="listPlanService">
                    <?php if(!empty($is_plan_ui)){?>
                        <?php if(!empty($info_price['contents_5'])){?>
                            <li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-line"><?php echo $info_price['contents_5'];?></div></li>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php if(!empty($info_price['contents_1'])){?>
                            <li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-fee"><?php echo $info_price['contents_1'];?></div></li>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!empty($is_plan_ui)){?>
                        <?php if(!empty($info_price['contents_6'])){?>
                            <?php if(!empty($info_price['fee_movie'])){?>
                                <li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-slide"><a href="<?php echo $info_price['fee_movie'];?>" target="_blank" rel="noopener"><?php echo $info_price['contents_6'];?></div></a></li>
                            <?php }else{ ?>
                                <li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-slide"><?php echo $info_price['contents_6'];?></div></li>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php if(!empty($info_price['contents_2'])){?><li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-data"><?php echo $info_price['contents_2'];?></div></li><?php } ?>
                    <?php } ?>
                    <?php if(!empty($info_price['contents_3'])){?><li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-costume"><?php echo $info_price['contents_3'];?></div></li><?php } ?>
                    <?php if(!empty($info_price['contents_4'])){?><li class="listPlanService__items"><div class="listPlanService__ico listPlanService__items-goods"><?php echo $info_price['contents_4'];?></div></li><?php } ?>
                </ul>
            </div>
            <div class="boxPlanService__areaCaution">
                <?php if(!empty($info_price['caution'])) echo apply_filters('the_content',$info_price['caution']); ?>
            </div>
        </article>
    </section>
<?php }


//--------------------------------------------------------------------------------------------------
// 商品代
//--------------------------------------------------------------------------------------------------

function vie_plan_commodity_fee(){
    global $setting_common;
    global $int_setting_ids;


    if( is_home() || is_front_page() ) {
        $id = $int_setting_ids['plan'];
    }else {
        $id = get_the_ID();
    }

    $max_commodity = get_post_field('plan_commodity_num',$id);

    //タイトルの取得
    $title_commodity = get_post_field('plan_commodity_title',$int_setting_ids['plan']);

?>
    <section class="contentCommon secPlanCommodity">
        <h2 class="titCommon secPlanCommodityp__tit"><?php echo $title_commodity; ?></h2>
        <div class="secPlanCommodity__list">
            <?php for ($i=1; $i <= $max_commodity; $i++) { ?>
                <?php
                    $key = 'plan_commodity_'.$i;
                    $thumb = get_thumb_plan( $id, $key, array( 'class' => 'boxPlanStep__img verAlign-b msimg', 'loading' => 'lazy' ) );
                    //情報の取得
                    $info_price = get_cf_commodity_price($id,$key);
                ?>

                    <article class="boxPlanCommodity">
                        <h3 class="boxPlanCommodity__tit"><?php echo get_post_field($key.'_title',$id); ?></h3>
                        <figure class="boxPlanCommodity__figure">
                            <?php echo $thumb; ?>
                        </figure>
                        <p class="boxPlanCommodity__detail"><?php echo get_post_field($key.'_detail',$id); ?></p>
                        <div class="boxPlanCommodity__areaPrice">
                            <?php if(!empty($info_price['name'])){?>
                                <div class="boxPlanCommodity__campaign">
                                    <p><?php echo $info_price['name'];?></p>
                                    <?php if(!empty($info_price['balloon'])){?><p class="boxPlanCommodity__balloon"><?php echo $info_price['balloon'];?></p><?php } ?>
                                </div>
                            <?php } ?>

                            <?php if(!empty($info_price['price_before'])){?><p class="boxPlanCommodity__price-before"><span class="boxPlanCommodity__discount">￥<?php echo number_format($info_price['price_before']);?></span>&nbsp;→&nbsp;</p><?php } ?>
                            <p class="boxPlanCommodity__price">￥<?php echo (!empty($info_price['price']))?number_format($info_price['price']): 0;?><span class="boxPlanCommodity__tax">（税込）</span></p>
                        </div>
                        <?php if(!empty($info_price['fee_holiday'])){?><div class="boxPlanCommodity__holiday">※土日祝+<?php echo number_format($info_price['fee_holiday']);?>円</div><?php } ?>
                    </article>

            <?php }?>
        </div>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// 撮影について
//--------------------------------------------------------------------------------------------------

function vie_plan_step(){
    global $setting_common;
    global $int_setting_ids;


    if( is_home() || is_front_page() ) {
        $id = $int_setting_ids['plan'];
    }else {
        $id = get_the_ID();
    }
?>

    <section class="contentCommon secPlanStep">
        <h2 class="titCommon secPlanStep__tit">撮影について</h2>
        <div class="secAboutPlan__list">
            <?php for ($i=1; $i <= 3; $i++) { ?>
                <?php
                    $key = 'plan_about_step_'.$i;
                    $thumb = get_thumb_plan( $id, $key, array( 'class' => 'boxPlanStep__img verAlign-b msimg', 'loading' => 'lazy' ) );
                ?>
                <?php if(!empty($thumb)) { ?>
                    <article class="boxPlanStep">
                        <figure class="boxPlanStep__figure">
                            <?php echo $thumb; ?>
                        </figure>
                        <p class="boxPlanStep__step">STEP<?php echo $i; ?></p>
                        <h3 class="boxPlanStep__tit"><?php echo get_post_field($key.'_title',$id); ?></h3>
                        <p class="boxPlanStep__detail"><?php echo get_post_field($key.'_detail',$id); ?></p>
                    </article>
                <?php }?>
            <?php }?>
        </div>
    </section>


<?php }

//--------------------------------------------------------------------------------------------------
// 会社概要
//--------------------------------------------------------------------------------------------------

function vie_company_profile(){
    global $setting_common;
?>
    <section class="contentCommon secCompanyProfile">
        <h2 class="titCommon secCompanyProfile__tit">会社概要</h2>
        <dl class="secCompanyProfile__list listCompanyProfile">
            <dt class="listCompanyProfile__label">会社名</dt>
                <dd class="listCompanyProfile__detail"><?php echo $setting_common['common_conpany_name']; ?></dd>
            <dt class="listCompanyProfile__label">所在地</dt>
                <dd class="listCompanyProfile__detail">
                    〒<?php echo $setting_common['common_postal_code'];?><br>
                    <?php echo $setting_common['common_street_address'];?>
                </dd>
            <dt class="listCompanyProfile__label">営業日</dt>
                <dd class="listCompanyProfile__detail">
                    受付時間&nbsp;<?php echo $setting_common['common_reception_time_1'];?>〜<?php echo $setting_common['common_reception_time_2'];?>&nbsp;/&nbsp;定休日&nbsp;<?php echo $setting_common['common_regular_holiday'];?><br>
                </dd>
            <dt class="listCompanyProfile__label">TEL</dt>
                <dd class="listCompanyProfile__detail"><?php echo $setting_common['common_phone_number'];?></dd>
            <dt class="listCompanyProfile__label">設立</dt>
                <dd class="listCompanyProfile__detail"><?php echo $setting_common['common_establishment']; ?></dd>
            <dt class="listCompanyProfile__label">代表カメラマン</dt>
                <dd class="listCompanyProfile__detail"><?php echo $setting_common['common_ceo']; ?></dd>
            <dt class="listCompanyProfile__label">資本金</dt>
                <dd class="listCompanyProfile__detail"><?php echo $setting_common['common_capital']; ?></dd>
            <?php if($setting_common['common_business_content']){ ?>
                <dt class="listCompanyProfile__label">事業内容</dt>
                    <dd class="listCompanyProfile__detail"><?php echo apply_filters('the_content',$setting_common['common_business_content']); ?></dd>
            <?php } ?>
        </dl>
    </section>
<?php } ?>
