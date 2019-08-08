<?php
/*
Template Name: Legal Case
*/
get_header();

?>

<div id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
			<?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
				<div class="et_post_meta_wrapper">
				</div> <!-- .et_post_meta_wrapper -->
			<?php  } ?>

			<div class="entry-content">
				<?php
				do_action( 'et_before_content' );

				the_content();

				wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
				?>
			</div> <!-- .entry-content -->
			<div class="et_post_meta_wrapper">
				<?php
					do_action( 'et_after_post' );
				?>
			</div> <!-- .et_post_meta_wrapper -->
		</article> <!-- .et_pb_post -->

	<?php endwhile; ?>
</div> <!-- #main-content -->
<?php get_footer(); ?>
