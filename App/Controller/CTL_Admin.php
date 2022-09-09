<?php


/*-------------------------------------------*/
/*	管理画面の設定
/*-------------------------------------------*/

/*-------------------------------------------*/
/*	予約状況管理ページの表示
/*-------------------------------------------*/
function admin_columns_reservation_status($columns) {
    $columns = array(
        'admin_reservation_day' => '予約日',
        'admin_reservation_status' => 'ステータス',
        'admin_reservation_time' => '予約可能時間',
        'admin_reservation_memo' => 'メモ',
        'title' => 'タイトル',
        'date' => '日付',
    );
    return $columns;
}
function admin_sortable_reservation_status($columns) {
    $columns['admin_reservation_day'] = '予約日';
    return $columns;
}
function admin_add_reservation_status($column_name, $post_id) {

    if ( $column_name == 'admin_reservation_day' ) {
        $ntitle = '<a href="'.get_admin_url('', '/post.php?post=' .$post_id. '&action=edit', '').'" style="font-size:130%;font-weight: bold;">'.date('Y年m月d日',  strtotime(get_post_meta($post_id, 'reservation_day', true))).'</a>';
    }else if( $column_name == 'admin_reservation_status') {
        $status = get_post_meta($post_id, 'reservation_status', true);
        switch ($status) {
            case 1:
                $stitle = '〇';
                break;
            case 2:
                $stitle = '△';
                break;
            case 3:
                $stitle = '×';
                break;
            case 4:
                $stitle = ' -（予約不可：定休日など）';
                break;
            default:
                $stitle = '〇';
                break;
        }
    }else if( $column_name == 'admin_reservation_time') {
        $status = get_post_meta($post_id, 'reservation_status', true);
        $fields = get_field_objects($post_id);
        $dir_array = $fields['reservation_time']['choices'];

        if(empty($dir_array)){
            $fields = get_field_objects(303);
            $dir_array = $fields['reservation_time']['choices'];
        }

        // var_dump($dir_array);
        $ntitle = '';
        if($status == 1){
            // var_dump($dir_array);
            foreach ((array)$dir_array as $key => $value) {
                $time_lavel = str_replace('時',':', $value);
                $time_lavel = str_replace('分','', $time_lavel);
                $ntitle .= $time_lavel.' 〇<br>';
            }
        }elseif($status == 2) {
            $check = get_field('reservation_time');
            if(!empty($check)){
                $i = 1;
                foreach ((array)$dir_array as $key => $value) {
                    $time_lavel = str_replace('時',':', $value);
                    $time_lavel = str_replace('分','', $time_lavel);
                    if(in_array($i, $check)){
                        $ntitle .= $time_lavel.' 〇<br>';
                    }else {
                        $ntitle .= $time_lavel.' ×<br>';
                    }
                    $i = $i+1;
                }
            }else {
                $ntitle = '--';
            }
        }else {
            $ntitle = '--';
        }

        // $fields = get_field_objects($post_id);
        // $dir_array = $fields["reservation_time"]["choices"];
        // $check = get_field('reservation_time');
        //
        // if($check){
        //     foreach($check as $value){
        //         $stitle .= $value.': '.$dir_array[$value];
        //     }
        // }else {
        //     $stitle = '--';
        // }

    }else if( $column_name == 'admin_reservation_memo') {
        $stitle = get_post_meta($post_id, 'reservation_memo', true);
    }


    /*ない場合は「なし」を表示する*/
    if ( isset($stitle) && $stitle ) {
        echo esc_attr($stitle);
    }else if ( isset($ntitle) && $ntitle ) {
        echo $ntitle;
    }else {
        echo __('None');
    }
}

add_filter( 'manage_reservation-status_posts_columns', 'admin_columns_reservation_status' );
add_filter( 'manage_edit-reservation-status_sortable_columns', 'admin_sortable_reservation_status' );
add_action( 'manage_reservation-status_posts_custom_column', 'admin_add_reservation_status', 10, 2 );


/*-------------------------------------------*/
/*	プランページの表示
/*-------------------------------------------*/
function admin_columns_plan($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'タイトル',
        'menu_order' => '順序',
        'thumbnail' =>  __('Thumbnail'),
        'date' => '日付',
    );
    return $columns;
}
function admin_add_plan($column_name, $post_id) {

    if ( $column_name == 'menu_order' ) {
        $post = get_post($post_id);
        $stitle = $post->menu_order;
    }elseif ( $column_name == 'thumbnail') {
        $thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
    }


    /*ない場合は「なし」を表示する*/
    if ( isset($stitle) && $stitle ) {
        echo esc_attr($stitle);
    }else if ( isset($thumb) && $thumb ) {
        echo $thumb;
    }else {
        echo __('None');
    }

}
add_filter( 'manage_plan_posts_columns', 'admin_columns_plan' );
add_action( 'manage_plan_posts_custom_column', 'admin_add_plan', 10, 2 );


