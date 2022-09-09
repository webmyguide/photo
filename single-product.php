<?php get_header();  ?>

<?php get_template_part('inc/section/inc_mainVisual'); ?>


<div class="wrap wrap-column">
    <main class="wrap__main wrap__main-column">
        <?php
            get_template_part('inc/section/inc_productDetail');
        ?>
    </main>
    <?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>
