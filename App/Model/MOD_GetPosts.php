<?php

/*-------------------------------------------*/
/*	　設定画面のPost ID
/*-------------------------------------------*/
function set_setting_ids(){
    global $int_post_id;
    global $int_setting_ids;

    //共通の設定
    $int_post_id = 9;

    $int_setting_ids = array();
    //TOPページの設定
    $int_setting_ids['top'] = 35;
    //お問い合わせページの設定
    $int_setting_ids['contact'] = 183;
    $int_setting_ids['contact_confirm'] = 488;
    $int_setting_ids['contact_thanks'] = 491;
    $int_setting_ids['contact_error'] = 492;

    //撮影予約ページの設定
    $int_setting_ids['reserve'] = 965;
    $int_setting_ids['reserve_confirm'] = 972;
    $int_setting_ids['reserve_thanks'] = 970;
    $int_setting_ids['reserve_error'] = 968;

    //会社概要・アクセスページの設定
    $int_setting_ids['company'] = 628;

    //ブログの設定
    $int_setting_ids['blog'] = 643;

    //プランの設定
    $int_setting_ids['plan'] = 797;

    //衣装の設定
    $int_setting_ids['costume'] = 931;


    // //TOPページの設定
    // $int_setting_ids['top'] = 35;

}


/*-------------------------------------------*/
/*	　設定を取得
/*-------------------------------------------*/

function get_post_setting($id = ''){
    global $int_post_id;

    //IDが空だったらint idを入れる
    if(empty($id)) $id = $int_post_id;

    //カスタムフィールドの取得
    $res = get_post_custom($id);

    //カスタムフィールドを整形
    $list = array();
    foreach ($res as $key => $value) {
        // var_dump($key);
        // var_dump($value);
        $substr_key = substr($key, 0, 1);
        //一文字目が'_'ではない場合にlistに入れる
        if($substr_key != '_'){
            $list[$key] = $value[0];
        }
    }

    return $list;
}

/*-------------------------------------------*/
/*	　固定ページリンク
/*-------------------------------------------*/
function get_link_page($target = null) {
    global $int_setting_ids;

    //$targetがなかったら何もしない
    if(empty($target)) return get_home_url();

    $target_id = $int_setting_ids[$target];

    //idがなかったら何もしない
    if(empty($target_id)) return get_home_url();

    $permalink = get_permalink($target_id);


    return $permalink;
}

/*-------------------------------------------*/
/*	　コンセプト
/*-------------------------------------------*/
function get_cf_concept() {
    global $post;
    global $setting_common;

    $post_type = $post->post_type;
    $data = array();
    if ($post_type == 'plan' && is_single()){
        $id = get_the_ID();
        $thumb_id = get_post_field('plan_concept_img',$id);
        $thumb = wp_get_attachment_image_src($thumb_id,'large');
        $data = array(
            'thumb' => $thumb,
            'title' => get_post_field('plan_concept_title',$id),
            'detail' => get_post_field('plan_concept_detail',$id),
            'is_movie' => false,
        );
    }else {
        $thumb = wp_get_attachment_image_src($setting_common['top_concept_img'],'large');
        $data = array(
            'thumb' => $thumb,
            'title' => $setting_common['top_concept_title'],
            'detail' => $setting_common['top_concept_detail'],
            'movie_id' => $setting_common['top_concept_movie'],
            'is_movie' => true,
        );
    }

    return $data;
}

/*-------------------------------------------*/
/*	スライドショー
/*-------------------------------------------*/
function get_cf_slideshow() {
    global $post;
    global $setting_common;

    $post_type = $post->post_type;
    $data = array();
    if ($post_type == 'plan' && is_single()){
        $data = array(
            'detail' => get_post_field('plan_slideshow_detail',$id),
            'movie_id' => get_post_field('plan_slideshow_movie',$id),
        );
    }else {
        $data = array(
            'detail' => $setting_common['top_slideshow_detail'],
            'movie_id' => $setting_common['top_slideshow_movie'],
        );
    }

    return $data;
}



