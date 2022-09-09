<?php

/*-------------------------------------------*/
/*  Theme setup
/*-------------------------------------------*/
if ( ! function_exists( 'templ_theme_setup' ) ) :
function templ_theme_setup() {
    global $int_post_id;
    global $int_setting_ids;
    global $setting_common;

    //コンテンツの抑止フラグ
    global $new_content;
    $new_content = false;
    if( is_user_logged_in() ){
        $new_content = true;
    }

    //コンテンツの抑止フラグ
    global $new_contact;
    $new_contact = false;
    if( is_user_logged_in() ){
        $new_contact = true;
    }

    //ブログの抑止フラグ
    global $enable_blog;
    $enable_blog = true;
    $blogs = get_posts(array('posts_per_page' => -1,));
    if( count($blogs) < 3 ){
        $enable_blog = false;
    }


    //設定ページのIDをglobalにセット
    set_setting_ids();

    //共通の設定を取得
    $setting_common = array_merge(get_post_setting(),get_post_setting($int_setting_ids['top']));
    // if(is_front_page() || is_home()){
    //   var_dump('aaaaa');
    //   set_transient( 'topPageType', 0 );
    // }elseif (isLp() == true) {
    //   var_dump('bbbbbb');
    //   set_transient( 'topPageType', 1 );
    // }

    /*-------------------------------------------*/
    /*  manage the document title
    /*-------------------------------------------*/
    add_theme_support( 'title-tag' );
    add_filter( 'pre_get_document_title', 'my_pre_get_document_title' );

    function my_pre_get_document_title( $title ) {
        global $setting_page;
        global $int_setting_ids;
        global $meta_title;
        global $new_contact;

        $description = get_bloginfo('description');
        $name = get_bloginfo('name');
        $post_data = get_post();
        $title = $post_data->post_title;
        $post_type = $post->post_type;

        if (is_home() || is_front_page()) {
            $title = $name;
        }elseif (in_array($post_data->ID, array($int_setting_ids['contact'],$int_setting_ids['contact_confirm'],$int_setting_ids['contact_thanks'],$int_setting_ids['contact_error']))) {
            if ( get_post_meta($int_setting_ids['contact'], 'seo_title', true) && get_post_meta($int_setting_ids['contact'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['contact'], 'seo_title', true) .' | '.$name;
            }
            elseif ( get_post_meta($int_setting_ids['contact'], 'seo_title', true) && !get_post_meta($int_setting_ids['contact'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['contact'], 'seo_title', true);
            }
            else {
                $post_contact = get_post($int_setting_ids['contact']);
                $title = $post_contact->post_title.' | '.$name;
            }


            if($post_data->ID == $int_setting_ids['contact_confirm']){
                $title .= ' - 確認';
            }elseif ($post_data->ID == $int_setting_ids['contact_thanks']) {
                $title .= ' - 完了';
            }elseif ($post_data->ID == $int_setting_ids['contact_error']) {
                $title .= ' - 入力エラー';
            }

        }elseif (is_singular('plan')){

            if ( get_post_meta(get_the_ID(), 'seo_title', true) && get_post_meta(get_the_ID(), 'seo_title_add', true) ) {
                $title = get_post_meta(get_the_ID(), 'seo_title', true) .' | '.$name;
            }
            elseif ( get_post_meta(get_the_ID(), 'seo_title', true) && !get_post_meta(get_the_ID(), 'seo_title_add', true) ) {
                $title = get_post_meta(get_the_ID(), 'seo_title', true);
            }
            else {
                $title_plan = str_replace('<br>', '',$title);
                $title = $title_plan.' | '.$name.' - プラン';
            }

        }elseif ( is_post_type_archive( 'post' ) ){
            if ( get_post_meta($int_setting_ids['blog'], 'seo_title', true) && get_post_meta($int_setting_ids['blog'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['blog'], 'seo_title', true) .' | '.$name;
            }
            elseif ( get_post_meta($int_setting_ids['blog'], 'seo_title', true) && !get_post_meta($int_setting_ids['blog'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['blog'], 'seo_title', true);
            }
            else {
                $title = 'ブログ一覧 | '.$name;
            }

            $paged = get_query_var( 'paged');
    		if($paged > 1){
    			$title .= ' - ' .$paged .'ページ目';
    		}
        }elseif ( is_post_type_archive( 'costume-list' ) ) {
            if ( get_post_meta($int_setting_ids['costume'], 'seo_title', true) && get_post_meta($int_setting_ids['costume'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['costume'], 'seo_title', true) .' | '.$name;
            }
            elseif ( get_post_meta($int_setting_ids['costume'], 'seo_title', true) && !get_post_meta($int_setting_ids['costume'], 'seo_title_add', true) ) {
                $title = get_post_meta($int_setting_ids['costume'], 'seo_title', true);
            }
            else {
                $costume_object = get_post_type_object( 'costume-list' );
                $title = $costume_object->label.' | '.$name;
            }

        }else {
            if ( get_post_meta(get_the_ID(), 'seo_title', true) && get_post_meta(get_the_ID(), 'seo_title_add', true) ) {
                $title = get_post_meta(get_the_ID(), 'seo_title', true) .' | '.$name;
            }
            elseif ( get_post_meta(get_the_ID(), 'seo_title', true) && !get_post_meta(get_the_ID(), 'seo_title_add', true) ) {
                $title = get_post_meta(get_the_ID(), 'seo_title', true);
            }
            else {
                $title = $title.' | '.$name;
            }
        }

        $meta_title = $title;

        return $title;
    }
// // $template_name = basename($template, '.php');
    // var_dump(isLp());
    // define("isLp", true);



    /*-------------------------------------------*/
    /*  support for Post Thumbnails
    /*-------------------------------------------*/
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 950, 9999 );
    /*-------------------------------------------*/
    /*  This theme uses wp_nav_menu() in two locations
    /*-------------------------------------------*/
    register_nav_menus( array(
        'foot_menu'  => 'Footer Menu'
    ) );
    /*-------------------------------------------*/
    /*  content width
    /*-------------------------------------------*/
    if ( !isset( $content_width ) ){
        $content_width = 950;
    }

    //不要なコードを削除
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    //type 属性を削除
    add_theme_support( 'html5', array( 'script', 'style' ) );

    /*-------------------------------------------*/
    /*  Load css JS
    /*-------------------------------------------*/
    function templ_add_script() {
        wp_dequeue_style('wp-block-library');
			wp_enqueue_style( 'style', get_template_directory_uri() . '/css/main.css', false,'8.0.2' );

      // 共通 js
      wp_deregister_script('jquery');
      wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), '3', true);
      if( is_user_logged_in() ){
          wp_enqueue_script( 'main-dev-js', get_template_directory_uri() . '/build/main.js', array( 'jquery' ), '8.0.2', true );
      }else {
          wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '9.0.1', true );
      }


      // echo '<script type="text/javascript" src="'. get_template_directory_uri() .'/js/main.js" charset="utf-8" async="async"></script>';



    } // end templ_add_script
    add_action('wp_enqueue_scripts','templ_add_script');

    //アイキャッチ画像のsrcsetを削除
    // add_filter('wp_calculate_image_srcset_meta', '__return_null');
}
endif;
add_action( 'after_setup_theme', 'templ_theme_setup' );

//'script' type属性を削除
function remove_script_type($tag)
{
    return str_replace(array('type="text/javascript"', "type='text/javascript'"), '', $tag);
}
add_filter('script_loader_tag', 'remove_script_type');


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::
** エディタのビジュアル・テキスト切替でコード消滅を防止
::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function my_tiny_mce_before_init( $init_array ) {
    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    return $init_array;
}
add_filter( 'tiny_mce_before_init' , 'my_tiny_mce_before_init' );


/*-------------------------------------------*/
/*	　リンクにパラメーターを引き継がせる
/*-------------------------------------------*/
function add_parameter(){
$url = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
$url_array = parse_url($url);
$url_query = '?' . $url_array['query'];
return  $url_query;
}
add_shortcode('parameter', 'add_parameter');

// パラメータをcookieに保存
add_action( 'init', 'gclid_setcookie' );
function gclid_setcookie() {
  // gclid cookie保存
  if ( isset( $_GET['gclid'] ) ) {
    setcookie( 'gclid_cookie', $_GET['gclid'], time() + 3600*24*90, '/' );
  }
}

/*-------------------------------------------*/
/*	　リダイレクトを無効
/*-------------------------------------------*/
function disable_redirect_canonical( $redirect_url ) {
  if( is_404() ) {
    return false;
  }
  return $redirect_url;
}
add_filter( 'redirect_canonical', 'disable_redirect_canonical' );



/*-------------------------------------------*/
/*	　メディアにWebpをアップロードできるようにする
/*-------------------------------------------*/
function custom_mime_types( $mimes ) {
  $mimes['webp'] = 'image/webp';
  return $mimes;
}
add_filter( 'upload_mimes', 'custom_mime_types' );


/*-------------------------------------------*/
/*	　meta description設定
/*-------------------------------------------*/
function get_meta_description( ) {
    global $setting_page;
    global $int_setting_ids;

    $description = get_bloginfo('description');
    $post_data = get_post();

    $res_description = '';
    if (is_home() || is_front_page()) {
        $res_description = $description;
    }elseif (in_array($post_data->ID, array($int_setting_ids['contact'],$int_setting_ids['contact_confirm'],$int_setting_ids['contact_thanks'],$int_setting_ids['contact_error']))) {
        if ( get_post_meta($int_setting_ids['contact'], 'seo_description', true) ) {
            $res_description = get_post_meta($int_setting_ids['contact'], 'seo_description', true);
        }
        else {
            if($post_data->ID == $int_setting_ids['contact_confirm']){
                $content = get_post_field('post_content',$int_setting_ids['contact']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }elseif ($post_data->ID == $int_setting_ids['contact_thanks']) {
                $content = get_post_field('post_content',$int_setting_ids['contact']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }elseif ($post_data->ID == $int_setting_ids['contact_error']) {
                $content = get_post_field('post_content',$int_setting_ids['contact']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }
            if(empty($res_description)){
                $content = get_post_field('post_content',$int_setting_ids['contact']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }
        }
    }elseif (in_array($post_data->ID, array($int_setting_ids['reserve'],$int_setting_ids['reserve_confirm'],$int_setting_ids['reserve_thanks'],$int_setting_ids['reserve_error']))) {
        if ( get_post_meta($int_setting_ids['reserve'], 'seo_description', true) ) {
            $res_description = get_post_meta($int_setting_ids['reserve'], 'seo_description', true);
        }
        else {
            if($post_data->ID == $int_setting_ids['reserve_confirm']){
                $content = get_post_field('post_content',$int_setting_ids['reserve']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }elseif ($post_data->ID == $int_setting_ids['reserve_thanks']) {
                $content = get_post_field('post_content',$int_setting_ids['reserve']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }elseif ($post_data->ID == $int_setting_ids['reserve_error']) {
                $content = get_post_field('post_content',$int_setting_ids['reserve']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }
            if(empty($res_description)){
                $content = get_post_field('post_content',$int_setting_ids['reserve']);
                $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
                $content = mb_substr($content, 0, 400,'UTF-8');
                $res_description = wp_strip_all_tags( $content );
            }
        }

    }elseif ( is_post_type_archive( 'post' ) ){
        if ( get_post_meta($int_setting_ids['blog'], 'seo_description', true) ) {
            $res_description = get_post_meta($int_setting_ids['blog'], 'seo_description', true);
        }
        else {
            $content = get_post_field('post_content',$int_setting_ids['blog']);
            $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
            $content = mb_substr($content, 0, 400,'UTF-8');
            $res_description = wp_strip_all_tags( $content );
        }

    }elseif ( is_post_type_archive( 'costume-list' ) ) {
        if ( get_post_meta($int_setting_ids['costume'], 'seo_description', true) ) {
            $res_description = get_post_meta($int_setting_ids['costume'], 'seo_description', true);
        }
        else {
            $content = get_post_field('post_content',$int_setting_ids['costume']);
            $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
            $content = mb_substr($content, 0, 400,'UTF-8');
            $res_description = wp_strip_all_tags( $content );
        }

    }else {
        if ( get_post_meta(get_the_ID(), 'seo_description', true) ) {
            $res_description = get_post_meta(get_the_ID(), 'seo_description', true);
        }
        else {
            $content = get_post_field('post_content',get_the_ID());
            $content = str_replace(array("\r\n", "\r", "\n"), '', $content);
            $content = mb_substr($content, 0, 400,'UTF-8');
            $res_description = wp_strip_all_tags( $content );
        }
    }

    if(empty($res_description)) $res_description = $description;

    return $res_description;
}


/*-------------------------------------------*/
/*	　meta robots設定
/*-------------------------------------------*/
function get_meta_robots( ) {
    global $setting_page;
    global $int_setting_ids;
    $post_data = get_post();

    $res_robots = '';

    if (in_array($post_data->ID, array($int_setting_ids['contact'],$int_setting_ids['contact_confirm'],$int_setting_ids['contact_thanks'],$int_setting_ids['contact_error']))) {

        if( get_post_meta($int_setting_ids['contact'],'seo_robot',true)) {
            $robots = get_post_meta($int_setting_ids['contact'],'seo_robot',true);
        }
    }elseif (in_array($post_data->ID, array($int_setting_ids['reserve'],$int_setting_ids['reserve_confirm'],$int_setting_ids['reserve_thanks'],$int_setting_ids['reserve_error']))){
        if( get_post_meta($int_setting_ids['reserve'],'seo_robot',true)) {
            $robots = get_post_meta($int_setting_ids['reserve'],'seo_robot',true);
        }
    }elseif ( is_post_type_archive( 'post' ) ){
        if( get_post_meta($int_setting_ids['blog'],'seo_robot',true)) {
            $robots = get_post_meta($int_setting_ids['blog'],'seo_robot',true);
        }

    }elseif ( is_post_type_archive( 'costume-list' ) ) {
        if( get_post_meta($int_setting_ids['costume'],'seo_robot',true)) {
    		$robots = get_post_meta($int_setting_ids['costume'],'seo_robot',true);
    	}
    }else {
        if( get_post_meta(get_the_ID(),'seo_robot',true)) {
    		$robots = get_post_meta(get_the_ID(),'seo_robot',true);
    	}
    }

    if(!empty($robots)){
        foreach ($robots as $key => $value) {
            $res_robots .= $value.',';
        }
        $res_robots = rtrim($res_robots, ',');
    }


    return $res_robots;
}

//特定のプラグインを更新させない
add_filter('site_option__site_transient_update_plugins','filter_hide_update_notice');
function filter_hide_update_notice($data) {
    if (isset($data->response['mw-wp-form/mw-wp-form.php'])) {
      unset($data->response['mw-wp-form/mw-wp-form.php']);
    }
}
