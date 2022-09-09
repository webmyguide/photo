<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 cat_archive">
			<h1 class="page-header"><?php echo single_cat_title(); ?></h1>
			<section class="item_details">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2 class="item_title">
					<a href="<?php echo get_permalink(); ?>"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><?php the_title(); ?></a>
				</h2>
				<?php
					endwhile;
					endif;
				?>
			</section><!-- /.item_details -->
		</div><!-- /.single -->
	</div>
</div><!-- /.container -->
<?php get_footer(); ?>
