<?php

//--------------------------------------------------------------------------------------------------
// コンセプト
//--------------------------------------------------------------------------------------------------

function vie_reception_calendar($is_admin = ''){

    //カレンダー情報取得
    $cals = get_contact_calendar($is_admin);
?>
    <section class="secCalendar" id="reception_calendar" data-max="<?php echo count($cals); ?>" data-datepicker="0" data-close="<?php echo get_template_directory_uri(); ?>/images/btn_menuClose_01.svg">
        <h2 class="secCalendar__title">撮影予約状況<br>（10:00撮影 or 13:30撮影）</h2>
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

                                        if($status == '-'){
                                            $class_status = 'boxCalendar__status-i';
                                        }else {
                                            $class_status = 'boxCalendar__status';
                                        }

                                        if( ($status == '-') || ($status == '×') ){
                                            $enable_reception = false;
                                        }else {
                                            $enable_reception = true;
                                        }
                                    ?>
                                        <td class="<?php echo $class_day; ?>" <?php if($enable_reception) echo 'data-day="'.$dayD->format('Y/m/d').'"';?>>
                                            <?php echo $dayD->format('j'); ?><br>
                                            <span class="<?php echo $class_status; ?>"><?php echo $status; ?></span>
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



function vie_reception_calendar($is_admin = ''){

    //カレンダー情報取得
    $cals = get_contact_calendar($is_admin);
?>
    <section class="secCalendar" id="reception_calendar" data-max="<?php echo count($cals); ?>" data-datepicker="0" data-close="<?php echo get_template_directory_uri(); ?>/images/btn_menuClose_01.svg">
        <h2 class="secCalendar__title">希望日を選択ください<br>（10:00撮影 or 13:30撮影）</h2>
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
                                            $class_status = 'boxCalendar__status boxCalendar__status-datepicker';
                                        }

                                        if( ($status == '-') || ($status == '×') ){
                                            $enable_reception = false;
                                        }else {
                                            $enable_reception = true;
                                        }
                                    ?>
                                        <td class="<?php echo $class_day; ?>" <?php if($enable_reception) echo 'data-day="'.$dayD->format('Y/m/d').'"';?> data-time-id="<?php echo $dd['post_id']; ?>">
                                            <?php echo $dayD->format('j'); ?><br>
                                            <div class="boxCalendar__info">
                                                <?php if( ($enable_reception && $dd['status'] == 1) ) { ?>
                                                    <div><span class="boxCalendar__time">AM</span>&nbsp;<span class="<?php echo $class_status; ?>">〇</span></div>
                                                    <div><span class="boxCalendar__time">PM</span>&nbsp;<span class="<?php echo $class_status; ?>">〇</span></div>
                                                <?php } else if( ($enable_reception && is_array($dd['time'])) ) { ?>
                                                    <div><span class="boxCalendar__time">AM</span>&nbsp;<span class="<?php echo $class_status; ?>"><?php echo (in_array(1, $dd['time']))? '〇': '×'; ?></span></div>
                                                    <div><span class="boxCalendar__time">PM</span>&nbsp;<span class="<?php echo $class_status; ?>"><?php echo (in_array(2, $dd['time']))? '〇': '×'; ?></span></div>
                                                <?php } else { ?>
                                                    <span class="<?php echo $class_status; ?>"><?php echo $status; ?></span>
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
