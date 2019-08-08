<h2>Categories</h2>
<div class="category-list">
<?php
if (is_tax()) {
	$tags = new WP_Term_Query(array('taxonomy' => 'library_tag', 'child_of' => get_queried_object_id()));
} else {
	$tags = new WP_Term_Query(array('taxonomy' => 'library_tag'));
}
foreach($tags->terms as $term) :?>
		<div class="category-card">
			<h3><a href="<?php echo get_term_link($term);?>"><?php echo $term->name;?></a></h3>
			<ul>
			<?php
				$related_pages = new WP_Query(array('post_type' => array('library_page', 'legal_case', 'document'), 'tax_query' => array(array('taxonomy' => 'library_tag', 'terms' => array($term->term_id)))));
				while($related_pages->have_posts()) {
					$related_pages->the_post();
					?>
					<li><?php echo carla_post_icon(get_the_ID());?> <a href="<?php the_permalink();?>"><?php the_title();?></a></li>
					<?php
				}
				?>
			</ul>
		</div>
<?php
endforeach;
?>
</div>
