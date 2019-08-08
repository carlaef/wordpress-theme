<div class="document-card">
<h3><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title();?></a></h3>
<?php
$pod = pods('document', get_the_ID());
if ($pod->field('legal_case')):
	?>
	<div class="legal-case">
		<a href="/legal-cases/<?php echo $pod->display('legal_case.post_name');?>"><?php echo $pod->display('legal_case.post_title');?></a>
	</div>
	<?php
endif;
the_excerpt();
?>
<ul class="library-tag-list">
<?php
$doc_terms = get_the_terms(get_the_ID(), 'library_tag');
if ($doc_terms):
		foreach($doc_terms as $term) :?>
				<li><?php echo $term->name;?></li>
		<?php
		endforeach;
endif;
?>
</ul>
</div>
