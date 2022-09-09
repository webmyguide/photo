<?php

/*-------------------------------------------*/
/*	　カレンダー
/*-------------------------------------------*/
function get_contact_calendar($is_admin = ''){
    global $int_setting_ids;

    //タイムゾーンの設定
    date_default_timezone_set('Asia/Tokyo');

    //Control 日付作成処理
    // １ヶ月分の日付を格納
    $days = array();
    // １年分の日付を格納
    $cals = array();
    //今月の最終日を格納
    if(!empty($is_admin)){
        $lastday = date('Y-m-t', mktime(0, 0, 0, date('m') - 3, date('t'), date('Y')));
    }else {
        $lastday = date('Y-m-t');
    }

    //祝日設定処理
    $conf_horiday = true;
    if ($conf_horiday) {
        $horidays = array();
        $horiname = array();

        $pieces = japan_holiday();

        foreach ($pieces as $key => $value) {
            $horidays[] = $key;  //日付を設定
            $horiname[] = $value;  //祝日名を設定
        }
    }

    //今日の日付取得
    $current_day = date('d', mktime(0, 0, 0, 0, date('d'), 0));

    //予約開始の処理
    $reception_start_days = get_post_meta($int_setting_ids['reserve'],'contact_start_day',true);
    $start_day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $reception_start_days, date('Y')));
    $start_date = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));//開始月の初日を取得
    $enable_reception = false;


    //○○日後まで日数の処理
    $reception_end_days = get_post_meta($int_setting_ids['reserve'],'contact_max_day',true);


    if(!empty($is_admin)) $reception_days = 455;
    $end_day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $reception_end_days, date('Y')));
    $last_month = date('m', strtotime(date($end_day)));//最終月
    $last_year = ($last_month == 12)? date('Y'): date('Y') + 1;
    $last_date = date('Y-m-d', mktime(0, 0, 0, $last_month+1, 0, $last_year));//最終月の日付を取得
    //開始月の初日と最終月の日付の差分の計算
    $max_day = time_diff($start_date,$last_date);


    //予約状況の取得
    $args = array(
        'post_type' => 'reservation-status',
        'posts_per_page' => -1,
        'meta_key'  => 'reservation_day',
        'orderby'   => 'meta_value_num',
        'order'     => 'ASC',
        'meta_query' => array(
            // 'relation' => 'AND',
            array(
                'key' => 'reservation_day',
                'compare' => '>=',
                'value'   => str_replace('-', '', $start_day),
            ),
             array(
                'key'     => 'reservation_day',
                'compare' => '<=',
                'value'   => str_replace('-', '', $end_day),
            )
        ),
    );

    $res = get_posts($args);

    //予約状況の整理
    $reservations = array();
    $data_status = array();
    $before_reservation_day = '';
    foreach ($res as $value) {
        $is_post = '';
        $reservation_day = '';
        $reservation_status = '';
        $reservation_time = ''; //予約可能時間
        $meta_day = get_post_meta($value->ID,'reservation_day',true);
        $reservation_day = str_replace('-', '', $meta_day);
        // $reservation_day = get_post_meta($value->ID,'reservation_day',true);

        $reservation_status = get_post_meta($value->ID,'reservation_status',true);
        // $reservation_time = get_post_meta($value->ID,'reservation_time',true);

        $meta_time = get_field_object('reservation_time',$value->ID);
        $reservation_time = $meta_time['value'];

        if($before_reservation_day != $reservation_day){
            $reservations[] = $reservation_day;
            $is_post = (!empty($reservation_status))?1: '';
            $data_status[] = array(
                'status' => $reservation_status,
                'time' => $reservation_time,
                'is_post' => $is_post,
                'post_id' => $value->ID,
            );
        }

        $before_reservation_day = $reservation_day;
    }



    for ($i = 0; $i <= $max_day; $i++) {
        //日付を１日ずつ増やしていく mktime(hour, minute, second, month, day, year)
        if(!empty($is_admin)){
            $day = date('Y-m-d', mktime(0, 0, 0, date('m') - 3, date('1') + $i, date('Y')));
        }else {
            $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i, date('Y')));
        }

        //日付を格納する
        $days[$i]['day'] = $day;

        //祝日を設定する
        if ($conf_horiday) {
            $ind = array_search(str_replace('-', '', $day),$horidays);
            if ($ind){
                $days[$i]['hori'] = $horiname[$ind]['title'];
            } else {
                $days[$i]['hori'] = '';
            }
        } else {
            $days[$i]['hori'] = '';
        }

        //予約終了の処理
        if ( $day == $end_day){
            $enable_reception = false;
        }

        //予約開始の処理
        if ( ($day == $start_day) || $enable_reception){
            $days[$i]['reception'] = true;
            $enable_reception = true;
        }

        //ステータスの処理
        if ( $enable_reception ){

            $reservations_kye = array_search(str_replace('-', '', $day),$reservations);
            if ($reservations_kye !== false ){

                $array_time = ($data_status[$reservations_kye]['status'] == 1)? array(1,2,3,4,5): $data_status[$reservations_kye]['time'];
                $days[$i]['status'] = $data_status[$reservations_kye]['status'];
                $days[$i]['time'] = $array_time;
                $days[$i]['is_post'] = $data_status[$reservations_kye]['is_post'];
                $days[$i]['post_id'] = $data_status[$reservations_kye]['post_id'];

            } else {
                $days[$i]['status'] = 1;
                $days[$i]['time'] = array(1,2,3,4,5);
                $days[$i]['is_post'] = 0;
            }
        }

        if ($day == $lastday){
          //月末日の処理
          //次の月末日で更新する
          $target_day = date("Y-m-1", strtotime($lastday));
          $lastday = date("Y-m-t",strtotime($target_day . "+1 month"));
          //月ごとに格納する
          $cals[] = $days;
          $days = array();
        }
      }


    return $cals;
}


