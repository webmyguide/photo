<?php

/*-------------------------------------------*/
/*	　お問い合わせのフォーム
/*-------------------------------------------*/

//MW WP Formで自動改行を無効にする
function mvwpform_autop_filter() {
  if ( class_exists( 'MW_WP_Form_Admin' ) ) {
    $mw_wp_form_admin = new MW_WP_Form_Admin();
    $forms = $mw_wp_form_admin->get_forms();
    foreach ( $forms as $form ) {
      add_filter( 'mwform_content_wpautop_mw-wp-form-' . $form->ID, '__return_false' );
    }
  }
}
mvwpform_autop_filter();


function my_mwform_complete_content( $content, $Data ) {
    global $int_setting_ids;
    // var_dump('<pre>');
    // var_dump($Data);
    // var_dump('</pre>');
    $post_id = $Data->get('c_reception_id');
    $day = $Data->get('c_day_h');
    $time = $Data->get('c_time_v_h');
    $dayD = new DateTime($day);
    $day_change_3frames = get_post_meta($int_setting_ids['reserve'],'contact_change_3frames',true);
    //3枠フラグをセット
    $is_3frames = false;
    if(!empty($day_change_3frames)){
        $day_c_remaining = new DateTime($day_change_3frames);
        if($dayD >= $day_c_remaining) $is_3frames = true;
    }

    //日付のフォーマットを変更
    $post_title = date('Y年n月j日', strtotime($day));
    $meta_day = date('Ymd', strtotime($day));


    //投稿がない場合
    if(empty($post_id)) {
        //新しく投稿する
        $args_post = array(
            'post_type' => 'reservation-status',
            'post_title'    => $post_title,
            'post_content'  => '',
            'post_status'   => 'publish',
        );
        $post_id = wp_insert_post( $args_post );

        //日付をセット
        update_field( 'reservation_day', $meta_day, $post_id );
    }

    $fields = get_field_object('reservation_time',$post_id);


    if(empty($fields)) $fields = get_field_object('reservation_time',307);


    //時間のチェックのセット
    $check_time = array();
    foreach ($fields['value'] as $key => $value) {
        if($value != $time){
            $check_time[] = $value;
        }
    }
    update_field( 'reservation_time', $check_time, $post_id );

    //ステータスのセット
    if(count($check_time) > 0){
        if(!empty($is_3frames)){// 3枠フラグがある場合
            $status = 2;
        }else {
            if(in_array(3, $check_time) && (count($check_time) == 1) ){
                $status = 3;
            }else {
                $status = 2;
            }
        }
    }else {
        $status = 3;
    }


    update_field( 'reservation_status', $status, $post_id );

    //予約者の情報の処理
    $key_person = 'reservation_person_'.$time;
    $person_name = get_post_meta($post_id,$key_person.'_name',true);

    //既に予約者がいる場合
    $is_double_booking = false;
    if(!empty($person_name)){
        $key_person = 'reservation_person_99';
        $is_double_booking = true;
    }

    //予約者の情報の取得
    $mail_id = $Data->get_saved_mail_id();
    if ( $mail_id ) {
		$p_mail_id = get_post_meta( $mail_id, 'tracking_number', true );
	}
    // $day = $Data->get('c_day_h');
    $p_reservation_time = $Data->get('c_time_h');
    $p_plan = $Data->get('c_plan');
    $set_name_1 = $Data->get('c_name_1');
    $set_name_2 = $Data->get('c_name_2');
    $p_name = $set_name_1.' '.$set_name_2;
    $set_name_f_1 = $Data->get('c_name_f_1');
    $set_name_f_2 = $Data->get('c_name_f_2');
    $p_name_f = $set_name_f_1.' '.$set_name_f_2;
    $p_email = $Data->get('c_email');
    $p_tel = $Data->get('c_tel');
    $p_postal = $Data->get('c_postal');
    $p_address = $Data->get('c_address');
    $p_content = $Data->get('c_contents');
    date_default_timezone_set('Asia/Tokyo');
    $p_time = date("Y-m-d H:i:s");
    $p_medium = 1;

    //予約者の情報をインサート
    // update_field( $post_id,$key_person.'_name', $check_time, $post_id );//ID
    $group_value = array(
        'mail_id' => $p_mail_id,//お問い合わせID
        'reservation_time' => $p_reservation_time,//希望時間
        'plan' => $p_plan,//希望プラン
        'name' => $p_name,//名前
        'name_f' => $p_name_f,//フリガナ
        'email' => $p_email,//メールアドレス
        'tel' => $p_tel,//電話番号
        'postal' => $p_postal,//郵便番号
        'address' => $p_address,//住所
        'content' => $p_content,//お問い合わせ内容
        'time' => $p_time,//予約した日時
        'medium' => $p_medium,//媒体
    );
    update_field( $key_person, $group_value, $post_id );

    //ダブルブッキングだった場合
    if($is_double_booking){
        // メールを送信する
        $to = "kazokubiyori@harvests.co.jp";
        $subject = $post_title."でダブルブッキングが発生しました";      // メール件名
        $message = $post_title." ".$p_reservation_time."でダブルブッキングが発生しました。\r\n";      // メール文面
        $message .= "\r\n";
        $message .= "お問い合わせ番号：".$p_mail_id."\r\n";
        $message .= "名前：".$p_name."\r\n";
        $message .= "予約した日時：".$p_time."\r\n";
        $message .= "管理画面URL：".get_admin_url('', '/post.php?post=' .$post_id. '&action=edit', '')."\r\n";
        $headers = "From: no-reply@kazokubiyori.jp";
        mb_send_mail($to, $subject, $message, $headers);
    }


    return $content;    // コンテンツはそのまま返す
}
add_filter( 'mwform_complete_content_mw-wp-form-974', 'my_mwform_complete_content', 10, 2 );

?>
