<div class="library-card library-card-<?php echo get_post_type();?> library-card-<?php the_ID();?>">
<h3><a href="<?php echo get_the_permalink();?>"><?php echo carla_post_icon().' ';echo get_the_title();?></a></h3>
<div class="metadata">
<?php
$pod = pods('document', get_the_ID());
if ($pod->field('legal_case')):
	?>
	<i class="fas fa-gavel"></i> <a href="/legal-cases/<?php echo $pod->display('legal_case.post_name');?>"><?php echo $pod->display('legal_case.post_title');?></a>
	<?php
endif;
$pod = pods('legal_case', get_the_ID());
if ($pod->field('case_status')):
	?>
	<?php echo $pod->display('case_status.name');?>
	<?php
endif;
?>
</div>
<?php the_excerpt(); ?>
<ul class="library-tag-list">
<?php
$doc_terms = get_the_terms(get_the_ID(), 'library_tag');
if ($doc_terms):
		foreach($doc_terms as $term) :?>
				<li><i class="fas fa-tag"></i> <?php echo $term->name;?></li>
		<?php
		endforeach;
endif;
?>
</ul>
</div>

