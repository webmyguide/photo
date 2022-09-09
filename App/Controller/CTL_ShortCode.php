<?php

//--------------------------------------------------------------------------------------------------
// ショートコード
//--------------------------------------------------------------------------------------------------
//content内に設定の値を表示
function sc_contact_step( $atts, $content = null ) {
    extract(shortcode_atts(array(
            'key' => '',
            'type' => 0,
            'filters' => 0,
    ), $atts));

    $current_step = $_GET['step'];

    $elements = '<ul class="pageContact__step listStep" id="input_area">';
    $class_step_1 = ( ($current_step == 1) || empty($current_step) )? 'listStep__step-on': '';
    $elements .= '<li class="listStep__step '.$class_step_1.'">入力</li>';
    $class_step_2 = ( $current_step == 2 )? 'listStep__step-on': '';
    $elements .= '<li class="listStep__step '.$class_step_2.'">確認</li>';
    $class_step_3 = ( $current_step == 3 )? 'listStep__step-on': '';
    $elements .= '<li class="listStep__step '.$class_step_3.'">送信完了</li>';
    $elements .= '</ul>';


    return $elements;
}
add_shortcode('contact_step', 'sc_contact_step');

//content内に設定の値を表示
function sc_contact_calendar( $atts, $content = null ) {
    extract(shortcode_atts(array(
            'key' => '',
            'type' => 0,
            'filters' => 0,
    ), $atts));

    $current_step = $_GET['step'];

    if( ($current_step == 1) || empty($current_step) ){
        vie_reception_calendar();
    }
}
add_shortcode('calendar', 'sc_contact_calendar');

//content内に設定の値を表示
function sc_setting_viwe( $atts, $content = null ) {
    extract(shortcode_atts(array(
            'key' => '',
            'type' => 0,
            'filters' => 0,
    ), $atts));

    if(empty($key)) return false;

    global $setting_common;
    global $setting_page;

    $res = '';
    if($type == 1){
        $res = $setting_page[$key];
    }elseif ($type == 1) {
        global $post;
        if($key == 'post_title'){
            $res = $post->post_title;
        }
    }elseif ($type == 3) {
        if($key == 'home_url'){
            $res = esc_url(home_url( '/' ));
        }
    }else {
        if($key == 'common_phone_number'){
            if($ver == 1){
                if(!empty($setting_common['common_phone_number'])) $res = '<span class="pageContact__tel">TEL&nbsp;'.$setting_common['common_phone_number'].'</span>';
            }else {
                $res = $setting_common[$key];
            }
        }else {
            $res = $setting_common[$key];
        }
    }

    if($filters)  $res = apply_filters('the_content',$res);

    return $res;
}
add_shortcode('sv', 'sc_setting_viwe');


//時間のリストを出す
function sc_form_time( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));

    $times = get_field_object('reservation_time',307);
    $form_children = '0:---,';

    foreach ( $times['choices'] as $res_key => $res_value ) {
        $res_value = str_replace('時', ':', $res_value);
        $res_value = str_replace('分', '', $res_value);
        $form_children .= $res_key.':'.$res_value.',';
    }

    $form_children = substr($form_children, 0, -1);
    $res = '[mwform_select name="c_time" class="selectBox" children="'.$form_children.'"]';
    return do_shortcode($res);
}
add_shortcode('form_time', 'sc_form_time');

//planのリストを出す
function sc_form_plan( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));


    $args = array(
        'post_type' => 'plan',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order'     => 'ASC',
    );
    $res = get_posts($args);

    $plans = '';
    $plan_value = '';
    foreach ( $res as $res_key => $res_value ) {
        $title_short = get_post_meta($res_value->ID,'plan_title_short',true);
        $title_plan = (!empty($title_short))? $title_short:$res_value->post_title;
        $title_plan = str_replace(',', '',$title_plan);
        $title_plan = str_replace('<br>', '',$title_plan);

        $plans .= $res_value->ID.':'.$title_plan.',';
        if(empty($plan_value)) $plan_value = $res_value->ID;
    }

    $plans = substr($plans, 0, -1);

    $res = '[mwform_radio name="c_plan" id="c_plan" class="radioInput" children="'.$plans.'" value="'.$plan_value.'"]';
    return do_shortcode($res);
    // return $res;
}
add_shortcode('form_plan', 'sc_form_plan');




//formの例を表示
function sc_form_ex( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'text' => '',
        'key' => '',
    ), $atts));

    if(empty($text)) return false;

    $step = $_GET['step'];

    if($step > 1) return false;

    if($key) $text .= sc_setting_viwe(array('key' => $key, ));

    $res = '<span class="boxInput__ex">'.$text.'</span>';

    return $res;
}
add_shortcode('form_ex', 'sc_form_ex');

//formのstepでclassを変える
function sc_form_text( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'text1' => '',
        'text2' => '',
        'text3' => '',
    ), $atts));

    $current_step = $_GET['step'];

    if( ($current_step == 1) || (empty($current_step)) ){
        $res = $text1;
    }elseif ($current_step == 2) {
        $res = $text2;
    }elseif ($current_step == 3) {
        $res = $text3;
    };


    return $res;
}
add_shortcode('form_text', 'sc_form_text');

//formのstepでclassを変える
function sc_form_class( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'class' => '',
        'step' => '',
    ), $atts));

    if(empty($class)) return false;

    $current_step = $_GET['step'];

    if($step != $current_step) return false;

    $res = $class;

    return $res;
}
add_shortcode('form_class', 'sc_form_class');

//formのstepでclassを変える
function sc_form_data( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'key' => '',
    ), $atts));

    global $int_setting_ids;

    $res = '';
    if($key == 'contact_change_3frames'){
        $day_change_3frames = get_post_meta($int_setting_ids['reserve'],'contact_change_3frames',true);
        if(!empty($day_change_3frames)) $day_change_3frames = date('Y/m/d', strtotime($day_change_3frames));
        $res = 'data-3frames="'.$day_change_3frames.'"';
    }
    return $res;
}
add_shortcode('form_data', 'sc_form_data');



//現在の年月を表示
function sc_now( $atts, $content = null ) {

    $now = date('Y').'年'.date('n').'月';

    return $now;
}
add_shortcode('now', 'sc_now');

//吹き出しを表示
function sc_line( $atts, $content = null ) {
    extract(shortcode_atts(array(
            'type' => 0,
    ), $atts));

    $line = '<div class="balloonLine">';
    if($type == 1){
        $line .= '<figure class="balloonLine__figure balloonLine__figure-r"><img src="'.get_template_directory_uri().'/images/thumb_balloon_02.png" width="70" height="71" class="img-r verAlign-b"/></figure>';
        $line .= '<div class="balloonLine__chatting balloonLine__chatting-r">'.$content.'</div>';
    }else {
        $line .= '<div class="balloonLine__chatting">'.$content.'</div>';
        $line .= '<figure class="balloonLine__figure"><img src="'.get_template_directory_uri().'/images/thumb_balloon_01.png" width="70" height="71" class="img-r verAlign-b"/></figure>';
    }
    $line .= '</div>';

    return $line;
}
add_shortcode('line', 'sc_line');
