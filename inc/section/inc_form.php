<?php
    global $formSetting;

    //
    $formType = '';
    if( isset($formSetting['formType']) ){
        $formType = '-'.$formSetting['formType'];
    }

    //ステップアップフォーム有無
    $sutepForm = get_post_field('cff_stepup_enable',2);
    $sutepTopOnly = get_post_field('cff_stepup_only',2);

    if($formType && $sutepTopOnly) $sutepForm = false;



    //GETでキーワードを変える
    $title_kw = get_keyword();



  // $keyTr = $_GET['tr'];
  //
  // if(!empty($keyTr)){
  //  $page = get_post($keyTr);
  //
  //  $title_kw = '【'.$page->post_title.'の転職サイト】ランキング';
  // }
 ?>

<section class="contentForm">
    <div class="contentForm__wrap">
        <h3 class="contentForm__title"><?php echo $title_kw; ?></h3>
        <?php
          get_template_part('inc/form/inc_search');
        ?>
    </div>
</section>
