<?php
if ( ( is_single() || is_page() ) && in_array( get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ), array( 'et_full_width_page', 'et_no_sidebar' ) ) ) {
	return;
}

if ( is_active_sidebar( 'library_page' ) || true ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( 'library_page' ); ?>
		<?php
			$document_terms = get_the_terms(get_the_ID(), 'library_tag');
			$terms = array();
			foreach($document_terms as $term) {
				$terms[] = $term->term_id;
			}
			$relatedQuery = new WP_Query(array(
				'post_type' => 'any',
				'tax_query' => array(array(
					'taxonomy' => 'library_tag',
					'terms' => $terms
				))
			));
			if ($relatedQuery->have_posts()):?>
				<h3>Related Library Content</h3>
			<?php
			endif;
			while($relatedQuery->have_posts()):
				$relatedQuery->the_post();
				get_template_part('partials/library-card', get_post_type());
			endwhile;
			wp_reset_postdata();
		?>
	</div> <!-- end #sidebar -->
<?php
endif;
