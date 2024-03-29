<?php
/**
 * EdxChild (Twenty Twenty Child) functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EdxChild
 * @since 1.0.0
 */

/**
 * Register and Enqueue Styles.
 */
function edxchild_enqueue_styles() {

	$parent_style = 'twentytwenty-style'; // This is 'twentytwenty-style' for the Twenty Twenty theme.

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', '20191206', 'all' );
	wp_enqueue_style(
		'edxchild-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		// wp_get_theme()->get( 'Version' ).
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Add Custom Google serif font.
	wp_enqueue_style( 'edxchild-serif-font', 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700|Lora:400,400i,700,700i', '20191209', 'all' );

	// Add FontAwesome.
	wp_enqueue_style( 'edxchild-fontawesome', 'https://use.fontawesome.com/releases/v5.11.2/css/all.css', '20191209', 'all' );

	// Add Custom JS for top menu.
	wp_enqueue_script( 'edxchild-top-menu', get_stylesheet_directory_uri() . '/js/top-menu.js', array(), '20191209', true );
}
add_action( 'wp_enqueue_scripts', 'edxchild_enqueue_styles' );

/**
 * Logo & Description
 */
/**
 * Displays the site logo, text AND image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
function edxchild_site_logo( $args = array(), $echo = true ) {
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';

	$defaults = array(
		'logo'        => '%1$s<h1 class="site-title">%2$s</h1>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
		'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments for `twentytwenty_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( 'twentytwenty_site_logo_args', $args, $defaults );

	if ( has_custom_logo() ) {
		$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
	}

	// $wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';
	$wrap = 'home_wrap';

	$html = sprintf( $args[ $wrap ], $classname, $contents );

	/**
	 * Filters the arguments for `twentytwenty_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( 'twentytwenty_site_logo', $html, $args, $classname, $contents );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

/**
 * WordPress Filter example (Title).
 *
 * @param string $title The title of the post.
 * @param int    $id    The post Id.
 */
function edxchild_filter_the_title( $title, $id = null ) {

	if ( in_category( 'block', $id ) ) {
		return '<i class="post-title-icon fas fa-dice-d6" title="Block Editor Post"></i> ' . $title;
	}

	if ( in_category( 'classic', $id ) ) {
		return '<i class="post-title-icon fas fa-file-alt" title="Classic Editor Post"></i> ' . $title;
	}

	return $title;

}
add_filter( 'the_title', 'edxchild_filter_the_title', 10, 2 );
add_filter( 'single_cat_title', 'edxchild_filter_the_title' );

/**
 * WordPress Filter example (Excerpt Length).
 *
 * @param int $length The length of the excerpt.
 */
function edxchild_filter_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'edxchild_filter_excerpt_length', 999 );

/**
 * WordPress Filter example (Excerpt More).
 *
 * @param string $more The excerpt more string.
 */
function edxchild_filter_excerpt_more( $more ) {
	return '&hellip; <a href="' . get_the_permalink() . '">[read more]</a>';
}
add_filter( 'excerpt_more', 'edxchild_filter_excerpt_more' );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edxchild_register_sidebar_widgets() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Sidebar Widgets.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Sidebar', 'edxchild' ),
				'id'          => 'sidebar-edxchild',
				'description' => __( 'Widgets in this area will be displayed under the Expanded / Mobile menu.', 'edxchild' ),
			)
		)
	);

}
add_action( 'widgets_init', 'edxchild_register_sidebar_widgets' );

/**
 * Register a new Colophon menu.
 */
function edxchild_register_colophon_menu() {
	register_nav_menu( 'colophon', __( 'Colophon Menu', 'edxchild' ) );
}
add_action( 'after_setup_theme', 'edxchild_register_colophon_menu' );

/**
 * Function to calculate and return post reading time.
 */
function edxchild_reading_time() {

	$content = get_post_field( 'post_content', get_the_ID() );
	$count   = str_word_count( wp_strip_all_tags( $content ) );
	$time    = $count / 250; // Roughly 250 wpm reading time.

	$min = floor( $time % 60 ); // Get only the min (left of the decimal).
	$sec = $time - (int) $time; // Get only the sec (right of the decimal).
	$sec = round( $sec * 60 );  // Convert decimal min (0.296) to seconds.
	$sec = $sec < 10 ? ( '0' . $sec ) : $sec; // If seconds are less than 10, pad with a front 0.

	return $min . ':' . $sec;
}

/**
 * Function to add reading time to post meta.
 */
function edxchild_add_reading_time() {

	/**
	 * Static variables allow exist only in a local function scope,
	 * BUT also do NOT lose their value when the program execution leaves this scope.
	 *
	 * So, we can store data here that will be called and remembered - perfect for post_meta.
	 * We could use $calls, $call++, $calls = 0 - but I'll use a string to mimic the TwentyTwenty function.
	 *
	 * @link https://www.php.net/manual/en/language.variables.scope.php#language.variables.scope.static .
	 */
	static $meta_location = 'single-top';

	if ( 'single-top' === $meta_location ) {
		?>

	<li class="post-reading-time meta-wrapper">
		<span class="meta-icon">
			<span class="screen-reader-text"><?php esc_html_e( 'Reading Time', 'edxchild' ); ?></span>
			<i class="far fa-clock"></i>
		</span>
		<span class="meta-text">
			<?php printf( __( '%s Reading time', 'edxchild' ), edxchild_reading_time() ); // phpcs:ignore ?>
		</span>
	</li>

		<?php
		$meta_location = 'single-bottom';
	} else {
		$meta_location = 'single-top';
	}

}
add_action( 'twentytwenty_start_of_post_meta_list', 'edxchild_add_reading_time', 10, 1 );

/**
 * Function to remove author from top post meta.
 */
function edxchild_remove_author_post_meta() {

	// Remove 'author' from the post_meta array.
	return array(
		'post-date',
		'comments',
		'sticky',
	);

}
add_filter( 'twentytwenty_post_meta_location_single_top', 'edxchild_remove_author_post_meta' );

/**
 * Function to add categories and comments to bottom post meta.
 *
 * @param array $post_meta The $post_meta array.
 */
function edxchild_add_bottom_post_meta( $post_meta ) {

	// Add 'categories' to bottom post meta.
	$add_meta = array(
		'categories',
	);

	// Merge with current $post_meta.
	return array_merge( $post_meta, $add_meta );

}
add_filter( 'twentytwenty_post_meta_location_single_bottom', 'edxchild_add_bottom_post_meta' );