/*
 * JSON形式が取得できない場合に、iCal形式から取得する
 * 期間の指定などは不可
 * 前後3年分ほどが取得できる
 */
function japan_holiday() {
    // カレンダーID
    $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');

    $url = 'https://calendar.google.com/calendar/ical/'.$calendar_id.'/public/full.ics';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    if (!empty($result)) {
        $items = $sort = array();
        $start = false;
        $count = 0;
        foreach(explode("\n", $result) as $row => $line) {
            // 1行目が「BEGIN:VCALENDAR」でなければ終了
            if (0 === $row && false === stristr($line, 'BEGIN:VCALENDAR')) {
                break;
            }

            // 改行などを削除
            $line = trim($line);

            // 「BEGIN:VEVENT」なら日付データの開始
            if (false !== stristr($line, 'BEGIN:VEVENT')) {
                $start = true;
            } elseif ($start) {
                // 「END:VEVENT」なら日付データの終了
                if (false !== stristr($line, 'END:VEVENT')) {
                    $start = false;

                    // 次のデータ用にカウントを追加
                    ++$count;
                } else {
                    // 配列がなければ作成
                    if (empty($items[$count])) {
                        $items[$count] = array('date' => null, 'title' => null);
                    }

                    // 「DTSTART;～」（対象日）の処理
                    if(0 === strpos($line, 'DTSTART;VALUE')) {
                        $date = explode(':', $line);
                        $date = end($date);
                        $items[$count]['date'] = $date;
                        // ソート用の配列にセット
                        $sort[$count] = $date;
                    }

                    // 「SUMMARY:～」（名称）の処理
                    elseif(0 === strpos($line, 'SUMMARY:')) {
                        list($title) = explode('/', substr($line, 8));
                        $items[$count]['title'] = trim($title);
                    }
                }
            }
        }

        // 日付でソート
        $items = array_combine($sort, $items);
        ksort($items);

        return $items;
    }


}
/*
 * 日時の差を計算
 */
function time_diff($time_from, $time_to){
    $time_from = strtotime($time_from);
    $time_to = strtotime($time_to);

    // 日時差を秒数で取得
    $dif = $time_to - $time_from;
    // 時間単位の差
    $dif_time = date("H:i:s", $dif);
    // 日付単位の差
    $dif_days = (strtotime(date("Y-m-d", $dif)) - strtotime("1970-01-01")) / 86400;
    return $dif_days;
}

/*
 * ステータスの取得
 */
function reception_status($value = ''){
    // if(empty($value)) return false;

    switch ($value) {
        case 2:
            $status = '△';
            break;
        case 3:
            $status = '×';
            break;
        case 4:
            $status = '-';
            break;
        default:
           $status = '〇';
    }

    return $status;
}


/*
 * 時間の変更
 */
function reception_change_time($time = ''){
    if(empty($time)) return false;

    switch ($time) {
        case '10:00':
            $res_time = '9:30';
            break;
        case '10時00分':
            $res_time = '9時30分';
            break;
        case '13:30':
            $res_time = '12:30';
            break;
        case '13時30分':
            $res_time = '12時30分';
            break;
        case '14:30':
            $res_time = '14:30';
            break;
        case '14時30分':
            $res_time = '14時30分';
            break;
        default:
           $res_time = $time;
    }


    return $res_time;
}

?>
