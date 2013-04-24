<?php
/**
 * Custom template tags for this theme.
 *
 * @package via
 * @since via 1.0
 */



/**
 * Display navigation to next/previous pages when applicable
 *
 * @since via 1.0
 */
if ( ! function_exists( 'via_content_nav' ) ):

function via_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'via' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'via' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'via' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'via' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'via' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // via_content_nav



/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since via 1.0
 */

if ( ! function_exists( 'via_comment' ) ) :
function via_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'via' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'via' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s', 'via' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'via' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'via' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'via' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for via_comment()



/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since via 1.0
 */
if ( ! function_exists( 'via_posted_on' ) ) :

function via_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'via' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'via' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;


/**
 * Returns true if a blog has more than 1 category
 *
 * @since via 1.0
 */
function via_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so via_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so via_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in via_categorized_blog
 *
 * @since via 1.0
 */
function via_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'via_category_transient_flusher' );
add_action( 'save_post', 'via_category_transient_flusher' );


if ( ! function_exists( 'via_post_format_label' ) ) :
/**
 * Post format label
 *
 * Display or retrieve plural post format label.
 *
 * @since via 1.0
 *
 * @param string $format Optional, default is null. If null, use the current post format.
 * @param bool $display Optional, default is false. Whether to display or retrieve title.
 * @return string|null String on retrieve, null when displaying.
 */
function via_post_format_label( $format = null, $display = false ) {
	// Get current format if not provided
	$format = ( null === $format ) ? get_post_format() : $format;

	// Map formats to their corresponsing plural label
	$labels = array(
	    'aside' => _x( 'Asides', 'post-format-archive-label', 'via' ),
	    'link'  => _x( 'Links', 'post-format-archive-label', 'via' ),
	    'image' => _x( 'Images', 'post-format-archive-label', 'via' ),
	    'quote' => _x( 'Quotes', 'post-format-archive-label', 'via' ),
	    'video' => _x( 'Videos', 'post-format-archive-label', 'via' ),
	    'gallery' => _x( 'Galleries', 'post-format-archive-label', 'via' )
	);

	// Allow child themes to add/customize labels
	$labels = apply_filters( 'via_post_format_labels', $labels );

	// Check to see that we've provided a label for the format
	if ( array_key_exists( $format, $labels ) )
		$label = $labels[$format];
	// Format label not defined? Use default format name.
	else
		$label = get_post_format_string( $format );

	// Send it out
	if ( $display )
		return $label;
	else
		print $label;
}
endif;