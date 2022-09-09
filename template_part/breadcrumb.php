<?php
/*-------------------------------------------*/
/*  BreadCrumb
/*-------------------------------------------*/

global $wp_query;

// Get Post type info
/*-------------------------------------------*/
$postType = tsign_get_post_type();

// Get Post top page info
/*-------------------------------------------*/
$page_for_posts = tsign_get_page_for_posts();

$panListHtml = '<!-- [ .breadSection ] -->
<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$panListHtml .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . home_url() . '"  itemprop="item"><span itemprop="name">'. get_bloginfo() .'</span></a><meta itemprop="position" content="1" /></li>';

/* Post type
/*-------------------------------*/
if ( is_archive() || ( is_single() && !is_attachment()) ) {

    if ( $postType['slug'] == 'post' || is_category() || is_tag() ){ /* including single-post */
        if ( $page_for_posts['post_top_use'] ) {
            if ( is_home() ) {
                $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span  span itemprop="name">'.the_title('','', FALSE).'</span></li>';
            }
        }
    } else {
        if ( !is_single() || !is_year() || !is_month() || !is_day() || !is_tax() || !is_author() ) {
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="'. get_post_type_archive_link( $postType['slug'] ) .'" itemprop="item"><span itemprop="name">'.$postType['name'].'</span></a></li>';
        }
    }
}

if ( is_home() ){

    /////// When use to post top page
    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $postType['name'] . '</span></li>';

} else if ( is_category() ) {

    /* Category
    /*-------------------------------*/

    // Get category information & insert to $cat
    $cat = get_queried_object();

    // parent != 0  >>>  Parent exist
    if($cat->parent != 0):
        // 祖先のカテゴリー情報を逆順で取得
        $ancestors = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
        // 祖先階層の配列回数分ループ
        foreach($ancestors as $ancestor):
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($ancestor).'" itemprop="item"><span  itemprop="name">'.esc_html(get_cat_name($ancestor)).'</span></a></li>';
        endforeach;
    endif;
    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span  itemprop="name">'. $cat->cat_name. '</span></li>';

} elseif ( is_tag() ) {

    /* Tag
    /*-------------------------------*/

    $tagTitle = single_tag_title( "", false );
    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span  itemprop="name">'. $tagTitle .'</span></li>';


} else if (is_tax()) {

    /* term
    /*-------------------------------*/

    $now_term = $wp_query->queried_object->term_id;
    $now_term_parent = $wp_query->queried_object->parent;
    $now_taxonomy = $wp_query->queried_object->taxonomy;

    // parent が !0 の場合 = 親カテゴリーが存在する場合
    if($now_term_parent != 0):
        // 祖先のカテゴリー情報を逆順で取得
        $ancestors = array_reverse(get_ancestors( $now_term, $now_taxonomy ));
        // 祖先階層の配列回数分ループ
        foreach($ancestors as $ancestor):
            $pan_term = get_term($ancestor,$now_taxonomy);
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="'.get_term_link($ancestor,$now_taxonomy).'"  itemprop="item"><span  itemprop="name">'.esc_html($pan_term->name).'</span></a></li>';
        endforeach;
    endif;

    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span  itemprop="name">'.esc_html(single_cat_title('','', FALSE)).'</span></li>';

} elseif ( is_archive() && (!is_category() || !is_tax()) ) {

    $query = $wp_query->query_vars;

    /* Year / Monthly / Dayly
    /*-------------------------------*/

    if ( is_year() || is_month() || is_day() ){

        if ( !empty( $query['post_type'] ) ) {
            $current_post_type = get_post_type_object( $query['post_type']);
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="' . home_url() . '/?post_type=' . $post_type . '/" itemprop="item"><span  itemprop="name">' . $current_post_type->label . '</span></a></li>';
        }

        if ($postType['slug'] != 'post') {
            $post_type         = $wp_query->query_vars['post_type'];
            $current_post_type = get_post_type_object( $post_type );
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="' . home_url() . '/' . $post_type . '/" itemprop="item"><span itemprop="name">' . $current_post_type->label . '</span></a></li>';
        }

        if (is_year()){
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span>' . sprintf( 'Yearly Archives: %s', date( _x( 'Y', 'yearly archives date format' ), strtotime( $query['year'] .'-01-01' ) ) ) . '</span></li>';
        } else if (is_month()){
            $month = ( $query['monthnum'] < 10 ) ? '0' . $query['monthnum'] : $query['monthnum'];
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span>' . sprintf( 'Monthly Archives: %s', date( _x( 'F Y', 'monthly archives date format' ), strtotime( $query['year'] . '-' . $month . '-01' ) ) ) . '</span></li>';
        } elseif(is_day()) {
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span>' . sprintf( 'Daily Archives: %s', date( _x( 'F jS, Y', 'daily archives date format' ), strtotime( $query['year'] . '-' . $query['monthnum'] . '-' . $query['day'] ) ) ) . '</span></li>';
        }

    }

} else if ( is_author() ) {

    /* Author
    /*-------------------------------*/

    $userObj = get_queried_object();
    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $userObj->display_name ) . '</span></li>';

} elseif ( is_single() ) {

    /* Single
    /*-------------------------------*/

    // Case of post
    if ( $postType['slug'] == 'post' ) {
        $tarms = get_the_category( $post -> ID );
        if( !empty( $tarms ) ){
            foreach ( $tarms as $tarm ) {
                $tarmname[] = $tarm->name;
                $term_url[] = get_term_link( $tarm );
            }
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="' . $term_url[0] . '" itemprop="item"><span itemprop="name">' . esc_html( $tarmname[0] ) . '</span></a></li>';
        }

    // Case of custom post type

    } else {
        $taxonomies = get_the_taxonomies();
        $taxonomy = key( $taxonomies );

        if ($taxonomies):
            $terms  = get_the_terms( get_the_ID(), $taxonomy );

            //keeps only the first term (categ)
            $term   = reset( $terms );
            if ( 0 != $term->parent ) {

                // Get term ancestors info
                $ancestors = array_reverse(get_ancestors( $term->term_id, $taxonomy ));
                // Print loop term ancestors
                foreach($ancestors as $ancestor):
                    $pan_term = get_term($ancestor,$taxonomy);
                    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="'.get_term_link($ancestor,$taxonomy).'" itemprop="item">
									<span itemprop="name">'.esc_html($pan_term->name).'</span></a></li>';
                endforeach;
            }
            $term_url       = get_term_link($term->term_id,$taxonomy);
            $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="' . $term_url . '" itemprop="item"><span itemprop="name">' . esc_html($term->name) . '</span></a></li>';
        endif;

    }

    $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span></li>';

} else if ( is_page() ) {

    /* Page
    /*-------------------------------*/

    $post = $wp_query->get_queried_object();
    if ( $post->post_parent == 0 ){
        $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span></li>';
    } else {
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        array_push( $ancestors, $post->ID );
        foreach ( $ancestors as $ancestor ) {
            if( $ancestor != end( $ancestors ) ) {
                $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor) .'" itemprop="item"><span itemprop="name">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</span></a></li>';
            } else {
                $panListHtml .= '<li itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) . '</span></li>';
            }
        }
    }

} else if ( is_404() ){

    /* 404
    /*-------------------------------*/

    $panListHtml .= '<li><span>Not found</span></li>';

} else if ( is_search() ) {

    /* Search result
    /*-------------------------------*/

    $panListHtml .= '<li><span>' . sprintf( 'Search Results for : %s' , get_search_query() ) . '</span></li>';


} elseif ( is_attachment() ) {

    /* Attachment
    /*-------------------------------*/

    $panListHtml .= '<li><span>'.the_title('','', FALSE).'</span></li>';

}
$panListHtml .= '</ol>
<!-- [ /.breadSection ] -->';
echo $panListHtml;


