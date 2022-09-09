<?php
    global $int_setting_ids;
    global $setting_page;
    global $setting_common;
    global $is_plan_ui;

    //ページの設定を取得
    $id = get_the_ID();
    $setting_page = get_post_setting($id);
    $is_plan_ui = $setting_common['common_is_plan_ui'];
    if(is_user_logged_in()) $is_plan_ui = true;
?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main">

    <?php
        //コロナウイルス対策
        vie_covid_common();

        //コンセプト
        vie_concept_common();

        //スライドショー
        vie_slideshow_common();

        //ギャラリー
        vie_gallarey_common();

        //プランについて
        vie_about_plan();

        //ポイント
        vie_point_common();

        //プラン価格
        vie_plan_price();

        //商品代について
        if(!empty($is_plan_ui)){
            vie_plan_commodity_fee();
        }

        //撮影について
        vie_plan_step();

        //口コミ
        vie_review_common();

        //アクセス
        vie_access_common();

        //BLOG
        vie_blog_common();
    ?>

</main>



<?php get_footer(); ?>
