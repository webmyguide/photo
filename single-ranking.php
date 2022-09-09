<?php get_header();  ?>

<?php get_template_part('inc/section/inc_mainVisual'); ?>


<div class="wrap">
    <main class="wrap__main">
        <?php
            $ranking_id = get_the_ID();
            $is_recruit = get_post_meta($ranking_id,'cf_ranking_is_recruit',true);
            if($is_recruit) get_template_part('inc/section/inc_recruit');
        ?>



        <?php
          get_template_part('inc/section/inc_ranking');
        ?>
        
        <?php
          global $formFindSite;
          $formFindSite  = array('page_ranking' => true, );
          get_template_part('inc/section/inc_howToFind');
        ?>

        <?php
          get_template_part('inc/section/inc_productList');
        ?>

        <?php
          get_template_part('inc/section/inc_articlesList');
        ?>

    </main>
</div>




<?php get_footer(); ?>
