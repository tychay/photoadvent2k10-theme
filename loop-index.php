<?php
/**
 * The loop that displays posts (for the index page)
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
global $blog_year;

/* The main look posts are not what I am looking for :-(
	If there are no posts to display, such as an empty archive page */ 
query_posts(array(
	'year' 		=> $blog_year,
	'orderby' 	=> 'date',
	'posts_per_page' 	=> -1,
	));


if ( ! have_posts() ) :
?>

	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, we must have slipped behind schedule — we are pretty sure it’s Terry’s fault — check back soon and we’ll wake him out of bed and get him to launch the website..' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php
else :
	// blurb{{{
	switch ($blog_year) {
	case 2011:
		$about_id = 458;
		break;
	default:
		$about_id = 2;
		break;
	}
	$facebook_id = 136;
	$blurb = get_page( $about_id );
?>
<div class="blurb">
	<h2><?php echo $blurb->post_title; ?></h2>
	<p><?php echo apply_filters('the_content', $blurb->post_content); ?></p>
	<?php advent_subscription_list() ?>
<?php
	$blurb = get_page( $facebook_id );
	echo $blurb->post_content;
?>
</div>
<?php
	// }}}
?>

	<ol class="index">
<?php
	// the loop {{{
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */
	while ( have_posts() ) : the_post();
?>
		<li>
			<h2><strong><?php advent_posted_on(); ?></strong>
				<em class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php  the_title(); ?></a></em>
				by <?php advent_the_author(); ?>
			</h2>
			<?php the_excerpt(); ?>
		</li>
<?php endwhile; // End the loop. Whew. 
	// }}}
?>

	</ol>
<?php
endif;
?>
