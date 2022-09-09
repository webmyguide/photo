<?php
    /*
    Template Name: 会社概要・アクセスtemp
    */
    global $int_setting_ids;
    global $setting_page;

    //ページの設定を取得
    $setting_page = get_post_setting($int_setting_ids['company']);
?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main">

    <?php
        //会社概要
        vie_company_profile();

        //コンセプト
        vie_concept_common(false);

        //アクセス
        vie_access_common();

        //BLOG
        vie_blog_common();
    ?>

</main>



<?php get_footer(); ?>