/*-------------------------------------------*/
/*	ポイント
/*-------------------------------------------*/
function get_common_point() {
    global $post;
    global $setting_common;
    global $setting_page;

    $post_type = $post->post_type;

    $data = array();
    $data['title'] = ( $post_type == 'plan' && is_single() && !empty($setting_page['plan_point_title']) )?$setting_page['plan_point_title']: $setting_common['top_point_title'];


    for ($i=1; $i <= 5; $i++) {
        $key_common_point = 'top_point_'.$i;

        $data['list'][$i-1]['thumb'] = wp_get_attachment_image_src($setting_common[$key_common_point.'_img'],'large');
        $data['list'][$i-1]['title'] = $setting_common[$key_common_point.'_title'];
        $data['list'][$i-1]['title_en'] = $setting_common[$key_common_point.'_title_en'];
        $data['list'][$i-1]['detail'] = $setting_common[$key_common_point.'_detail'];

        $side = $setting_common[$key_common_point.'_trimming_side'];
        $vertical = $setting_common[$key_common_point.'_trimming_vertical'];

        if(!empty($side) || !empty($vertical)){
            $res_side = (!empty($side))? -50 + $side: -50;
            $res_vertical = (!empty($vertical))? -50 + $vertical: -50;
            $data['list'][$i-1]['style'] = 'style="transform: translate('.$res_side.'%, '.$res_vertical.'%);"';
        }

        if ($post_type == 'plan' && is_single()){
            $key_page_point = 'plan_point_'.$i;
            if( !empty($setting_page[$key_page_point.'_img']) )$data['list'][$i-1]['thumb'] = wp_get_attachment_image_src($setting_page[$key_page_point.'_img'],'large');
            if( !empty($setting_page[$key_page_point.'_title']) )$data['list'][$i-1]['title'] = $setting_page[$key_page_point.'_title'];
            if( !empty($setting_page[$key_page_point.'_title_en']) )$data['list'][$i-1]['title_en'] = $setting_page[$key_page_point.'_title_en'];
            if( !empty($setting_page[$key_page_point.'_detail']) )$data['list'][$i-1]['detail'] = $setting_page[$key_page_point.'_detail'];

            $page_side = $setting_page[$key_page_point.'_trimming_side'];
            $page_vertical = $setting_page[$key_page_point.'_trimming_vertical'];


            if(!empty($page_side) || !empty($page_vertical)){
                $res_side = (!empty($page_side))? -50 + $page_side: -50;
                $res_vertical = (!empty($page_vertical))? -50 + $page_vertical: -50;
                $data['list'][$i-1]['style'] = 'style="transform: translate('.$res_side.'%, '.$res_vertical.'%);"';
            }
        }

    }


    return $data;
}

