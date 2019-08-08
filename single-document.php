<?php

get_header();

$pod = pods('document', get_the_ID());
$document_kinds = get_the_terms(get_the_ID(), 'document_kind');
$library_tags = get_the_terms(get_the_ID(), 'library_tag');
?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				/**
				 * Fires before the title and post meta on single posts.
				 *
				 * @since 3.18.8
				 */
				do_action( 'et_before_post' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
						<div class="et_post_meta_wrapper">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<?php if ($pod->field('legal_case.ID')):?>
							<p>A <a href="<?php echo get_term_link($document_kinds[0]->term_id, 'document_kind');?>"><?php echo $document_kinds[0]->name;?></a> filed in <a href="<?php echo get_post_permalink($pod->field('legal_case.ID'));?>"><i class="fas fa-gavel"></i> <?php echo $pod->display('legal_case.post_title');?></a></p>
							<?php endif;?>
							<ul>
							<?php foreach($library_tags as $library_tag):?>
								<li><i class="fas fa-tag"></i> <a href="<?php echo get_term_link($library_tag->term_id, 'library_tag');?>"><?php echo $library_tag->name;?></a></li>
							<?php endforeach;?>
							</ul>
					</div> <!-- .et_post_meta_wrapper -->

					<div class="entry-content">
					<?php
						do_action( 'et_before_content' );

						the_content();
					?>
					<object data="<?php echo $pod->display('file._src');?>" type="application/pdf" width="100%" height="100%">
					</object>
					</div> <!-- .entry-content -->
					<div class="et_post_meta_wrapper">

					<?php
					/**
					 * Fires after the post content on single posts.
					 *
					 * @since 3.18.8
					 */
					do_action( 'et_after_post' );

						if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) ) {
							comments_template( '', true );
						}
					?>
					</div> <!-- .et_post_meta_wrapper -->
				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>
			</div> <!-- #left-area -->

			<?php get_sidebar('library_page'); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();