/*-------------------------------------------*/
/*  Chack use post top page
/*-------------------------------------------*/
function tsign_get_page_for_posts(){
    // Get post top page by setting display page.
    $page_for_posts['post_top_id'] = get_option('page_for_posts');

    // Set use post top page flag.
    $page_for_posts['post_top_use'] = ( isset($page_for_posts['post_top_id']) && $page_for_posts['post_top_id'] ) ? true : false ;

    // When use post top page that get post top page name.tsign_
    $page_for_posts['post_top_name'] = ( $page_for_posts['post_top_use'] ) ? get_the_title( $page_for_posts['post_top_id'] ) : '';

    return $page_for_posts;
}

/*-------------------------------------------*/
/*  Chack post type info
/*-------------------------------------------*/
function tsign_get_post_type(){
    // Check use post top page
    $page_for_posts = tsign_get_page_for_posts();

    // Get post type slug
    /*-------------------------------------------*/
    $postType['slug'] = get_post_type();
    if ( !$postType['slug'] ) {
      global $wp_query;
      if ($wp_query->query_vars['post_type']) {
          $postType['slug'] = $wp_query->query_vars['post_type'];
      } elseif(is_tax()) {
        // Case of tax archive and no posts
        $taxonomy = get_queried_object()->taxonomy;
        $postType['slug'] = get_taxonomy( $taxonomy )->object_type[0];
      } elseif( is_home() && $page_for_posts['post_top_use'] ){
        // This is necessary that when no posts.
        $postType['slug'] = 'post';
      }
    }

    // Get custom post type name
    /*-------------------------------------------*/
    $post_type_object = get_post_type_object($postType['slug']);
    if($post_type_object){
        if ( $page_for_posts['post_top_use'] && $postType['slug'] == 'post' ){
            $postType['name'] = esc_html( get_the_title($page_for_posts['post_top_id']) );
        } else {
            $postType['name'] = esc_html($post_type_object->labels->name);
        }
    }

    // Get custom post type archive url
    /*-------------------------------------------*/
    if ( $page_for_posts['post_top_use'] && $postType['slug'] == 'post' ){
        $postType['url'] = get_the_permalink($page_for_posts['post_top_id']);
    } else {
        $postType['url'] = home_url().'/?post_type='.$postType['slug'];
    }

    return $postType;
}
