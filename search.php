<?php
if ($_GET['library_search']) {
	include("taxonomy-library_tag.php");
} else {
	include(get_template_directory() . '/index.php');
}
?>
