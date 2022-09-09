<?php

//--------------------------------------------------------------------------------------------------
// ヘッダーキャッチ部分
//--------------------------------------------------------------------------------------------------

function get_header_catch(){
    global $setting_common;
    global $setting_page;
    global $int_setting_ids;
    global $post;

    $post_type = $post->post_type;
    $data = array();
    if( is_home() || is_front_page() ) {

        $data = array(
            'tit_tag' => 'h2',
            'tit_class' => 'titCommon',
            'tit_text' => 'SERVICE',
            'catch_text' => $setting_page['top_service_title'],
            'catch_text_en' => $setting_page['top_service_title_en'],
        );
    }elseif (in_array($post->ID, array($int_setting_ids['contact'],$int_setting_ids['contact_confirm'],$int_setting_ids['contact_thanks'],$int_setting_ids['contact_error']))) {
        $current_step = $_GET['step'];

        $post_contact = get_post($int_setting_ids['contact']);

        if( $current_step == 3 ){
            $data = array();
        }else {
            $data = array(
                'tit_tag' => 'h1',
                'tit_class' => 'titCommon titCommon-sl',
                'tit_text' => $post_contact->post_title,
                'catch_detail' => $post_contact->post_content,
                'btn_class' => 'pageContact__line btnContact btnContact-line',
                'btn_url' => 'https://lin.ee/'.$setting_common['common_line'],
                'btn_text' => 'お問い合わせはこちら',
                'is_deco_btn' => true,
            );
        }
    }elseif (in_array($post->ID, array($int_setting_ids['reserve'],$int_setting_ids['reserve_confirm'],$int_setting_ids['reserve_thanks'],$int_setting_ids['reserve_error']))) {
        $current_step = $_GET['step'];

        $post_contact = get_post($int_setting_ids['reserve']);

        if( $current_step == 3 ){
            $data = array();
        }else {
            $data = array(
                'tit_tag' => 'h1',
                'tit_class' => 'titCommon titCommon-sl',
                'tit_text' => $post_contact->post_title,
                'catch_detail' => $post_contact->post_content,
                'detail_class' => 'headerCatch__detail-contact',
                'btn_class' => 'pageContact__line btnContact btnContact-line',
                'btn_url' => 'https://lin.ee/'.$setting_common['common_line'],
                'btn_text' => 'お問い合わせはこちら',
                'is_deco_btn' => true,
            );
        }
    }elseif ($post_type == 'plan' && is_single()){
        $title_plan = str_replace('<br>', '',$post->post_title);
        $title_plan_en = get_post_meta($post->ID,'plan_title_en',true);
        $data = array(
            'page_text' => $title_plan,
            'page_text_en' => $title_plan_en,
            'tit_tag' => 'h2',
            'tit_class' => 'titCommon',
            'tit_text' => 'SERVICE',
            'catch_text' => $setting_page['top_service_title'],
            'catch_text_en' => $setting_page['top_service_title_en'],
        );
    }elseif ( $post_type == 'post' && is_archive() ){
        $data = array(
            'tit_tag' => 'h1',
            'tit_class' => 'titCommon titCommon-sl',
            'tit_text' => 'ブログ一覧',
        );

    }elseif ( $post_type == 'post' && is_single() ){
        $data = array(
            'tit_tag' => 'h2',
            'tit_class' => 'titCommon',
            'tit_text' => 'ブログ',
        );
    }elseif ( $post_type == 'costume-list' && is_archive() ){
        $data = array(
            'tit_tag' => 'h1',
            'tit_class' => 'titCommon',
            'tit_text' => '衣装＆小物',
        );
    }else {
        $data = array(
            'tit_tag' => 'h1',
            'tit_class' => 'titCommon titCommon-sl',
            'tit_text' => $post->post_title,
            'catch_detail' => $post->post_content,
            'detail_class' => 'headerCatch__detail',
        );
    }


    return $data;
}




?>
