<section class="contentProductArchive">
    <h1 class="titlePage">看護師専門！転職サイト一覧</h1>

    <?php if ( have_posts() ): ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
                $post_id = get_the_ID();
                $thumb = wp_get_attachment_image_src(get_post_field('product_thumb',$post_id),'full');
                $reputation_com = get_field_object('product_reputation_0', $post_id);

                //$detail_text = remove_shortcode( $detail_text );// ショートコードを取り除く
                // $detail_text = get_post_field( $post_id, 'product_detail' );
            ?>

            <?php
                $setting = array(
                    'page_archive' => true,
                );
                view_product($post,$setting);
             ?>

        <?php endwhile; ?>

          <?php
              global $wp_query;
              $big = 999999999; // need an unlikely integer
              $paginate_links = paginate_links( array(
                  'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                  'format' => '?paged=%#%',
                  'current' => max( 1, get_query_var('paged') ),
                  'total' => $wp_query->max_num_pages
              ) );
          ?>
          <?php if($paginate_links){ ?>
              <div class="pagenav">
                  <?php echo $paginate_links; ?>
              </div>
          <?php } ?>

    <?php else: ?>
        <p>サイトがありません</p>
    <?php endif; ?>
</section>
