<?php


/*-------------------------------------------*/
/*	非同期通信
/*-------------------------------------------*/

/*-------------------------------------------*/
/*	mxの処理
/*-------------------------------------------*/
function ajax_mv(){

    $mv_id = $_POST['mv_id'];

    $mv_thums = get_img_mv($mv_id);

    $ele = '<figure class="contentMv__figure-main ani-disp-1">';
    foreach ($mv_thums as $key => $value) {
        $ele .= $value;
    }
    $ele .= '</figure>';

    echo $ele;
    die();
}

add_action( 'wp_ajax_ajax_mv', 'ajax_mv' );
add_action( 'wp_ajax_nopriv_ajax_mv', 'ajax_mv' );


/*-------------------------------------------*/
/*	予約時間の取得の処理
/*-------------------------------------------*/
function ajax_reception_time(){
    global $int_setting_ids;

    $id = (!empty($_POST['id']))?$_POST['id']:307;
    $day = $_POST['day'];
    $is_step = $_POST['step'];

    $meta_time = get_field_object('reservation_time',$id);
    $reservation_time = $meta_time['value'];
    $status = get_post_meta($id,'reservation_status',true);
    $times = (!empty(get_field_object('reservation_time',$id)))?get_field_object('reservation_time',$id):get_field_object('reservation_time',307);

    $dayD = new DateTime($day);
    $day_change_3frames = get_post_meta($int_setting_ids['reserve'],'contact_change_3frames',true);
    if(!empty($day_change_3frames)){
        $day_c_remaining = new DateTime($day_change_3frames);
        if($dayD >= $day_c_remaining){
            $frames_2 = false;
        }else {
            $frames_2 = true;
        }
    }else {
        $frames_2 = true;
    }


    $ele = '<section class="secCalendarTime" id="target_calendarTime">';
        $ele .= '<div class="secCalendarTime__box">';
            $ele .= '<h2 class="secCalendarTime__title">希望時間を選択ください</h2>';
            $ele .= '<p class="secCalendarTime__paragraph">（選択中 '.$day.'）</p>';
            $ele .= '<div class="secCalendarTime__choices">';

                $is_checked = true;
                foreach ($times['choices'] as $key => $value) {
                    if( ($frames_2 && ( $key < 3)) || !$frames_2 ){
                        $ele .= '<div class="secCalendarTime__input">';
                        $checked = '';
                        $disabled = '';

                        if(empty($frames_2)){// 4/1以降
                            $value = reception_change_time($value);
                        }

                        if($status == 1){
                            $checked = ($is_checked)? 'checked="checked"' : '';
                            $is_checked = false;
                            $label = $value.' 〇';
                        }else if(is_array($reservation_time)){
                            if(in_array($key, $reservation_time)){
                                $checked = ($is_checked)? 'checked="checked"' : '';
                                $is_checked = false;
                                $label = $value.' 〇';
                            }else {
                                $label = $value.' ×';
                                $disabled = 'disabled';
                            }
                        }else {
                            $checked = ($is_checked)? 'checked="checked"' : '';
                            $is_checked = false;
                            $label = $value.' 〇';
                        }

                        $ele .= '<input type="radio" name="c_calendar_time" value="'.$key.'" '.$checked.' '.$disabled.' id="c_calendar_time-'.$key.'" class="radioInput">';
                        $ele .= '<label for="c_calendar_time-'.$key.'">'.$label.'</label>';
                        $ele .= '</div>';
                    }
                }

            $ele .= '</div>';
            $ele .= '<div class="secCalendarTime__action"><div class="btnCommon btnCommon-sub" id="return_calendarTime" data-step="'.$is_step.'">戻る</div><div class="btnCommon" id="decision_calendarTime">決定</div></div>';
        $ele .= '</div>';
    $ele .= '</section>';

    // echo json_encode($times['choices']);
    echo $ele;
    die();
}

add_action( 'wp_ajax_ajax_reception_time', 'ajax_reception_time' );
add_action( 'wp_ajax_nopriv_ajax_reception_time', 'ajax_reception_time' );


