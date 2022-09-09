<?php

/*-------------------------------------------*/
/*	　メインビュジュアルを取得
/*-------------------------------------------*/
function get_img_mv($id = ''){
    $thumbs = array();
    for ($i=1; $i <= 6; $i++) {
        $thumd_id = get_post_field('mv_img_'.$i,$id);
        if(!empty($thumd_id)){
            $thumbs[] = wp_get_attachment_image( $thumd_id, 'large', false, array( 'class' => 'contentMv__sideimg verAlign-b' ) );
        }
    }

    if(empty($thumbs)){
        global $setting_common;
        for ($i=1; $i <= 6; $i++) {
            $thumd_id = $setting_common['mv_img_'.$i];
            if(!empty($thumd_id)){
                $thumbs[] = wp_get_attachment_image( $thumd_id, 'large', false, array( 'class' => 'contentMv__sideimg verAlign-b' ) );
            }
        }

    }
    return  $thumbs;
}

/*-------------------------------------------*/
/*	　main画像を取得
/*-------------------------------------------*/
function get_img_main(){
    global $int_setting_ids;
    $thumb_ids = array();
    $thumbs = array();

    if(is_front_page() || is_home()){
        $thumb_ids[0] = get_post_field('top_mv_img_1',$int_setting_ids['top']);
        $thumb_ids[1] = get_post_field('top_mv_img_2',$int_setting_ids['top']);
        $thumb_ids[2] = get_post_field('top_mv_img_3',$int_setting_ids['top']);
    }elseif (get_post_type() === 'plan' && is_single()) {
        $id = get_the_ID();
        $thumb_ids[0] = (!empty(get_post_field('plan_mv_img_1',$id)))? get_post_field('plan_mv_img_1',$id): get_post_field('top_mv_img_1',$int_setting_ids['top']);
        $thumb_ids[1] = (!empty(get_post_field('plan_mv_img_2',$id)))? get_post_field('plan_mv_img_2',$id): get_post_field('top_mv_img_2',$int_setting_ids['top']);
        $thumb_ids[2] = (!empty(get_post_field('plan_mv_img_3',$id)))? get_post_field('plan_mv_img_3',$id): get_post_field('top_mv_img_3',$int_setting_ids['top']);
    }else {
        return false;
    }

    foreach ($thumb_ids as $value) {
        $thumbs[] = wp_get_attachment_image_src($value,'large');
    }

    return  $thumbs;
}

/*-------------------------------------------*/
/*	　アイキャッチ
/*-------------------------------------------*/
function get_thumb($id = '', $size = 'large' ,$element = '',$pitchout = ''){
    //IDがなかったら何もしない
    if(empty($id)) return false;

    if( has_post_thumbnail($id) ){
        $side = get_post_meta($id,'cf_trimming_side',true);
        $vertical = get_post_meta($id,'cf_trimming_vertical',true);

        if(!empty($side) || !empty($vertical)){
            $res_side = (!empty($side))? -50 + $side: -50;
            $res_vertical = (!empty($vertical))? -50 + $vertical: -50;
            $element['style'] = 'transform: translate('.$res_side.'%, '.$res_vertical.'%);';
        }

        if(!empty($pitchout)){
            $element['data-pitchout-src'] = get_the_post_thumbnail_url($id,'large');
        }


        return  get_the_post_thumbnail( $id, $size, $element );
    }else {
        return  wp_get_attachment_image( 695, $size,0, $element );
    }



}

/*-------------------------------------------*/
/*	　プランについて画像の取得
/*-------------------------------------------*/
function get_thumb_plan($id = '', $key = '' ,$element = ''){
    //IDがなかったら何もしない
    if(empty($id)) return false;


    $thumb_id = get_post_meta($id,$key.'_img',true);
    $side = get_post_meta($id,$key.'_trimming_side',true);
    $vertical = get_post_meta($id,$key.'_trimming_vertical',true);

    if(!empty($side) || !empty($vertical)){
        $res_side = (!empty($side))? -50 + $side: -50;
        $res_vertical = (!empty($vertical))? -50 + $vertical: -50;
        $element['style'] = 'transform: translate('.$res_side.'%, '.$res_vertical.'%);';
    }

    return  wp_get_attachment_image( $thumb_id, 'medium',0, $element );
}


?>
