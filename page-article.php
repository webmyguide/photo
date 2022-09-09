<?php
/*
Template Name: 記事一覧
*/
?>

<?php get_header();  ?>

<?php get_template_part('inc/section/inc_mainVisual'); ?>


<div class="wrap wrap-column">
    <main class="wrap__main wrap__main-column">
		<?php
			global $setting_articles_list;

			$setting_articles_list = array(
				'is_archive' => true,
			);

			get_template_part('inc/section/inc_articlesList');
        ?>
    </main>
    <?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>
