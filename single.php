<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div><!-- #nav-above -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-meta">
						<?php twentyten_posted_on(); ?>
					</div><!-- .entry-meta -->
<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<div class="entry-author-info">
						<?php advent_author_bio(); ?>
					</div>
<?php endif; ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

				</div><!-- #post-## -->

				<div class="entry-utility">
					<?php twentyten_posted_in(); ?>
					<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-utility -->
					<a name="comments"></a>
<?php
if ( $comment_url = get_post_meta($post->ID, 'comment_url') ) {
?>
	<div id="respond">
		<h3 id="reply-title"><a href="<?php echo $comment_url[0]; ?>">Comments?</a></h3>
	</div><!-- #respond -->
<?php
} else {
	comments_template( '', true );
}
?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link(_x( '&larr;', 'Previous post link', 'twentyten' ).' %link, <span class="author">by %author</span>', '%title' ); ?></div>
					<div class="nav-next"><?php next_post_link('%link, <span class="author">by %author</span> '._x( '&rarr;', 'Next post link', 'twentyten' ), '%title' ); ?></div>
				</div><!-- #nav-below -->

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