/*-------------------------------------------*/
/*	ギャラリー
/*-------------------------------------------*/
function get_post_gallarey($max = '') {
    global $post;
    global $setting_common;

    if(empty($max)) $max = 12;

    $post_type = $post->post_type;
    $data = array();
    if ($post_type == 'plan' && is_single()){
        $args = array(
            'post_type' => 'gallery-list',
            'posts_per_page' => $max,
            'orderby'   => 'meta_value',
            'meta_key'   => 'gp_order',
            'order'     => 'ASC',
            'meta_query'	=> array(
        		array(
        			'key'		=> 'gp_plan',
        			'value'		=> $post->ID,
        			'compare'	=> 'LIKE',
        		),
        	)
        );
    }else {
        $args = array(
            'post_type' => 'gallery-list',
            'posts_per_page' => $max,
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
    return $res;
}

function get_count_gallarey() {
    $posts_gallarey = get_post_gallarey(-1);
    $post_count = count($posts_gallarey);
    return $post_count;
}


/*-------------------------------------------*/
/*	プラン
/*-------------------------------------------*/
function get_post_plan($max = -1) {

    $args = array(
        'post_type' => 'plan',
        'posts_per_page' => $max,
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
    );
    $res = get_posts($args);

    return $res;
}

/*-------------------------------------------*/
/*	プラン価格
/*-------------------------------------------*/
function get_cf_plan_price($id = '') {
    //IDが空だったら何もしない
    if(empty($id)) return false;


    //タイムゾーンの設定
    date_default_timezone_set('Asia/Tokyo');

    //キャンペーンの有無
    $is_campaign = get_post_field('plan_is_campaign',$id);

    //キャンペーンがある場合、表示日付か期間内かの判定
    if(!empty($is_campaign)){
        $data_disp_start = (!empty(get_post_field('plan_campaign_disp_start',$id)))? get_post_field('plan_campaign_disp_start',$id): get_post_field('plan_campaign_start',$id);
        $data_disp_end = (!empty(get_post_field('plan_campaign_disp_end',$id)))? get_post_field('plan_campaign_disp_end',$id): get_post_field('plan_campaign_end',$id);

        if ( !empty($data_disp_start) && (strtotime(date('Y-m-d H:i:s')) > strtotime($data_disp_start)) && (strtotime(date('Y-m-d H:i:s')) < strtotime($data_disp_end)) ) {
            $is_campaign = true;
        }else {
            $is_campaign = false;
        }
    }

    //注意書き
    $caution = get_post_field('plan_fee_attention',$id);


    $info_price = array();
    //キャンペーンがある場合
    if(!empty($is_campaign)){
        $caution .= get_post_field('plan_campaign_attention',$id);
        $info_price = array(
            'name' => get_post_field('plan_campaign_name',$id),
            'price' => get_post_field('plan_campaign_fee',$id),
            'price_before' => get_post_field('plan_fee',$id),
            'balloon' => get_post_field('plan_campaign_balloon',$id),
            'data_end' => get_post_field('plan_campaign_end',$id),
            'holiday' => get_post_field('plan_fee_holiday',$id),
            'caution' => $caution,
        );
    }else {
        $info_price = array(
            'price' => get_post_field('plan_fee',$id),
            'holiday' => get_post_field('plan_fee_holiday',$id),
            'caution' => $caution,
        );
    }

    //プラン内容
    $info_price['contents_1'] = get_post_field('plan_fee_contents_1',$id);
    $info_price['contents_2'] = get_post_field('plan_fee_contents_2',$id);
    $info_price['contents_3'] = get_post_field('plan_fee_contents_3',$id);
    $info_price['contents_4'] = get_post_field('plan_fee_contents_4',$id);
    $info_price['contents_5'] = get_post_field('plan_fee_contents_5',$id);
    $info_price['contents_6'] = get_post_field('plan_fee_contents_6',$id);
    $info_price['fee_movie'] = get_post_field('plan_fee_movie',$id);


    return $info_price;
}

/*-------------------------------------------*/
/*	商品代
/*-------------------------------------------*/
function get_cf_commodity_price($id = '',$key = '') {
    //IDが空だったら何もしない
    if(empty($id)) return false;
    if(empty($key)) return false;


    //タイムゾーンの設定
    date_default_timezone_set('Asia/Tokyo');

    //キャンペーンの有無
    $is_campaign = get_post_field($key.'_is_campaign',$id);

    //キャンペーンがある場合、表示日付か期間内かの判定
    if(!empty($is_campaign)){
        $data_disp_start = (!empty(get_post_field($key.'_campaign_disp_start',$id)))? get_post_field($key.'_campaign_disp_start',$id): get_post_field($key.'_campaign_start',$id);
        $data_disp_end = (!empty(get_post_field($key.'_campaign_disp_end',$id)))? get_post_field($key.'_campaign_disp_end',$id): get_post_field($key.'_campaign_end',$id);

        if ( !empty($data_disp_start) && (strtotime(date('Y-m-d H:i:s')) > strtotime($data_disp_start)) && (strtotime(date('Y-m-d H:i:s')) < strtotime($data_disp_end)) ) {
            $is_campaign = true;
        }else {
            $is_campaign = false;
        }
    }

    $info_price = array();
    //キャンペーンがある場合
    if(!empty($is_campaign)){
        $info_price = array(
            'name' => get_post_field($key.'_campaign_name',$id),
            'price' => get_post_field($key.'_campaign_fee',$id),
            'price_before' => get_post_field($key.'_fee',$id),
            'balloon' => get_post_field($key.'_campaign_balloon',$id),
            'data_end' => get_post_field($key.'_campaign_end',$id),
            'fee_holiday' => get_post_field($key.'_fee_holiday',$id),
        );
    }else {
        $info_price = array(
            'price' => get_post_field($key.'_fee',$id),
            'fee_holiday' => get_post_field($key.'_fee_holiday',$id),
        );
    }


    return $info_price;
}


/*-------------------------------------------*/
/*	口コミ
/*-------------------------------------------*/
function get_post_review($max = 3) {
    global $post;
    global $setting_common;

    $post_type = $post->post_type;
    $data = array();
    if ($post_type == 'plan' && is_single()){
        $args = array(
            'post_type' => 'review-list',
            'posts_per_page' => $max,
            'orderby'   => 'meta_value',
            'meta_key'   => 'gp_order',
            'order'     => 'ASC',
            'meta_query'	=> array(
        		array(
        			'key'		=> 'gp_plan',
        			'value'		=> $post->ID,
        			'compare'	=> 'LIKE',
        		),
        	)
        );
    }else {
        $args = array(
            'post_type' => 'review-list',
            'posts_per_page' => $max,
            'orderby'   => 'menu_order',
            'order'     => 'ASC',
        );
    }

    $res = get_posts($args);
    return $res;
}

?>
