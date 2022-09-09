<section class="contentWordMouthArchive">
    <h1 class="titlePage">口コミ</h1>

    <div class="contentWordMouthArchive__search">
        <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'product',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => 'sort_num',
            );
            $product_posts = get_posts( $args );
            $selected = '';
            if(isset($_GET['wm']))$selected = $_GET['wm'];
        ?>

        <form action="<?php echo esc_url( get_home_url() ); ?>/word-mouth/" method="get">
            <div class="pulldown">
                <select name="wm" class="selecting" id="jsAutoSubmit">
                    <option value="">転職・求人サイトで絞り込み</option>
                    <?php foreach ($product_posts as $product) {?>
                        <option value="<?php echo $product->ID; ?>"<?php if($selected == $product->ID)echo " selected";?>><?php echo $product->post_title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </form>
    </div>


    <?php
        $args = array(
            'posts_per_page' => 10,
            'paged' => $paged,
            'post_type' => 'word-mouth',
            'meta_key' => 'cf_wordmouth_id',
            'meta_value' => $selected,
        );
        $my_query = new WP_Query($args);
    ?>
    <?php if ( $my_query->have_posts() ): ?>
        <div class="contentWordMouthArchive__box">
            <ul class="boxWordMouth__list listWordMouth">
                <?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
                    <?php
                        $post_id = get_the_ID();
                        $wordmouth_reputation = get_post_field('cf_wordmouth_reputation',$post_id);
                        $product_id = get_post_field('cf_wordmouth_id',$post_id);
                        $product_name = get_post_field('post_title',$product_id);
                    ?>
                    <li class="listWordMouth__item">
                        <div class="listWordMouth__label">
                            <?php echo $product_name; ?><br>

                            <div class="listWordMouth__reputation"><?php get_reputation($wordmouth_reputation); ?></div>
                        </div>
                        <div class="listWordMouth__detail">
                            <?php echo get_post_field('cf_wordmouth_area',$word_mouth->ID); ?>&nbsp;
                            <?php echo get_post_field('cf_wordmouth_age',$word_mouth->ID); ?><?php echo get_post_field('cf_wordmouth_sex',$word_mouth->ID); ?>&nbsp;
                            <?php echo get_post_field('cf_wordmouth_name',$word_mouth->ID); ?><br>
                            <?php echo get_post_field('cf_wordmouth_detail',$word_mouth->ID); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

          <?php
              $big = 999999999; // need an unlikely integer
              $paginate_links = paginate_links( array(
                  'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                  'format' => '?paged=%#%',
                  'current' => max( 1, get_query_var('paged') ),
                  'total' => $my_query->max_num_pages
              ) );
          ?>
          <?php if($paginate_links){ ?>
              <div class="pagenav">
                  <?php echo $paginate_links; ?>
              </div>
          <?php } ?>

    <?php else: ?>
        <p>口コミがありません</p>
    <?php endif; ?>
</section>
