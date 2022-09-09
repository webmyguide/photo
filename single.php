<?php
    global $int_setting_ids;
    global $setting_page;

    //ページの設定を取得
    $setting_page = get_post_setting($int_setting_ids['blog']);
?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main pageBlog">
    <section class="pageBlog__single single">
        <div class="single__info">
            <?php
                $category = get_the_category();
            ?>
            <?php if (!empty($category)) { ?>
                <ul class="pageBlog__category listCategory">
                    <?php foreach ($category as $cat_key => $cat_value) { ?>
                        <li class="listCategory__list">
                            <span class="category"><?php echo $cat_value->name; ?></span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <time class="single__time"><?php echo get_post_time('Y.m.d [D]') ?></time>
        </div>

        <h1 class="single__tit titSingle"><?php the_title(); ?></h1>

        <figure class="single__figure">
            <?php echo get_thumb( $post->ID, 'medium', array( 'class' => 'single__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
        </figure>

        <div class="single__content">
            <?php echo wpautop($post->post_content); ?>
        </div>
    </section>
    <?php
        //新着ブログ
        vie_blog_common($post->ID,3,'新着ブログ');

        //アクセス
        vie_access_common();
    ?>

</main>



<?php get_footer(); ?>