/*-------------------------------------------*/
/*	ギャラリーのmoreの処理
/*-------------------------------------------*/
function ajax_gallarey_more(){
    global $post;
    global $setting_common;

    $paged = (int)$_POST['paged'];
    $post_count = $_POST['count'];
    $post_id = $_POST['id'];
    $group_id = $_POST['group_id'];
    $post_type = $_POST['type'];
    $term = $_POST['term'];


    if ($post_type == 'plan'){
        $args = array(
            'post_type' => 'gallery-list',
            'posts_per_page' => 12,
            'offset' => $paged*12,
            'orderby'   => 'meta_value',
            'meta_key'   => 'gp_order',
            'order'     => 'ASC',
            'meta_query'	=> array(
        		array(
        			'key'		=> 'gp_plan',
        			'value'		=> $post_id,
        			'compare'	=> 'LIKE',
        		),
        	)
        );
    }else if ($post_type == 'costume'){
        $is_sp = $_POST['is_sp'];
        $max = ($is_sp)? -1: 12;

        $args = array(
            'post_type' => 'costume-list',
            'posts_per_page' => $max,
            'offset' => $paged*12,
            // 'orderby'   => 'menu_order',
            'orderby'          => 'ID',
            'order'     => 'DESC',
            'tax_query'      => array(
              array(
                'taxonomy' => 'cat-costume',  // カスタムタクソノミー名
                'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
                'terms'    => $term // タクソノミーに属するターム名
              )
            ),
        );
    }else {
        $args = array(
            'post_type' => 'gallery-list',
            'posts_per_page' => 12,
            'offset' => $paged*12,
            // 'orderby'   => 'menu_order',
            'order'     => 'ASC',
            'tax_query'      => array(
              array(
                'taxonomy' => 'disp-top',  // カスタムタクソノミー名
                'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
                'terms'    => 'is_top' // タクソノミーに属するターム名
              )
            ),
        );

    }

    $res = get_posts($args);

    $class_name = ($post_type == 'costume')? 'listCostume': 'listGallarey';

    $ele = '';
    foreach ($res as $key => $value) {
        $ele .= '<li class="'.$class_name.'__items ani-disp-1">';
        $ele .= get_thumb( $value->ID, 'medium', array( 'class' => $class_name.'__img verAlign-b msimg', 'loading' => 'lazy', 'data-pitchout' => $key+($paged*12), 'data-group' => $group_id ),true );
        $ele .= '</li>';
    }


    echo $ele;
    die();
}

add_action( 'wp_ajax_ajax_gallarey_more', 'ajax_gallarey_more' );
add_action( 'wp_ajax_nopriv_ajax_gallarey_more', 'ajax_gallarey_more' );



// //登録者数の取得
// add_action( 'wp_ajax_ajaxNumberRegistrants', 'ajaxNumberRegistrants' );
// add_action( 'wp_ajax_nopriv_ajaxNumberRegistrants', 'ajaxNumberRegistrants' );
// //参考になったボタン
// add_action( 'wp_ajax_ajaxDoReputation', 'ajaxDoReputation' );
// add_action( 'wp_ajax_nopriv_ajaxDoReputation', 'ajaxDoReputation' );





// // 登録者数の取得
// function ajaxNumberRegistrants(){
//   global $post;
//
//   $value = get_transient( 'numberRegistrants');
//
//
//   if(empty($value)){
//     //時間の取得
//     date_default_timezone_set('Asia/Tokyo');
//     $timeH = date("H");
//
//     $value = 31;
//     //時間毎に振り分け
//     if($timeH < 8) {
//       $value = mt_rand(60, 80);
//       // $value = floor(mt_rand(1, 3));
//     }else if ($timeH < 12) {
//       $value = mt_rand(120, 150);
//     }else if ($timeH < 14) {
//       $value = mt_rand(120, 160);
//       // $value = mt_rand(1, 3);
//     }else if ($timeH < 19) {
//       $value = mt_rand(140, 199);
//     }else if ($timeH < 22) {
//       $value = mt_rand(140, 199);
//     }else {
//       $value = mt_rand(100, 120);
//     }
//     set_transient( 'numberRegistrants', $value,360 );
//   }
//
//   echo $value;
//   die();
// }

// // 参考になったボタン
// function ajaxDoReputation(){
//   global $wpdb;
//   global $post;
//   $keyId = $_POST['id'];
//   $data = $wpdb->get_results( "SELECT meta_value FROM wp_postmeta WHERE post_id = '".$keyId."' AND meta_key = 'reputation_reference'"  );
//
//
//   //保存するために配列にする
//   $set_arr = array(
//     'meta_value' => $data[0]->meta_value+1,
//   );
//
//   //DBに保存
//   if ($data[0]->meta_value) {
//     $wpdb->update( 'wp_postmeta', $set_arr, array('post_id' => $keyId,'meta_key' => 'reputation_reference',));
//   } else {
//     $set_arr['post_id'] = $post_id;
//     $set_arr['meta_key'] = 'reputation_reference';
//     $wpdb->insert( 'wp_postmeta', $set_arr);
//   }
//
//   echo $set_arr['meta_value'];
//   die();
// }
