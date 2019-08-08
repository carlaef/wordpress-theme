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
				if (is_user_logged_in()):
					$pod = pods('legal_case', get_the_ID());
					$bg_style = 'background-image: url('.$pod->display('header_image._src').');';
				?>
				<div class="carla-legal-case-header" style="<?php echo $bg_style;?>">
					<div class="title-wrap">
						<div style="flex-grow: 1"></div>
						<h1><?php the_title(); ?></h1>
						<div class="metadata">
						<p><i class="fas fa-map-pin"></i> <?php echo $pod->display('address');?></p>
						<p><?php echo $pod->display('legal_case_status.name');?></p>
						<p><?php echo $pod->display('case_status_description');?></p>
						</div>
					</div>
					<div class="map"></div>
				</div>
				<div class="carla-legal-case-contents">
					<div class="the-content">
						<?php the_content(); ?>
					</div>
					<?php if (!empty($pod->field('timeline_entries'))):?>
						<div class="timeline">
							<h2>Timeline</h2>
							<ul>
							<?php foreach($pod->field('timeline_entries') as $entry):?>
								<ul><strong><?php echo $entry['timestamp'];?></strong>: <?php echo $entry['description'];?></ul>
							<?php endforeach; ?>
							</ul>
						</div>
					<?php endif ?>
				</div>
				<?php
				else:
					do_action( 'et_before_content' );

					the_content();

					wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
				endif;
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
