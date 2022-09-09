<?php
    global $int_setting_ids;
    global $setting_page;

    //ページの設定を取得
    $setting_page = get_post_setting($int_setting_ids['top']);
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

        //プラン
        vie_plan_common();

        //ポイント
        vie_point_common();

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
