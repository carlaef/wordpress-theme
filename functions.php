<?php
class Carla_RelatedLibraryContentWidget extends WP_Widget {
	function __construct() {
		$ops = array(
			'classname' => 'carla_librarycontentwidget',
			'description' => 'Display library content related to the page'
		);
		parent::__construct('carla_librarycontentwidget', 'Related Library Content', $ops);
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = empty($new_instance['title']) ? 'Related Content' : strip_tags($new_instance['title']);
		$instance['post_types'] = empty($new_instance['post_types']) ? array('all') : $new_instance['post_types'];
		return $instance;
	}

	function form($instance) {
		$title = empty($instance['title']) ? 'Related Content' : $instance['title'];
		$types = get_post_types();
		?>
		<label>Title:
		<input
			class="widefat"
			id="<?php echo esc_attr($this->get_field_id('title'));?>"
			name="<?php echo esc_attr($this->get_field_name('title'));?>"
			type="text"
			value="<?php echo esc_attr($title);?>">
		</label>
		<select multiple name="<?php echo esc_attr($this->get_field_name('post_types'));?>[]">
		<?php
		foreach($types as $post_type):
			if (in_array($post_type, $instance['post_types'])):
		?>
			<option selected value="<?php echo esc_attr($post_type);?>"><?php echo $post_type;?></option>
		<?php
			else:
		?>
			<option value="<?php echo esc_attr($post_type);?>"><?php echo $post_type;?></option>
		<?php
			endif;
		endforeach;
		?>
		</select>
		<?php
	}

	function widget($args, $instance) {
		$types = empty($instance['post_types']) ? 'all' : $instance['post_types'];
		$page_terms = get_the_terms(get_the_ID(), 'library_tag');
		if (!$page_terms) {
			return;
		}
		$terms = array();
		foreach($page_terms as $term) {
			$terms[] = $term->term_id;
		}
		$related_page_args = array(
				'post_type' => $types,
				'tax_query' => array(array(
					'taxonomy' => 'library_tag',
					'terms' => $terms
				))
		);
		echo '<h2>'.$instance['title'].'</h2>';
		$related_pages = new WP_Query($related_page_args);
		echo '<ul>';
		while($related_pages->have_posts()) {
			$related_pages->the_post();
			echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
		}
		echo '</ul>';
		wp_reset_postdata();
	}
}

function carla_post_icon($post_or_id=0) {
	$post_type = get_post_type($post_or_id);
	$icon = '';
	switch($post_type) {
		case 'library_page':
			$icon = 'fas fa-book';
			break;
		case 'document':
			$icon = 'fas fa-file-pdf';
			break;
		case 'legal_case':
			$icon = 'fas fa-gavel';
			break;
	}
	return '<i class="'.$icon.'"></i>';
}

function carla_sidebars() {
	$args = array(
		'id' => 'library_page',
		'name' => 'Library Page'
	);
	register_sidebar($args);
	register_widget('Carla_RelatedLibraryContentWidget');
}
add_action('widgets_init', 'carla_sidebars');

function carla_inject_article_trailer() {
	get_template_part('partials/trailer');
}
add_action('et_after_post', 'carla_inject_article_trailer');

add_action( 'wp_enqueue_scripts', 'carla_enqueue_styles' );
function carla_enqueue_styles() {
 
    $parent_style = 'parent-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/b1644acf26.js');
}

/**
 *	This will hide the Divi "Project" post type.
 *	Thanks to georgiee (https://gist.github.com/EngageWP/062edef103469b1177bc#gistcomment-1801080) for his improved solution.
 */
add_filter( 'et_project_posttype_args', 'carla_et_project_posttype_args', 10, 1 );
function carla_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}

define('PODS_SHORTCODE_ALLOW_SUB_SHORTCODES',true);
/**
* Allow Pods Templates to use shortcodes
*
* NOTE: Will only work if the constant PODS_SHORTCODE_ALLOW_SUB_SHORTCODES is defined and set to
  true, which by default it IS NOT.
*/
add_filter( 'pods_shortcode', function( $tags )  {
  $tags[ 'shortcodes' ] = true;
  
  return $tags;
  
});

add_filter('manage_document_posts_columns', 'carla_document_columns');
add_filter('manage_document_posts_custom_column', 'carla_document_custom_column');
function carla_document_columns($columns) {
	$columns['legal_case'] = 'Legal Case';
	return $columns;
}

function carla_document_custom_column($column_name) {
	if ($column_name == 'legal_case') {
		global $post;
		$pod = pods('document', $post->ID);
		echo '<a href="'.get_the_permalink($pod->field('legal_case.ID')).'">'.$pod->display('legal_case.post_title').'</a>';
	}
}

function carla_library_results_per_page($query) {
	if (!is_admin() && $query->is_main_query() && is_tax('library_tag')) {
		$query->set('posts_per_page', 30);
		$query->set('posts_per_archive_page', 30);
	}
}
add_filter('pre_get_posts', 'carla_library_results_per_page');

function carla_parse_library_query($query) {
	if (!empty($_GET['library_search'])) {
		$query->set('tax_query', array(array('taxonomy' => 'library_tag', 'operator' => 'EXISTS')));
	}
	return $query;
}
add_filter('parse_query', 'carla_parse_library_query');
