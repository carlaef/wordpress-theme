<?php
/*
Template Name: Library Tag Index
*/
get_header();

if (is_page()) {
	$title = get_the_title();
} elseif (is_search()) {
	$title = 'CaRLA library search results';
} else {
	$title = single_term_title('', false);
}

?>

<div id="main-content">
			<div class="et_pb_section et_pb_section_regular library-banner">
				<div class="et_pb_row et_pb_row_0">
						<div class="et_pb_column et_pb_column_4_4 et_pb_column_0 et_pb_css_mix_blend_mode_passthrough et-last-child">
								<div class="et_pb_bg_layout_dark et_pb_text_align_left">
									<div class="et_pb_text_inner"><h2><?php echo $title; ?></h2></div>
								</div>
						</div>
				</div>
			</div>
			<div class="et_pb_section et_pb_section_regular">
<div class="et_pb_row library-search">
	<form action="/" method="get">
		<input type="text" name="s" value="<?php the_search_query(); ?>" />
		<button type="submit">Search</button>
		<input type="hidden" value="1" name="library_search" />
	</form>
</div>
<div class="et_pb_row">
			<?php
			if (is_tax()):
			?>
			<ul class="library-breadcrumbs">
			<li><a href="/library/">CaRLA Library</a></li>
			<?php
					$parents = get_ancestors(get_queried_object_id(), 'library_tag', 'taxonomy');
					foreach(array_reverse($parents) as $term_id) {
						$parent = get_term($term_id);
						?>
						<li><a href="<?php esc_url(get_term_link($parent, 'library_tag'));?>"><?php echo $parent->name;?></a></li>
						<?php
					}
			?>
			<li><?php echo $title;?></li>
			</ul>
			<?php
			endif;
			?>
</div>
				<div class="et_pb_row category-contents">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part('partials/library-card', get_post_type()); ?>
				<?php endwhile; ?>
				</div>
<div class="et_pb_row library-pagination">
			<?php echo paginate_links(array('type' => 'list')); ?>
</div>
			</div>
			<div class="et_pb_section et_section_regular" style="padding:0">
				<div class="et_pb_row">
					<?php get_template_part('partials/library_categories');?>
				</div>
				<div class="et_pb_row">
					<?php get_template_part('partials/recent_documents');?>
				</div>
			</div>
</div> <!-- #main-content -->

<?php get_footer(); ?>
