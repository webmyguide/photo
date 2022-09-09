<?php
/*
Template Name: リンク クッションページ（固定ページ用）
* Template Post Type: page
*/

//「gclid_cookie」という名称で保存されているcookieを呼び出し
$gclid_code = $_COOKIE['gclid_cookie'];

$pid = $_GET['pid'];

//idが案件のdefを返す
if(empty($pid)) $pid = 589;


$is_asp = get_post_meta($pid,'is_asp',true);
$url = get_post_meta($pid,'product_link',true);

//広告があった場合
if(!empty($is_asp)){
    //ASP先
    $asp = get_post_meta($pid,'product_asp',true);

    if($asp == 'afb'){
        $urlParameter = '&paid=';
    }elseif($asp == 'accesstrade') {
        $urlParameter = '&add=';
    }elseif($asp == 'valleyconsulting') {
        $urlParameter = '&afad_param_1=';
    }elseif($asp == 'presco') {
        $urlParameter = '&afad_param_2=';
    }else {//felmat
        $urlParameter = '&pb=';
    }

    $url .= $urlParameter.$gclid_code;
}


//Google Tag Manager
global $int_post_id;
$gtm_id =  get_post_meta($int_post_id,'common_gtm',true);

?>

<!DOCTYPE html>
<html lang="ja">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="referrer" content="unsafe-url">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="refresh" content="1;URL=<?php echo $url; ?>">
<meta name="robots" content="noindex,nofollow" />
<title><?php echo get_the_title($pid);//案件ID ?></title>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $gtm_id;?>');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src=""https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_id;?>""
height=""0"" width=""0"" style=""display:none;visibility:hidden""></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<p>
  <?php echo get_the_title($pid);//案件ID ?>の公式サイトへ移動しています。
</p>
<p>
  ページが変わらない場合は<a href="<?php echo $url; ?>">コチラ</a>をクリックしてください。
</p>



</body>
</html>
