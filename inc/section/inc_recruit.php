<?php

    //求人情報
    $list_recruit = array();
    for ($i=1; $i <= 3; $i++) {
        //タブの設定
        $tab_name = '';
        $tab_name = get_post_meta($post->ID,'cf_ranking_tab_name_'.$i,true);
        $ranking_post_id = get_post_meta($post->ID,'cf_ranking_post_id_'.$i,true);
        if(empty($tab_name)) {
            $tab_name = get_post_field('post_title',$ranking_post_id);
        }
        $list_recruit[$i-1]['tab'] =  $tab_name;
        $list_recruit[$i-1]['id'] =  $ranking_post_id;

        //求人例
        $list_ex = array();
        for ($j=1; $j <= 4; $j++) {
            $thumb_id = get_post_meta($post->ID,'cf_ranking_ex_'.$i.'_'.$j.'_thumb',true);
            $thumb = wp_get_attachment_image_src($thumb_id,'full');

            $list_ex[$j-1]['thumb'] = $thumb[0];
            $list_ex[$j-1]['thumb_w'] = $thumb[1];
            $list_ex[$j-1]['thumb_h'] = $thumb[2];
            $list_ex[$j-1]['thumb_alt'] = $thumb[3];
            $list_ex[$j-1]['item_1'] = get_post_meta($post->ID,'cf_ranking_ex_'.$i.'_'.$j.'_item_1',true);
            $list_ex[$j-1]['item_2'] = get_post_meta($post->ID,'cf_ranking_ex_'.$i.'_'.$j.'_item_2',true);
            $list_ex[$j-1]['item_3'] = get_post_meta($post->ID,'cf_ranking_ex_'.$i.'_'.$j.'_item_3',true);
            $list_ex[$j-1]['item_4'] = get_post_meta($post->ID,'cf_ranking_ex_'.$i.'_'.$j.'_item_4',true);
        }
        $list_recruit[$i-1]['list'] =  $list_ex;
    }
 ?>


<section class="contentRecruit">
    <div class="contentRecruit__wrap">
        <ul class="tabRecruit" data-tab="recruit" data-tab-class="tabRecruit__item">
            <?php foreach ($list_recruit as $key_tab => $tab){ ?>
                <li class="tabRecruit__item <?php if($key_tab == 0) echo 'tabRecruit__item-current'; ?>" data-tab-select="<?php echo $key_tab; ?>"><?php echo $tab['tab']; ?></li>
            <?php } ?>
            <li class="tabRecruit__item" data-tab-select="3">絞り込み検索</li>
        </ul>
        <div class="boxRecruit" data-panel="recruit" data-panel-class="boxRecruit__panel">
            <?php foreach ($list_recruit as $key_panel =>  $list){ ?>
                <?php $official_url = get_cushion_url($list['id']); ?>
                <div class="boxRecruit__panel <?php if($key_panel == 0) echo 'boxRecruit__panel-current'; ?>">
                    <ul class="listRecruit">
                        <?php foreach ($list['list'] as $recruit){ ?>
                            <li class="listRecruit__item">
                                <figure class="listRecruit__thumb">
                                    <img src="<?php echo $recruit['thumb']; ?>" alt="<?php echo $recruit['thumb_alt']; ?>" width="<?php echo $recruit['thumb_w']; ?>" height="<?php echo $recruit['thumb_h']; ?>" class="img-r verAlign-b"/>
                                </figure>
                                <div class="listRecruit__detail">
                                    <div class="listRecruit__data">
                                        【勤務地】<?php echo $recruit['item_1']; ?><br>
                                        【雇用形態】<?php echo $recruit['item_2']; ?><br>
                                        【給与】<?php echo $recruit['item_3']; ?><br>
                                        【休日】<?php echo $recruit['item_4']; ?><br>
                                    </div>
                                    <div class="txtAli-r">
                                        <a href="<?php echo $official_url; ?>" class="btnSub btnDetail btnDetail-recruit">詳しくはこちら</a>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="boxRecruit__panel boxRecruit__panel-search">
                <?php
                  get_template_part('inc/form/inc_search');
                ?>
            </div>
        </div>
    </div>
</section>
