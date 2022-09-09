<?php
    global $int_setting_ids;
    global $setting_page;

    //ページの設定を取得
    // $setting_page = get_post_setting($int_setting_ids['blog']);

    $http = is_ssl() ? 'https'. '://' : 'http' . '://';
    $url = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main pageCostume">
    <?php
        $terms = get_terms( 'cat-costume');
        // var_dump('<pre>');
        // var_dump($terms);
        // var_dump('</pre>');
    ?>


    <div class="pageCostume__cat">
        <ul class="listCatCostume">
            <?php foreach ($terms as $key => $value) { ?>
                <li class="listCatCostume__items"><a href="#costume-<?php echo $value->slug;?>" class="listCatCostume__link"><?php echo $value->name;?></a></li>
            <?php } ?>
        </ul>
    </div>

    <?php foreach ($terms as $key => $value) { ?>
        <section class="secCostume" data-pitchout-group="" data-pitchout-disp="md" id="costume-<?php echo $value->slug;?>">
            <h2 class="secCostume__tit"><?php echo $value->name;?></h2>
            <div class="secCostume__panel panelCostume">
                <ul class="listCostume ani-slider" data-gallarey-target="" data-paged="0" data-count="<?php echo $value->count;?>" data-type="costume" data-parent='1' data-term="<?php echo $value->slug;?>" data-id="<?php echo $post->ID;?>">
                </ul>
                <div class="panelCostume__loader loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="panelCostume__prev icoNavigation" data-gallarey="" data-gallarey-nav="prev"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_prev_01.svg" alt="前の画像へ" width="18" height="36" class="img-r verAlign-b" /></div>
                <div class="panelCostume__next icoNavigation" data-gallarey="" data-gallarey-nav="next"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_next_01.svg" alt="次の画像へ" width="18" height="36" class="img-r verAlign-b" /></div>
            </div>
            <div class="secCostume__more" data-more="1">more</div>
        </section>
    <?php } ?>

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
