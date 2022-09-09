<?php


/*-------------------------------------------*/
/*	　パラメータ設定
/*-------------------------------------------*/
function get_keyword( $type = null ){
    global $int_post_id;

    $url_value = 'def';
    if($type == 3){
        if( isset( $_GET[ 'contentkw' ] ) ) $url_value = $_GET[ 'contentkw' ];
        $list_keyword = get_post_meta($int_post_id,'common_kw_3',true);
        $error_text = 'コンテンツでデフォルト';
    }elseif ($type == 2) {
        if( isset( $_GET[ 'contentoptkw' ] ) ) $url_value = $_GET[ 'contentoptkw' ];
        $list_keyword = get_post_meta($int_post_id,'common_kw_2',true);
        $error_text = '薬剤師専門サイトを<br>使うだけだとブラック求人に…？';
    }else {
        if ( isset( $_GET[ 'kaiwa' ] ) ) $url_value = $_GET[ 'kaiwa' ];
        $list_keyword = get_post_meta($int_post_id,'common_kw_1',true);
        $error_text = 'あなたにピッタリの求人を探す';
    }

    //最後の「,」を削除
    $list_keyword = rtrim($list_keyword, ',');
    //json化
    $json_list_keyword = '{'.$list_keyword.'}';
    //配列化
    $ob_list_keyword = json_decode($json_list_keyword);

    //配列化に失敗したときは$error_textを入れる
    if(!$ob_list_keyword){
        return $error_text;
    }else {
        return (isset($ob_list_keyword->$url_value))?$ob_list_keyword->$url_value:$error_text;
    }
}




?>
