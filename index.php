<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 single_details">
			<section class="item_details">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 class="sec_title page-header"><?php the_title(); ?></h1>
				<div class="item_details_body cf">
					<?php the_content(); ?>
				</div><!-- /.item_details_body -->
				<?php
					endwhile;
					endif;
				?>
			</section><!-- /.item_details -->
		</div><!-- /.single -->
	</div>
</div><!-- /.container -->
<?php get_footer(); ?>
