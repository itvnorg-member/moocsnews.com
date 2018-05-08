<?php 
/**
 * Template Name: Front Page
 *
 * @package WordPress
 * @subpackage moocsnews
 * @since moocsnews 1.0
 */
	$categories = get_categories(); 
	get_header(); 
?>
<?php echo do_shortcode("[simpleslider location=top]"); ?>
<section class="popular-courses">
	<div class="container">
		<h2><?php echo __('Popular Online Courses'); ?></h2>
		<?php require_once MOOCSNEWS_THEME_INC_DIR . '/popular-courses.php'; ?>
	</div>
</section>
<?php get_footer(); ?>