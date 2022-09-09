<?php
    global $setting_articles_list;

    //テンプレートpage-indexか判定
    $temp_top = get_temp_top();

    if( is_home() || is_front_page() || $temp_top ) {
        $articles_max = 10;
    }else {
        $articles_max = 3;
    }

    if($setting_articles_list['is_archive']){
        $args = array(
            'posts_per_page' => -1,
        );
    }else {
        $args = array(
            'posts_per_page' => $articles_max,
            // 'tax_query' => array(
            //         array(
            //             'taxonomy'=> 'toplist',
            //             'terms'=>array( 'toppoint1'),
            //             'field'=>'slug',
            //             'include_children'=>true,
            //             'operator'=>'IN'
            //         ),
            // ),
        );
    }

    $articl_posts = get_posts( $args );
?>



<section class="contentCommon">
    <div class="contentCommon__wrap">

        <?php if($setting_articles_list['is_archive']){ ?>
            <h1 class="titlePage">記事一覧</h1>
        <?php } ?>

        <?php if(!$setting_articles_list['is_archive']){ ?>
            <h2 class="contentArticlesList__title">
                <img src="<?php echo get_template_directory_uri(); ?>/images/tit_blog_01.png" alt="ブラックな職場に就職しないための方法" width="580" height="80" class="img-r disp-sp"/>
                <img src="<?php echo get_template_directory_uri(); ?>/images/tit_blog_pc_01.png" alt="ブラックな職場に就職しないための方法" width="1014" height="153" class="img-r disp-pc"/>
            </h2>
        <?php } ?>
        <div class="contentCommon__box boxCommon">
            <ul class="listArticlesBlog">
                <?php foreach ( $articl_posts as $keyPage => $articl ) { ?>
                    <li class="listArticlesBlog__item <?php if(!$setting_articles_list['is_archive']){ ?>listArticlesBlog__item-pickup<?php } ?>">
                        <?php if($setting_articles_list['is_archive']){ ?><a href="<?php the_permalink($articl->ID); ?>" class="listArticlesBlog__link"><?php } ?>
                            <figure class="listArticlesBlog__figure">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/ico_blog_01.png" width="75" height="75" class="img-r verAlign-b"/>
                            </figure>
                            <div class="listArticlesBlog__detail">
                                <div class="listArticlesBlog__lead">
                                    <h3 class="listArticlesBlog__title txtCol-m1"><?php echo $articl->post_title;?></h3>
                                    <?php if($articl->post_excerpt){ ?><div class="listArticlesBlog__excerpt"><?php echo mb_substr($articl->post_excerpt, 0, 32).'……'; ?></div><?php } ?>
                                </div>
                                <?php if(!$setting_articles_list['is_archive']){ ?>
                                    <div class="listArticlesBlog__more"><a href="<?php the_permalink($articl->ID); ?>" class="btnSub btnMore">もっと見る</a></div>
                                <?php } ?>
                            </div>
                        <?php if($setting_articles_list['is_archive']){ ?></a><?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
