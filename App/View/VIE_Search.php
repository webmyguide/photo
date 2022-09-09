<?php


/*-------------------------------------------*/
/*	　検索質問のデータ
/*-------------------------------------------*/
function getFormInfo() {

  // $topType = get_transient( 'topPageType');

  //int
    // $keyAge = 'old22';
    // $keyGakureki = 'daigaku';
    // $keyZyoukyou = 'shain';
    // $keyNenshuu = 0;
    // $keyJob = 'sonota,hoiku,kaigo';
    // $keySex = 'lady';
    // $keyGyoukai = 'mikeiken';


	//$_GETを取得
	$key1 = ( isset($_GET[ 'sk1' ]) )? $_GET[ 'sk1' ]: 12;
	$key2 = ( isset($_GET[ 'sk2' ]) )? $_GET[ 'sk2' ]: 22;
	$key3 = ( isset($_GET[ 'sk3' ]) )?  $_GET[ 'sk3' ]: 32;
	$key4 = ( isset($_GET[ 'sk4' ]) )? $_GET[ 'sk4' ]: 42;
	$key5 = ( isset($_GET[ 'sk5' ]) )? $_GET[ 'sk5' ]: 52;
    // if ($_GET[ 'job' ]) $keyJob = $_GET[ 'job' ];
    // if ($_GET[ 'sex' ]) $keySex = $_GET[ 'sex' ];
	// if ($_GET[ 'gyoukai' ]) $keyGyoukai = $_GET[ 'gyoukai' ];

  // //学歴が高卒の場合未経験に変更
  // if($keyGakureki == 'kousotsu') $keyGyoukai = 'mikeiken';
  // //学歴が大卒以外の場合
  // if($keyGakureki != 'daigaku') $keyGakureki = 'kousotsu,senmon,sonota';
  // //状況がフリーターの場合
  // if( ($keyZyoukyou == 'freeter') || ($keyZyoukyou == 'nisotsu') ) $keyZyoukyou = 'freeter,nisotsu';


    $list[] = array(
        'name' => 'sk1',
		'title' => '在職中？',
        'title_s' => '在職中',
        'class' => 'radioInput',
        'type' => 'radio',
        'key' => $key1,
        'inputList' => array(
            0 => array(
            'value' => '11',
            'label' => '--選択して下さい--',
            'def_flg' => true,
            ),
            1 => array(
            'value' => '12',
            'label' => 'はい',
            ),
            2 => array(
            'value' => '13',
            'label' => 'いいえ',
            ),
        ),
    );

    $list[] = array(
        'name' => 'sk2',
		'title' => 'お住まいは？',
        'title_s' => 'お住まい',
        'class' => 'radioInput',
        'type' => 'radio',
        'key' => $key2,
        'inputList' => array(
            0 => array(
            'value' => '21',
            'label' => '--選択して下さい--',
            'def_flg' => true,
            ),
            1 => array(
            'value' => '22',
            'label' => '関東',
            ),
            2 => array(
            'value' => '23',
            'label' => '関西',
            ),
			3 => array(
			'value' => '24',
			'label' => '東海',
			),
			4 => array(
			'value' => '25',
			'label' => 'その他',
			),
        ),
    );

    $list[] = array(
        'name' => 'sk3',
		'title' => '保有資格は？',
        'title_s' => '保有資格',
        'class' => 'checkboxInput',
        'type' => 'checkbox',
        'key' => $key3,
        'inputList' => array(
            0 => array(
            'value' => '31',
            'label' => '--選択して下さい--',
            'def_flg' => true,
            ),
            1 => array(
            'value' => '32',
            'label' => '正看護師',
            'class' => 'checkboxInput__5em',
            ),
            2 => array(
            'value' => '33',
            'label' => '准看護師',
            // 'class' => 'checkboxInput__5em',
            ),
            3 => array(
            'value' => '34',
			'label' => '助産師',
            // 'class' => 'checkboxInput__4em',
            ),
			4 => array(
			'value' => '36',
			'label' => '保健師',
			// 'class' => 'checkboxInput__4em',
			),
            5 => array(
            'value' => '35',
			'label' => '取得見込み',
            ),
        ),
    );

    $list[] = array(
        'name' => 'sk4',
		'title' => '働き方は？',
        'title_s' => '働き方',
        'class' => 'checkboxInput',
        'type' => 'checkbox',
        'key' => $key4,
        'inputList' => array(
            0 => array(
	            'value' => '41',
	            'label' => '--選択して下さい--',
	            'def_flg' => true,
            ),
            1 => array(
	            'value' => '42',
	            'label' => '常勤',
            ),
            2 => array(
	            'value' => '43',
	            'label' => '非常勤（パート・バイト）',
            ),
            3 => array(
	            'value' => '44',
	            'label' => '派遣',
				'class' => '',
            ),
			4 => array(
				'value' => '45',
				'label' => '未定',
			),
        ),
    );

    $list[] = array(
        'name' => 'sk5',
		'title' => 'いつ頃から働きたい？',
        'title_s' => '転職時期',
        'class' => 'radioInput',
        'type' => 'radio',
        'key' => $key5,
        'inputList' => array(
            0 => array(
	            'value' => '51',
	            'label' => '--選択して下さい--',
	            'def_flg' => true,
            ),
            1 => array(
	            'value' => '52',
	            'label' => '良い求人があればいつでも',
				'class_s' => 'listFormStepup__radio-xs',
            ),
            2 => array(
	            'value' => '53',
	            'label' => '3ヶ月以内',
            ),
            3 => array(
	            'value' => '54',
	            'label' => '6ヶ月以内',
            ),
			4 => array(
				'value' => '55',
				'label' => '未定',
			),
        ),
    );

    return $list;
}




?>
