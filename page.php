<?php get_header();  ?>

<?php get_template_part('inc/section/inc_mainVisual'); ?>


<div class="wrap wrap-column">
    <main class="wrap__main wrap__main-column">
		<section class="contentSingle">
            <div class="contentSingle__wrap">
    		    <h1><?php the_title(); ?></h1>
    			<div>
    				<?php echo apply_filters('the_content',$post->post_content); ?>
    			</div>
            </div>
		</section>
    </main>
    <?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>
