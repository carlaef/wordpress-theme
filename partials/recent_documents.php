<h2>New Documents</h2>
<div class="document-list">
<?
if (is_tax()) {
	$docs = new WP_Query(array('post_type' => 'document', 'tax_query' => array(array('taxonomy' => 'library_tag', 'terms' => array(get_queried_object_id())))));
} else {
	$docs = new WP_Query(array('post_type' => 'document'));
}
while ($docs->have_posts()) {
	$docs->the_post();
	get_template_part('partials/document_card');
}
?>
</div>
