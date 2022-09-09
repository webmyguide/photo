<?php

//--------------------------------------------------------------------------------------------------
// コンセプト
//--------------------------------------------------------------------------------------------------

function vie_concept(){
    global $setting_page;
?>

    <section class="contentCommon secConcept">
        <h2 class="titCommon secConcept__tit">CONCEPT</h2>
        <div class="contentCommon__wrap">
            <?php $thumb_concept = wp_get_attachment_image_src($setting_page['top_concept_img'],'full'); ?>
            <figure class="secConcept__figure figureCommon">
                <img src="<?php echo $thumb_concept[0]; ?>" alt="<?php echo $thumb_concept[3]; ?>" width="<?php echo $thumb_concept[1]; ?>" height="<?php echo $thumb_concept[2]; ?>" class="figureCommon__img verAlign-b"/>
            </figure>
            <p class="secConcept__appeal"><?php echo $setting_page['top_concept_title']; ?></p>
            <div class="secConcept__detail">
                <?php echo apply_filters('the_content',$setting_page['top_concept_detail']); ?>
            </div>
        <div>
    </section>


<?php } ?>