/*-------------------------------------------*/
/*	レビューページの表示
/*-------------------------------------------*/
function admin_columns_review($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'タイトル',
        'select_pgae' => '選択中ページ',
        'menu_order' => '順序',
        'thumbnail' =>  __('Thumbnail'),
        'date' => '日付',
    );
    return $columns;
}
function admin_add_review($column_name, $post_id) {

    if ( $column_name == 'menu_order' ) {
        $post = get_post($post_id);
        $stitle = $post->menu_order;
    }elseif ( $column_name == 'select_pgae') {
        $ntitle = '';
        $posts_plan = get_post_field('gp_plan',$post_id);
        $is_top = get_the_terms($post->ID,'disp-top');
        if(empty($terms[0])) $ntitle .= '・TOPページ<br>';
        if(!empty($posts_plan)){
            foreach ($posts_plan as $value) {
                $ntitle .= '・'.get_the_title($value).'<br>';
            }
        }

    }elseif ( $column_name == 'thumbnail') {
        $thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
    }


    /*ない場合は「なし」を表示する*/
    if ( isset($stitle) && $stitle ) {
        echo esc_attr($stitle);
    }else if ( isset($ntitle) && $ntitle ) {
        echo $ntitle;
    }else if ( isset($thumb) && $thumb ) {
        echo $thumb;
    }else {
        echo __('None');
    }

}
add_filter( 'manage_review-list_posts_columns', 'admin_columns_review' );
add_action( 'manage_review-list_posts_custom_column', 'admin_add_review', 10, 2 );


/*-------------------------------------------*/
/*	ギャラリーページの表示
/*-------------------------------------------*/
function admin_columns_gallery($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'タイトル',
        'select_pgae' => '選択中ページ',
        'menu_order' => '順序',
        'thumbnail' =>  __('Thumbnail'),
        'date' => '日付',
    );
    return $columns;
}
function admin_add_gallery($column_name, $post_id) {

    if ( $column_name == 'menu_order' ) {
        $post = get_post($post_id);
        $posts_plan_order = get_post_field('gp_order',$post_id);
        $stitle = $post->menu_order;
    }elseif ( $column_name == 'select_pgae') {
        $terms = get_the_terms( $post_id, 'disp-top' );
        $ntitle = '';
        $posts_plan = get_post_field('gp_plan',$post_id);
        $is_top = get_the_terms($post->ID,'disp-top');

        if(!empty($terms[0])) $ntitle .= '・TOPページ<br>';
        if(!empty($posts_plan)){
            foreach ($posts_plan as $value) {
                $ntitle .= '・'.get_the_title($value).'<br>';
            }
        }


    }elseif ( $column_name == 'thumbnail') {
        $thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
    }


    /*ない場合は「なし」を表示する*/
    if ( isset($stitle) && $stitle ) {
        echo esc_attr($stitle);
    }else if ( isset($ntitle) && $ntitle ) {
        echo $ntitle;
    }else if ( isset($thumb) && $thumb ) {
        echo $thumb;
    }else {
        echo __('None');
    }

}
add_filter( 'manage_gallery-list_posts_columns', 'admin_columns_gallery' );
add_action( 'manage_gallery-list_posts_custom_column', 'admin_add_gallery', 10, 2 );

/*-------------------------------------------*/
/*	ギャラリーページの表示
/*-------------------------------------------*/
function admin_columns_costume($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'タイトル',
        'select_pgae' => '選択中ページ',
        'menu_order' => '順序',
        'thumbnail' =>  __('Thumbnail'),
        'date' => '日付',
    );
    return $columns;
}
function admin_add_costume($column_name, $post_id) {

    if ( $column_name == 'menu_order' ) {
        $post = get_post($post_id);
        $posts_plan_order = get_post_field('gp_order',$post_id);
        $stitle = $post->menu_order;
    }elseif ( $column_name == 'select_pgae') {
        $terms = get_the_terms( $post_id, 'cat-costume' );
        // $ntitle = '';
        // $posts_plan = get_post_field('gp_plan',$post_id);
        // $is_top = get_the_terms($post->ID,'disp-top');
        //
        // if(!empty($terms[0])) $ntitle .= '・TOPページ<br>';
        if(!empty($terms)){
            foreach ($terms as $value) {
                $ntitle .= '・'.$value->name.'<br>';
            }
        }


    }elseif ( $column_name == 'thumbnail') {
        $thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
    }


    /*ない場合は「なし」を表示する*/
    if ( isset($stitle) && $stitle ) {
        echo esc_attr($stitle);
    }else if ( isset($ntitle) && $ntitle ) {
        echo $ntitle;
    }else if ( isset($thumb) && $thumb ) {
        echo $thumb;
    }else {
        echo __('None');
    }

}
add_filter( 'manage_costume-list_posts_columns', 'admin_columns_costume' );
add_action( 'manage_costume-list_posts_custom_column', 'admin_add_costume', 10, 2 );

/*-------------------------------------------*/
/*	ソート機能共通
/*-------------------------------------------*/

function admin_column_orderby_custom( $vars ) {
    if ( isset( $vars['orderby'] ) && '予約日' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'reservation_day',
            'orderby' => 'meta_value'
        ));

    }
    return $vars;
}
add_filter( 'request', 'admin_column_orderby_custom' );









add_action('admin_notices', 'current_notices' );
function current_notices(){
	global $post_type;
	if($post_type == 'reservation-status'){
        $args = array(
            'post_type' => 'reservation-status',
            'posts_per_page' => -1,
            'meta_key'  => 'reservation_day',
            'orderby'   => 'meta_value_num',
            'order'     => 'ASC',
        );
        $res = get_posts($args);

        $error_mess = '';
        $before_reservation_day = '';
        foreach ($res as $value) {
            $reservation_day = get_post_meta($value->ID,'reservation_day',true);

            if($before_reservation_day == $reservation_day){
                $error_mess .= '<p>「'.date('Y年m月d日',  strtotime($reservation_day)).'」が重複しています</p>';
            }

            $before_reservation_day = $reservation_day;
        }

        if(!empty($error_mess)){
            echo '<div class="error">'.$error_mess.'</div>';
        }
    }

}



// function aaaaaaaa(){
//     echo '管理画面なのでテストメッセージを出力。';
// }
// add_action('admin_init', 'aaaaaaaa');
