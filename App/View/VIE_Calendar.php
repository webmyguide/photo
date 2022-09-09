<?php

//--------------------------------------------------------------------------------------------------
// コンセプト
//--------------------------------------------------------------------------------------------------

function vie_reception_calendar($is_admin = '',$page_type = ''){
    global $int_setting_ids;

    //カレンダー情報取得
    $cals = get_contact_calendar($is_admin);
?>
    <section class="secCalendar <?php if($page_type == 'contact') echo 'secCalendar-contact';?>" id="reception_calendar" data-max="<?php echo count($cals); ?>" data-datepicker="0" data-close="<?php echo get_template_directory_uri(); ?>/images/btn_menuClose_01.svg">
        <h2 class="secCalendar__title"><?php echo ($page_type != 'contact')?'希望日を選択ください':'撮影予約状況';?><br>（10:00撮影 or 13:30撮影）</h2>
        <div class="secCalendar__panel">
            <div class="secCalendar__view">
                <?php foreach ($cals as $key => $mm) { ?>
                <article class="secCalendar__month boxCalendar">
                    <?php foreach ($mm as $key => $dd) { ?>
                        <?php
                            $dayD = new DateTime($dd['day']);
                        ?>
                        <h3 class="boxCalendar__ym"><?php echo $dayD->format('Y'); ?>年<?php echo $dayD->format('n'); ?>月</h3>

                    <?php break; } ?>



                    <table class="boxCalendar__table">
                        <thead>
                            <tr>
                                <th class="boxCalendar__th boxCalendar__th-h">日</th>
                                <th class="boxCalendar__th">月</th>
                                <th class="boxCalendar__th">火</th>
                                <th class="boxCalendar__th">水</th>
                                <th class="boxCalendar__th">木</th>
                                <th class="boxCalendar__th">金</th>
                                <th class="boxCalendar__th boxCalendar__th-s">土</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    $j = 0;
                                    $first = true;
                                ?>
                                <?php foreach ($mm as $key => $dd) { ?>
                                    <?php
                                        $dayD = new DateTime($dd['day']);
                                        $ww = $dayD->format('w');
                                        $status = '-';
                                    ?>
                                    <?php
                                        if ($first){
                                            //月の初めの開始位置を設定する
                                            for ($j = 0; $j < $ww; $j++) {
                                            //$jはこの後も使用する
                                    ?>
                                        <td></td>
                                    <?php
                                            }
                                            $first = false;
                                        }

                                        if ($dd['reception']){
                                            $status = reception_status($dd['status']);
                                        }

                                        //祝日
                                        if ($dd['hori']){
                                            $class_day = 'boxCalendar__td boxCalendar__td-h';
                                            if( empty($dd['is_post']) ) $status = '-';
                                        //日曜日
                                        } elseif($j == 0) {
                                            $class_day = 'boxCalendar__td boxCalendar__td-h';
                                            if( empty($dd['is_post']) ) $status = '-';
                                        //土曜日
                                        }elseif($j == 6){
                                            $class_day = 'boxCalendar__td boxCalendar__td-s';
                                            if( empty($dd['is_post']) ) $status = '-';
                                        //その他平日
                                        } else {
                                            $class_day = 'boxCalendar__td';
                                        }

                                        if(($status == '-') || ($status == '×')){
                                            $class_status = 'boxCalendar__status-i';
                                        }else {
                                            $class_status = ($page_type != 'contact')? 'boxCalendar__status boxCalendar__status-datepicker':'boxCalendar__status';
                                        }

                                        if( ($status == '-') || ($status == '×') ){
                                            $enable_reception = false;
                                        }else {
                                            $enable_reception = true;
                                        }


                                    ?>
                                        <td class="<?php echo $class_day; ?>" <?php if($enable_reception && ($page_type != 'contact') ) echo 'data-day="'.$dayD->format('Y/m/d').'"';?> data-time-id="<?php echo $dd['post_id']; ?>">
                                            <?php echo $dayD->format('j'); ?><br>
                                            <div class="boxCalendar__info">
                                                <span class="<?php echo $class_status; ?>"><?php echo $status; ?></span>
                                                <?php if( ($enable_reception && is_array($dd['time'])) && $dd['status'] == 2 ) { ?>
                                                    <?php
                                                        //3枠に増やす処理
                                                        $day_change_3frames = get_post_meta($int_setting_ids['reserve'],'contact_change_3frames',true);

                                                        //3枠フラグをセット
                                                        $is_3frames = false;
                                                        if(!empty($day_change_3frames)){
                                                            $day_c_remaining = new DateTime($day_change_3frames);
                                                            if($dayD >= $day_c_remaining) $is_3frames = true;
                                                        }

                                                        if(!empty($is_3frames)){
                                                            $remaining_count = count($dd['time']);
                                                        }elseif (count($dd['time']) > 1) {
                                                            $remaining_count = 1;
                                                        }else {
                                                            $remaining_count = count($dd['time']);
                                                        }
                                                     ?>
                                                    <span class="boxCalendar__remaining">残り<?php echo $remaining_count; ?>組</span>
                                                <?php } ?>
                                            </div>
                                        </td>

                                    <?php
                                        $j = $j + 1;
                                        if ($j >= 7){
                                    ?>
                                        </tr><tr>
                                    <?php
                                            $j = 0;
                                        }
                                    ?>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </article>
            <?php } ?>
            </div>
            <div class="secCalendar__btn secCalendar__btn-prev" data-btn="0" data-prev="">
                <img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_p_01.svg" alt="前の月へ" width="100" height="100" class="img-r verAlign-b" data-url="<?php echo get_template_directory_uri(); ?>/images/" data-def="btn_arrow_p_01.svg" data-off="btn_arrow_p_off_01.svg" />
            </div>
            <div class="secCalendar__btn secCalendar__btn-next" data-btn="0" data-next="">
                <img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_n_01.svg" alt="次の月へ" width="100" height="100" class="img-r verAlign-b" data-url="<?php echo get_template_directory_uri(); ?>/images/" data-def="btn_arrow_n_01.svg" data-off="btn_arrow_n_off_01.svg" />
            </div>
        </div>
    </section>
<?php }
