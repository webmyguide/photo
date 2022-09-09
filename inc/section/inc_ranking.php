<?php
    global $int_post_id;

    //診断ツールの設定
    global $setting_diagnosis;
    $setting_diagnosis['flg_rankng'] = true;

    //タイトル
    $ranking_title = array(
        'path_sp' => get_template_directory_uri().'/images/tit_ranking_01.png',
        'width_sp' => '726',
        'height_sp' => '111',
        'path_pc' =>  get_template_directory_uri().'/images/tit_ranking_pc_01.png',
        'width_pc' => '1014',
        'height_pc' => '97',
        'alt' => '総合ランキング',
    );

    $img_title_sp = wp_get_attachment_image_src(get_post_field('cf_ranking_title_sp',$post->ID),'full');
    $img_title_pc = wp_get_attachment_image_src(get_post_field('cf_ranking_title_pc',$post->ID),'full');
    if($img_title_sp){
        $ranking_title['path_sp'] = $img_title_sp[0];
        $ranking_title['width_sp'] = $img_title_sp[1];
        $ranking_title['height_sp'] = $img_title_sp[2];
        $ranking_title['alt'] = $img_title_sp[3];
    }
    if($img_title_pc){
        $ranking_title['path_pc'] = $img_title_pc[0];
        $ranking_title['width_pc'] = $img_title_pc[1];
        $ranking_title['height_pc'] = $img_title_pc[2];
        $ranking_title['alt'] = $img_title_pc[3];
    }

    //テンプレートpage-indexか判定
    $temp_top = get_temp_top();

    if( is_home() || is_front_page() ) {
        $ranking_max = 5;
        $ranking_id = $post->ID;
        $is_diagnosis = true;
    }elseif ($temp_top) {
        $ranking_max = 5;
        $is_ranking = get_post_meta($post->ID,'cf_ranking_1',true);
        $ranking_id = ($is_ranking)?$post->ID:$int_post_id;
        $is_diagnosis = true;
    }else {
        $ranking_max = 20;
        $ranking_id = $post->ID;
        $is_diagnosis = false;
    }

    //ランキング情報
    $ranking_posts = get_ranking_posts($ranking_id,$ranking_max);
 ?>



<section class="contentRanking">
    <h2 class="contentRanking__title">
        <img src="<?php echo $ranking_title['path_sp'];?>" alt="<?php echo $ranking_title['alt'];?>" width="<?php echo $ranking_title['width_sp'];?>" height="<?php echo $ranking_title['height_sp'];?>" class="img-r disp-sp"/>
        <img src="<?php echo $ranking_title['path_pc'];?>" alt="<?php echo $ranking_title['alt'];?>" width="<?php echo $ranking_title['width_pc'];?>" height="<?php echo $ranking_title['height_pc'];?>" class="img-r disp-pc"/>
    </h2>

    <div>
        <?php
            $ranking_setting = array('ranking' => 1, );
            foreach ($ranking_posts as $key => $ranking) {
                view_product($ranking,$ranking_setting);

                //診断表示
                if($is_diagnosis && ($ranking_setting['ranking'] == 3)){
                    get_template_part('inc/section/inc_diagnosis');
                }

                $ranking_setting['ranking']++;
             }
         ?>
    </div>
</section>
