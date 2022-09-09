<?php


/*-------------------------------------------*/
/*	クイックタグボタン
/*-------------------------------------------*/
//
// /**
//  * TinyMCEの初期化配列を作成する
//  * @param array $initArray
//  * @return array
//  */
// function ctl_tinymce($initArray) {
//      //選択できるブロック要素を変更
//      //スタイリング用クラス
//      $style_formats = array(
//            array(
//                 'title' => 'サクセス',
//                 'block' => 'p',
//                 'classes' => 'message success'
//            ),
//            array(
//                 'title' => '注意',
//                 'block' => 'p',
//                 'classes' => 'message warning'
//            ),
//            array(
//                 'title' => '注意書き',
//                 'inline' => 'span',
//                 'classes' => 'alert'
//            )
//      );
//      $initArray['style_formats'] = json_encode($style_formats);
//      return $initArray;
// }
// //TMAより後に実行されるように、10000番ぐらいにフック登録
// add_filter('tiny_mce_before_init', 'ctl_tinymce', 10000);
//
// //TinyMCEにスタイルセレクトボックスを追加
// //https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
// if ( !function_exists( 'add_styles_to_tinymce_buttons' ) ):
// function add_styles_to_tinymce_buttons($buttons) {
//   //見出しなどが入っているセレクトボックスを取り出す
//   $temp = array_shift($buttons);
//   //先頭にスタイルセレクトボックスを追加
//   array_unshift($buttons, 'styleselect');
//   //先頭に見出しのセレクトボックスを追加
//   array_unshift($buttons, $temp);
//
//   return $buttons;
// }
// endif;
// add_filter('mce_buttons_2','add_styles_to_tinymce_buttons');
// /**
//  * オリジナルのボタンを登録する
//  * @param array $buttons
//  * @return array
//  */
// function _my_register_button($buttons)
// {
//     array_unshift($buttons, "mybutton", "separator");
//     return $buttons;
// }
// //mce_button_の数字は1〜3で好きな値に
// add_filter('mce_buttons_3', '_my_register_button');
//
// /**
//  * TinyMCE用のプラグインを登録する
//  * @param array $plugin_array
//  * @return array
//  */
// function _my_mce_plugin($plugin_array)
// {
//     // $plugin_array['mybutton'] = '../url/to/plugin/directory/editor_plugin.js';
//     return $plugin_array;
// }
// add_filter("mce_external_plugins", "_my_mce_plugin", 100);
