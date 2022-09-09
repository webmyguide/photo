<?php

function create_taxonomy() {

    // topのランキング
    register_taxonomy(
    	'rankingtop',
    	'product',
    	array(
    		'label' => 'TOPンキング',
    		'rewrite' => array( 'slug' => 'rankingtop' ),
    		'hierarchical' => true
    	)
    );

    // サイドバナー
    register_taxonomy(
    	'sidebanner',
    	'product',
    	array(
    		'label' => 'サイドバナー',
    		'rewrite' => array( 'slug' => 'sidebanner' ),
    		'hierarchical' => true
    	)
    );

    // 地域
    register_taxonomy(
    	'taxArea',
    	'product',
    	array(
    		'label' => '地域',
    		'rewrite' => array( 'slug' => 'taxArea' ),
    		'hierarchical' => true,
        // 'show_ui' => false,
        'show_in_nav_menus' => false,
    	)
    );

    // 絞り込み
    // register_taxonomy(
    // 	'age',
    // 	'product',
    // 	array(
    // 		'label' => '絞り込み 対象年齢',
    // 		'hierarchical' => true
    // 	)
    // );
    /*-------------------------------------------*/
    /*	　投稿 カスタムタクソノミー 追加
    /*-------------------------------------------*/
    // TOPリスト
    register_taxonomy(
    	'toplist',
    	'post',
    	array(
    		'label' => 'TOPリスト',
    		'rewrite' => array( 'slug' => 'toplist' ),
    		'hierarchical' => true
    	)
    );



    // 年齢パラメータ
    // register_taxonomy(
    // 	'old',
    // 	'product',
    // 	array(
    // 		'label' => '年齢別出し分け',
    // 		'rewrite' => array( 'slug' => 'old' ),
    // 		'hierarchical' => true
    // 	)
    // );
    //
    // // トラブル
    // register_taxonomy(
    //     'trouble',
    //     'product',
    //     array(
    //         'hierarchical' => true, //カテゴリータイプの指定
    //         'rewrite' => array('slug' => ''),
    //         //ダッシュボードに表示させる名前
    //         'label' => 'トラブル',
    //         'public' => true,
    //         'show_ui' => true,
    //         // 'show_admin_column' => true,
    //         'hierarchical' => true,
    //         'supports' => array(
    //             'order',
    //         )
    //     )
    // );

}
add_action( 'init', 'create_taxonomy' );
