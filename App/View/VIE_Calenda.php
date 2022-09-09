<?php

//--------------------------------------------------------------------------------------------------
// コンセプト
//--------------------------------------------------------------------------------------------------

function vie_reception_calenda($is_admin = ''){

    //カレンダー情報取得
    $cals = get_contact_calendar($is_admin);
?>


    <section class="container">
        <h2>撮影予約状況</h2>
        <div>
            <article>
                <?php foreach ($cals as $key => $mm) { ?>
                    <?php foreach ($cals as $key => $mm) { ?>
                        <?php
                            $dayD = new DateTime($dd['day']);
                        ?>
                        <h3><?php echo $dayD->format('Y'); ?>年<?php echo $dayD->format('n'); ?>月</h3>

                    <?php break; } ?>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>日</th>
                                    <th>月</th>
                                    <th>火</th>
                                    <th>水</th>
                                    <th>木</th>
                                    <th>金</th>
                                    <th>土</th>
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
                                                $class_day = '祝日';
                                            //日曜日
                                            } elseif($j == 0) {
                                                $class_day = '日曜日';
                                            //土曜日
                                            }elseif($j == 6){
                                                $class_day = '土曜日';
                                            //その他平日
                                            } else {
                                                $class_day = '平日';
                                            }
                                        ?>
                                            <td class="<?php echo $class_day; ?>"><?php echo $dayD->format('j'); ?><br><?php echo $status; ?></td>

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
                    </div>
                <?php } ?>
            </article>
        </div>
    </section>
<?php }
