<?php
// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 584;

/*
 * Tell WordPress to run newtheme_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'newtheme_setup' );

if ( ! function_exists( 'newtheme_setup' ) ):
/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override newtheme_setup() in a child theme, add your own newtheme_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain()    For translation/localization support.
 * @uses add_editor_style()         To style the visual editor.
 * @uses add_theme_support()        To add support for post thumbnails, automatic feed links, custom headers
 * 	                                and backgrounds, and post formats.
 * @uses register_nav_menus()       To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size()  To set a custom post thumbnail size.
 *
 * @since Twenty Eleven 1.0
 */
function newtheme_setup() {

	/*
	 * Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use
	 * a find and replace to change 'newtheme' to the name
	 * of your theme in all the template files.
	 */
	load_theme_textdomain( 'newtheme', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'new-theme11282016' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	$theme_options = newtheme_get_theme_options();
	if ( 'dark' == $theme_options['color_scheme'] )
		$default_background_color = '1d1d1d';
	else
		$default_background_color = 'e2e2e2';

	// Add support for custom backgrounds.
	add_theme_support( 'custom-background', array(
		/*
		 * Let WordPress know what our default background color is.
		 * This is dependent on our current color scheme.
		 */
		'default-color' => $default_background_color,
	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		/**
		 * Filter the Twenty Eleven default header image width.
		 *
		 * @since Twenty Eleven 1.0
		 *
		 * @param int The default header image width in pixels. Default 1000.
		 */
		'width' => apply_filters( 'newtheme_header_image_width', 1000 ),
		/**
		 * Filter the Twenty Eleven default header image height.
		 *
		 * @since Twenty Eleven 1.0
		 *
		 * @param int The default header image height in pixels. Default 288.
		 */
		'height' => apply_filters( 'newtheme_header_image_height', 288 ),
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'newtheme_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'newtheme_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'newtheme_admin_header_image',
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

	/*
	 * We'll be using post thumbnails for custom header images on posts and pages.
	 * We want them to be the size of the header image that we just defined.
	 * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	 */
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	/*
	 * Add Twenty Eleven's custom image sizes.
	 * Used for large feature (header) images.
	 */
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'wheel' => array(
			'url' => '%s/images/headers/wheel.jpg',
			'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Wheel', 'newtheme' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Shore', 'newtheme' )
		),
		'trolley' => array(
			'url' => '%s/images/headers/trolley.jpg',
			'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Trolley', 'newtheme' )
		),
		'pine-cone' => array(
			'url' => '%s/images/headers/pine-cone.jpg',
			'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Pine Cone', 'newtheme' )
		),
		'chessboard' => array(
			'url' => '%s/images/headers/chessboard.jpg',
			'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Chessboard', 'newtheme' )
		),
		'lanterns' => array(
			'url' => '%s/images/headers/lanterns.jpg',
			'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Lanterns', 'newtheme' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Willow', 'newtheme' )
		),
		'hanoi' => array(
			'url' => '%s/images/headers/hanoi.jpg',
			'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Hanoi Plant', 'newtheme' )
		)
	) );
    
    /**
	 * Add editor styles
	 */
	add_editor_style( array( 'inc/editor-style.css', 'fonts/custom-fonts.css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
    
    
}
endif; // newtheme_setup

if ( ! function_exists( 'newtheme_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @since Twenty Eleven 1.0
 */
function newtheme_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="newtheme-header-css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // newtheme_header_style

if ( ! function_exists( 'newtheme_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in newtheme_setup().
 *
 * @since Twenty Eleven 1.0
 */
function newtheme_admin_header_style() {
?>
	<style type="text/css" id="newtheme-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // newtheme_admin_header_style

if ( ! function_exists( 'newtheme_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in newtheme_setup().
 *
 * @since Twenty Eleven 1.0
 */
function newtheme_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		$style = 'display: none;';
		if ( $color && $color != 'blank' ) {
			$style = 'color: #' . $color . ';';
		}
		?>
		<h1 class="displaying-header-text"><a id="name" style="<?php echo esc_attr( $style ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" tabindex="-1"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc" class="displaying-header-text" style="<?php echo esc_attr( $style ); ?>"><?php bloginfo( 'description' ); ?></div>
  		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // newtheme_admin_header_image

/**
 * Set the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove
 * the filter and add your own function tied to
 * the excerpt_length filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param int $length The number of excerpt characters.
 * @return int The filtered number of characters.
 */
function newtheme_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'newtheme_excerpt_length' );

if ( ! function_exists( 'newtheme_continue_reading_link' ) ) :
/**
 * Return a "Continue Reading" link for excerpts
 *
 * @since Twenty Eleven 1.0
 *
 * @return string The "Continue Reading" HTML link.
 */
function newtheme_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'newtheme' ) . '</a>';
}
endif; // newtheme_continue_reading_link

/**
 * Replace "[...]" in the Read More link with an ellipsis.
 *
 * The "[...]" is appended to automatically generated excerpts.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param string $more The Read More text.
 * @return The filtered Read More text.
 */
function newtheme_auto_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		return ' &hellip;' . newtheme_continue_reading_link();
	}
	return $more;
}
add_filter( 'excerpt_more', 'newtheme_auto_excerpt_more' );

/**
 * Add a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param string $output The "Continue Reading" link.
 * @return string The filtered "Continue Reading" link.
 */
function newtheme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() && ! is_admin() ) {
		$output .= newtheme_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'newtheme_custom_excerpt_more' );

/**
 * Show a home link for the wp_nav_menu() fallback, wp_page_menu().
 *
 * @since Twenty Eleven 1.0
 *
 * @param array $args The page menu arguments. @see wp_page_menu()
 * @return array The filtered page menu arguments.
 */
function newtheme_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'newtheme_page_menu_args' );

/**
 * Register sidebars and widgetized areas.
 *
 * Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function newtheme_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'newtheme' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Showcase Sidebar', 'newtheme' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'newtheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'newtheme' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'newtheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'newtheme' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'newtheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'newtheme' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'newtheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'newtheme_widgets_init' );

if ( ! function_exists( 'newtheme_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 *
 * @since Twenty Eleven 1.0
 *
 * @param string $html_id The HTML id attribute.
 */
function newtheme_content_nav( $html_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'newtheme' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'newtheme' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'newtheme' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // newtheme_content_nav

/**
 * Return the first link from the post content. If none found, the
 * post permalink is used as a fallback.
 *
 * @since Twenty Eleven 1.0
 *
 * @uses get_url_in_content() to get the first URL from the post content.
 *
 * @return string The first link.
 */
function newtheme_get_first_url() {
	$content = get_the_content();
	$has_url = function_exists( 'get_url_in_content' ) ? get_url_in_content( $content ) : false;

	if ( ! $has_url )
		$has_url = newtheme_url_grabber();

	/** This filter is documented in wp-includes/link-template.php */
	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 *
 * @return string|bool URL or false when no link is present.
 */
function newtheme_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}
/*///////////////////////end of theme options ////////////////////////////*/ 
/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
                        'primary' => 'primary',
                        'name' => ( 'Primary' ),
                        'description' => ( 'This is the primary sidebar.' ),
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>'
                ) );

/*
function newtheme_child_register_menu(){
    register_nav_menu('new-menu',__('Our New Menu'));
}
add_action('init','newtheme_child_register_menu');
/*///////////////////////end  ////////////////////////////*/ 

	

/*///////////////////////end  ////////////////////////////*/ 
add_action( 'widgets_init', 'my_sidebar' );
 
function my_sidebar(){
 
        /* Register the 'primary' sidebar. */
        register_sidebar(
                array(
                        'id' => 'primary',
                        'name' => ( 'Primary' ),
                        'description' => ( 'This is the primary sidebar.' ),
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>'
                )
        );
 
        }
       

?>