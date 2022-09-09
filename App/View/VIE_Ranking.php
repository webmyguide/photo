<?php


/*-------------------------------------------*/
/*	　ランキングリスト取得
/*-------------------------------------------*/
// function getRankingList() {
//
//
//
// var_dump($my_posts);
//
// 	$list = array(
// 		0 => array(
// 			'name' => '調剤薬局',
// 			'post_id' => '10',
// 			'class' => '',
// 		),
// 		1 => array(
// 			'name' => 'ドラッグストア',
// 			'post_id' => '10',
// 			'class' => '',
// 		),
// 		2 => array(
// 			'name' => '病　院',
// 			'post_id' => '10',
// 			'class' => '',
// 		),
// 		3 => array(
// 			'name' => '企　業',
// 			'post_id' => '10',
// 			'class' => '',
// 		),
// 	);
//
// 	return $list;
// }


/*-------------------------------------------*/
/*	　口コミの取得
/*-------------------------------------------*/
function get_reputation($reputation = null){
    //空だった場合
    if(empty($reputation)) $reputation = 30;

    $img_path = 'ico_reputation_0.png';
    if($reputation)$img_path = 'ico_reputation_'.$reputation.'.png';
    
    echo '<img src="'.get_template_directory_uri().'/images/'.$img_path.'" alt="star" width="146" height="27" class="img-r"/>';
}

?>
