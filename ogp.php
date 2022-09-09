<!-- OGP -->
<meta property="og:type" content="website">
<meta property="og:description" content="<?php echo get_meta_description(); ?>">

<?php
    global $meta_title;
    if (is_home() || is_front_page()) {
        echo '<meta property="og:title" content="'.$meta_title.'">';echo "\n";
        echo '<meta property="og:url" content="'; bloginfo('url'); echo '">';echo "\n";
    }else if (is_single()){//単一記事ページの場合
        echo '<meta property="og:title" content="'; the_title(); echo '">';echo "\n";//単一記事タイトルを表示
        echo '<meta property="og:url" content="'; the_permalink(); echo '">';echo "\n";//単一記事URLを表示
    } else {//単一記事ページページ以外の場合（アーカイブページやホームなど）
        $og_url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        echo '<meta property="og:title" content="'.$meta_title.'">';echo "\n";//「一般設定」管理画面で指定したブログのタイトルを表示
        echo '<meta property="og:url" content="'.$og_url.'">';echo "\n";//「一般設定」管理画面で指定したブログのURLを表示
    }

    if (is_single()){//単一記事ページの場合
        if (has_post_thumbnail()){//投稿にサムネイルがある場合の処理
            $image_id = get_post_thumbnail_id();
            $image = wp_get_attachment_image_src( $image_id, 'full');
            echo '<meta property="og:image" content="'.$image[0].'">';echo "\n";
        } else {//投稿にサムネイルも画像も無い場合の処理
            $image = wp_get_attachment_image_src( 695, 'full');
            echo '<meta property="og:image" content="'.$image[0].'">';echo "\n";
        }
    } else {//単一記事ページページ以外の場合（アーカイブページやホームなど）
        echo '<meta property="og:image" content="'.get_template_directory_uri().'/images/thumb_ogp_01.png">';echo "\n";
    }
?>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="ja_JP" />
<!-- <meta property="fb:admins" content="ADMIN_ID"> -->
<!-- <meta property="fb:app_id" content="APP_ID"> -->
<!-- /OGP -->
