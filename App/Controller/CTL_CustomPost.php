<?php

function create_custom_post() {

    // 予約状況管理
    register_post_type(
    	'reservation-status',
    	array(
    		'label' => '予約状況管理',
    		'hierarchical' => false,
    		'public' => false,
    		'show_ui' => true,
    		'has_archive' => true,
    		'menu_position' => 5,
            'publicly_queryable' => true,
    		'query_var' => true,
    		'rewrite' =>
			array( 'slug' => 'reservation-status' ),
			array( 'with_front' => false, ),
    '       show_in_nav_menus' => false,
			'supports' => array(
				'title',
				'custom-fields',
			)
    	)
    );

    // // 予約状況管理
    // register_post_type(
    // 	'debug-reservation',
    // 	array(
    // 		'label' => 'debug_予約状況管理',
    // 		'hierarchical' => false,
    // 		'public' => false,
    // 		'show_ui' => true,
    // 		'has_archive' => true,
    // 		'menu_position' => 5,
    //         'publicly_queryable' => true,
    // 		'query_var' => true,
    // 		'rewrite' =>
	// 		array( 'slug' => 'debug-reservation' ),
	// 		array( 'with_front' => false, ),
    // '       show_in_nav_menus' => false,
	// 		'supports' => array(
	// 			'title',
	// 			'custom-fields',
	// 		)
    // 	)
    // );


    // プラン
    register_post_type(
    	'plan',
    	array(
    		'label' => 'プラン',
    		'hierarchical' => false,
    		'public' => true,
    		'show_ui' => true,
    		'has_archive' => false,
    		'menu_position' => 5,
            'publicly_queryable' => true,
    		'query_var' => true,
            'rewrite' => array(
              'slug' => 'plan',
              'with_front' => false
            ),
    		// 'rewrite' =>
    		// 		array( 'slug' => 'plan' ),
    		// 		array( 'with_front' => false, ),
            'show_in_nav_menus' => false,
			'supports' => array(
				'title',
				// 'editor',
				'thumbnail',
				'custom-fields',
				'page-attributes'
			)
    	)
    );

    //レビュー
    register_post_type(
    	'review-list',
    	array(
    		'label' => '口コミ',
    		'hierarchical' => false,
    		'public' => false,
    		'show_ui' => true,
    		'has_archive' => true,
    		'menu_position' => 5,
            'publicly_queryable' => true,
    		'query_var' => true,
    		'rewrite' =>
    				array( 'slug' => 'review' ),
    				array( 'with_front' => true, ),
            '       show_in_nav_menus' => false,
    				'supports' => array(
    					'title',
    					'editor',
    					'thumbnail',
    					'custom-fields',
    					'page-attributes'
    				)
    	)
    );

    // 衣装
    register_post_type(
        'costume-list',
        array(
            'label' => '衣装＆小物',
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => false,
            'has_archive' => true,
            'menu_position' => 5,
            'query_var' => true,
            'rewrite' =>
                    array( 'slug' => 'costume' ),
                    array( 'with_front' => true, ),
            'show_in_nav_menus' => true,
            'supports' => array(
                'title',
                // 'editor',
                'thumbnail',
                'custom-fields',
                'page-attributes'
            )
        )
    );

    // ギャラリー
    register_post_type(
        'gallery-list',
        array(
            'label' => 'ギャラリー',
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => false,
            'has_archive' => true,
            'menu_position' => 5,
            'query_var' => true,
            'rewrite' =>
                    array( 'slug' => 'gallery-list' ),
                    array( 'with_front' => true, ),
            'show_in_nav_menus' => true,
            'supports' => array(
                'title',
                'thumbnail',
                'page-attributes'
            )
        )
    );

    /*-------------------------------------------*/
    /*	カスタムタクソノミー 追加
    /*-------------------------------------------*/
    // TOPに表示
    register_taxonomy(
    	'disp-top',
    	array('gallery-list', 'review-list'),
    	array(
    		'label' => 'TOPに表示',
    		'rewrite' => array( 'slug' => 'disp-top' ),
    		'hierarchical' => true
    	)
    );

    // 口コミカテゴリー
    register_taxonomy(
        'cat-review',
        'review-list',
        array(
            'label' => 'カテゴリー',
            'rewrite' => array( 'slug' => 'cat-review' ),
            'hierarchical' => true
        )
    );

    // 衣装カテゴリー
    register_taxonomy(
        'cat-costume',
        'costume-list',
        array(
            'label' => 'カテゴリー',
            'rewrite' => array( 'slug' => 'cat-costume' ),
            'show_admin_column' => true,
            'hierarchical' => true
        )
    );

}
add_action( 'init', 'create_custom_post' );


function na_remove_slug( $post_link, $post, $leavename ) {
    $post_type = $post->post_type;

    if ( 'plan' == $post_type ) {
        $post_link = str_replace( '/' . $post_type . '/', '/', $post_link );

        return $post_link;
    }elseif ('post' == $post_type ) {
        return home_url('/blogs/'.$post->post_name);
    }

    return $post_link;
}
add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );


function na_parse_request( $query ) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'plan', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );



function addRewriteRules($rules){
  // 書き換えたパーマリンクに対応したクエリルールを追加
  $new_rule = array(
    'blogs/([0-9]+)/?$' => 'index.php?post_type=post&p=$matches[1]'
  );
  // ルール配列に結合
  return $new_rule + $rules;
}
add_filter('rewrite_rules_array', 'addRewriteRules');
// function na_post_rewrite_rules( $post_rewrite  ) {
//     $return_rule = array();
//     foreach ( $post_rewrite as $regex => $rewrite ) {
//
//         $return_rule['blogs/' . $regex] = $rewrite;
//     }
//
//     return $return_rule;
// }
// add_action( 'pre_get_posts', 'na_post_rewrite_rules' );



// function cp_posts_rewrite($post_type, $pto){
//     global $wp_post_types;
//     if ($post_type != 'post') return;
//     $wp_post_types['post']->rewrite = array('slug' => 'blog','with_front' => true);
//     add_post_type_support('post', 'page-attributes');
// }
// add_action('registered_post_type', 'cp_posts_rewrite', 10, 2);

function post_has_archive( $args, $post_type ) {
    if ( $post_type == 'post' ) {
        $args['rewrite'] = array('slug' => 'blogs','with_front' => true);
		$args['has_archive'] = 'blogs'; //任意のスラッグ名
    }

    return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 20, 2 );

// function generate_custom_post_link($link, $post){
//   if($post->post_type === 'plan'){
//     // 投稿IDに書き換えたパーマリンク文字列を返す
//     return home_url('/news/'.$post->ID);
//   } else {
//     return $link;
//   }
// }
//
// function add_rewrite_rules($rules){
//   // 書き換えたパーマリンクに対応したクエリルールを追加
//   $new_rule = array(
//     'news/([0-9]+)/?$' => 'index.php?post_type=mynews&p=$matches[1]'
//   );
//   // ルール配列に結合
//   return $new_rule + $rules;
// }
//
// add_filter('post_type_link', 'generate_custom_post_link', 1, 2);
// add_filter('rewrite_rules_array', 'add_rewrite_rules');
