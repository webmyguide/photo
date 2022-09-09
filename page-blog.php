<?php
    /*
    Template Name: ブログ一覧temp
    */
    global $int_setting_ids;
    global $setting_page;

    //ページの設定を取得
    $setting_page = get_post_setting($int_setting_ids['company']);
?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main pageBlog">
 <div class="pageBlog__list listBlog">
    <?php

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $the_query = new WP_Query( array(
      'post_status' => 'publish',
      'paged' => $paged,
      'posts_per_page' => 12, // 表示件数
      'orderby'     => 'date',
      'order' => 'DESC'
    ) );


    if ($the_query->have_posts()) :



      while ($the_query->have_posts()) : $the_query->the_post();
 ?>

     <article class="listBlog__items boxBlog">
         <a href="<?php the_permalink(); ?>"  class="boxBlog__figure">
            <?php if( has_post_thumbnail() ): ?>
                <?php echo get_thumb( $post->ID, 'medium', array( 'class' => 'boxBlog__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.gif" alt="no-img"/>
            <?php endif; ?>
         </a>
         <div class="boxBlog__lead">
             <time class="boxBlog__time"><?php echo get_post_time('Y.m.d [D]') ?></time>
             <h2 class="boxBlog__tit"><a href="<?php the_permalink(); ?>" class="boxBlog__link"><?php the_title(); ?></a></h2>
         </div>
     </article>



<?php
      endwhile;



    else :
      $html_top_result = '<div><p>ありません。</p></div>';
    endif;



    ?>
 </div>


    <div class="pageBlog__pagination">
    <?php //ページリスト表示処理
     vie_pagination( $the_query->max_num_pages, get_query_var( 'paged' ) );
      ?>
    </div>

    <?php
        //アクセス
        vie_access_common();
    ?>

</main>



<?php get_footer(); ?>
