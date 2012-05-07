<?php
/**
 * PhotoAdvent functions and definitions
 *
 * @package tychay_WP_themes
 * @subpackage Photo_Advent
 * @since Twenty Ten 1.0
 */
global $blog_year;

/**
 * Compute when the new advent starts
 * @globals $blog_year
 */
$blog_year = (int) date('Y');
if ( (int) date('n') < 12 ) {
	--$blog_year;
}
$GLOBALS['blog_year'] = $blog_year;
// {{{ advent_banner_name()
/**
 * Output the blog title for header to match the format for phpadvent
 */
function advent_banner_name() {
	global $blog_year;
	echo str_ireplace( 'advent',' <span>Advent</span> ', get_bloginfo( 'name', 'display' ) ) . $blog_year;
}
// }}}
// {{{ advent_banner_description()
/**
 * Output the site description to use the site description on homepage
 * but the phpadvent style "subscribe" links everywhere else.
 */
function advent_banner_description() {
	if ( is_home() || is_front_page() ) {
		bloginfo( 'description' ); 
	} else {
		advent_subscription_list();
	}
	//global $blog_year;
	//echo str_ireplace( 'advent',' <span>Advent</span> ', get_bloginfo('name') ) . $blog_year;
}
// }}}
// {{{ advent_subscription_list()
/**
 * Output the html of the phpadvent style subscribe/follow stuff
 */
function advent_subscription_list() {
	echo '<ul>';
	printf( '<li><a href="%s">%s</a></li>', get_bloginfo('rss2_url'), __('Subscribe to our feed') );
	if ( $twittername = get_option('twitter_username') ) {
		printf( '<li><a href="http://twitter.com/%s">%s</a></li>', esc_attr($twittername), __('Follow us on Twitter') );
	}
	echo '</ul>';

}
// }}}
// {{{ advent_posted_on()
function advent_posted_on() {
	the_date('j<\s\u\p>S</\s\u\p><\s\p\a\n\> M:\<\s\p\a\n\>');
	/*
	printf( __('<p class="%1$s"><em><a href="%2$s" title="%3$s" rel="bookmark" class="entry-date">%4$s</span></a></em> by <sapn class="author vcard"><a class="url fn n" href="%5$s" title="%6$s">%7$s</a></span>:</p>'),
			'meta-prep meta-prep-author',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date('j<\\s\\u\\p>S</\\s\\u\\p> M Y'),
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		);
	 */
}
// }}}
// {{{ advent_the_author()
/**
 * @see http://codex.wordpress.org/Function_Reference/the_author
 * @see http://codex.wordpress.org/Function_Reference/get_avatar
 * @see http://codex.wordpress.org/Function_Reference/get_the_author_link
 */
function advent_the_author() {
	printf('<span class="meta-author">%1$s %2$s</span>',
		get_avatar(get_the_author_meta('id'),48,'',get_the_author()),
		get_the_author_link()
	);
}
/**
 * Look for advent user meta for image. If not there, use gravatar
 * @see http://themeshaper.com/how-to-add-gravatars-for-the-post-author-in-wordpress/
 * @see http://codex.wordpress.org/Using_Gravatars
 * @see http://codex.wordpress.org/Function_Reference/the_author_meta
 */
function get_advent_author_avatar_url() {
	$hash = md5(strtolower(get_the_author_email()));
	return 'http://www.gravatar.com/avatar/' . $hash . '?s=48';
	//return get_avatar( get_the_author_email(), '45' );
}
// }}}
// {{{ twentyten_posted_on()
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( '<p class="meta-prep meta-prep-author"><a href="%1$s" title="%2$s" rel="bookmark" class="entry-date">%3$s</a> by <span class="author vcard">%4$s</span>:</p>',
		get_permalink(),
		esc_attr( get_the_time() ),
		get_the_date('j<\s\u\p>S</\s\u\p> M Y'),
		get_the_author_link(),
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
		get_the_author()
		);
	//'<a class="url fn n" href="%5$s" title="%6$s">%7$s</a></span>:</p>'
}
// }}}
// {{{ advent_author_bio()
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @see http://codex.wordpress.org/Function_Reference/the_author_meta
 * @see http://codex.wordpress.org/Function_Reference/wp_get_attachment_image
 * @see http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
 */
function advent_author_bio() {
	global $post;
	$full_src = wp_get_attachment_image_src(get_the_author_meta('bio_id'), 'full');
	printf('<h2>About %1$s</h2><cite><a href="%2$s" title="%1$s" rel="lightbox[%3$s]">%4$s</a></cite><blockquote><p>“%5$s”</p></blockquote><ul>',
		get_the_author(),
		$full_src[0],
		$post->ID,
		wp_get_attachment_image(get_the_author_meta('bio_id'), 'thumbnail'), 
		get_the_author_meta('description')
	);
	$li_html = '<li><span>%s: </span>%s</li>';
	if ( get_the_author_meta('user_url') ) {
		printf( $li_html, 'URL', sprintf('<a href="%1$s">%1$s</a>', get_the_author_meta('user_url')) );
	}
	if ( get_the_author_meta('location') ) {
		printf( $li_html, 'Location', sprintf('<a href="http://maps.google.co.uk/?q=%s">%s</a>', urlencode(get_the_author_meta('location')), get_the_author_meta('location')) );
	}
	if ( get_the_author_meta('flickr') ) {
		printf( $li_html, 'Flickr', sprintf('<a href="http://%1$s">%1$s</a>','flickr.com/photos/'.get_the_author_meta('flickr')) );
	}
	if ( get_the_author_meta('twitter') ) {
		printf( $li_html, 'Twitter', sprintf('<a href="http://twitter.com/%1$s">@%1$s</a>',get_the_author_meta('twitter')) );
	}
	print('</ul>');
	return;
	printf( __('<p class="%1$s"><a href="%2$s" title="%3$s" rel="bookmark" class="entry-date">%4$s</a> by <span class="author vcard">'
	),
		'meta-prep meta-prep-author',
		get_permalink(),
		esc_attr( get_the_time() ),
		get_the_date('j<\s\u\p>S</\s\u\p> M Y'),
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
		get_the_author()
		);
}
// }}}
