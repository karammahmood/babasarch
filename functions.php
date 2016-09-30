<?php
    
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

function setup() {
    // Translation
    load_theme_textdomain( 'Vela', get_template_directory() . '/languages' );

    // Default RSS feed links
    add_theme_support('automatic-feed-links');

	//add_theme_support( 'title-tag' );

    // Woocommerce Support
    add_theme_support('woocommerce');

    // Enable support for Post Formats
	add_theme_support('post-formats', array(
		'audio', 'gallery', 'link', 'quote', 'video'
	));

    // Add post thumbnail functionality
    add_theme_support('post-thumbnails');
    add_image_size('medium', 300, 300, true);
    add_image_size('large', 640, 640, true);
    add_image_size('blog-medium', 600, 340, true);
    add_image_size('blog-large', 800, 450, true);
    add_image_size('blog-full', 1024, 768, true);

    // Allow shortcodes in widget text
    add_filter('widget_text', 'do_shortcode');

    // Register Navigation Location
	register_nav_menus( array(
		'primary'   => 'Primary Navigation',
        'top' => 'Top Bar Navigation',
		'footer' => 'Footer Navigation'
	));

    // Add html editor css styles
    add_editor_style( array( 'css/editor.css', 'css/font-awesome.min.css' ) );
    
    // This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

}
add_action('after_setup_theme', 'setup');


function wyde_widgets_init(){
    // Register Sidebar Location
    register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'blog',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

    register_sidebar(array(
		'name' => 'Shop Sidebar',
		'id' => 'shop',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Column 1',
		'id' => 'footer1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

    register_sidebar(array(
		'name' => 'Footer Column 2',
		'id' => 'footer2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

    register_sidebar(array(
		'name' => 'Footer Column 3',
		'id' => 'footer3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

    register_sidebar(array(
		'name' => 'Footer Column 4',
		'id' => 'footer4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'wyde_widgets_init' );

function vela_load_styles(){
    
    global $wyde_options;

    $theme_info = wp_get_theme('Vela');

    $version = $theme_info->get( 'Version' );

    $asset_base_uri = get_template_directory_uri();
    
	wp_enqueue_style('vela', get_stylesheet_uri(), null, $version);
    
    //Plugins stylesheet
    wp_deregister_style('font-awesome');
    wp_register_style('font-awesome', $asset_base_uri . '/css/font-awesome.min.css', null, '4.3.0');
    wp_enqueue_style('font-awesome');

    wp_register_style('bootstrap', $asset_base_uri . '/css/bootstrap.min.css', null, null);
    wp_enqueue_style('bootstrap');
    
    wp_deregister_style('vc_pageable_owl-carousel-css');
    wp_deregister_style('vc_pageable_owl-carousel-css-theme');
    wp_enqueue_style('owl-carousel', $asset_base_uri . '/css/owl.carousel.min.css', null, null);

    wp_deregister_style('flexslider');
    wp_register_style('flexslider', $asset_base_uri . '/css/flexslider.min.css', null, null);
    wp_enqueue_style('flexslider');
    
    wp_deregister_style('prettyphoto');
    wp_register_style('prettyphoto', $asset_base_uri . '/css/prettyPhoto.min.css', null, null);
    wp_enqueue_style('prettyphoto');

    // if Ajax Page Transition enabled
    if($wyde_options['ajax_page']){
	    /*wp_enqueue_style( 'vc_openiconic' );
	    wp_enqueue_style( 'vc_typicons' );
	    wp_enqueue_style( 'vc_entypo' );
	    wp_enqueue_style( 'vc_linecons' );*/
        if(!wp_style_is('nivo-slider-css')){
            wp_enqueue_style( 'nivo-slider-css' );
	        wp_enqueue_style( 'nivo-slider-theme' );
        }
    }

    if(!wp_style_is('js_composer_front')){
        wp_enqueue_style('js_composer_front');
    }

    //Vela stylesheet
    wp_enqueue_style('vela-animation', $asset_base_uri . '/css/animation.min.css', null, $version);

    wp_enqueue_style('vela-theme', $asset_base_uri . '/css/vela.css', null, $version);
    
    if(class_exists( 'Woocommerce' )){
        wp_enqueue_style( 'vela-woocommerce', $asset_base_uri . '/css/woocommerce.css', null, $version);
    }

    if($wyde_options['responsive']){
        wp_enqueue_style('vela-responsive', $asset_base_uri . '/css/responsive.css', null, $version);
    } 

    //Style selector css for demo only
    //wp_enqueue_style('vela-demo', $asset_base_uri . '/css/style-selector.css', null, $version);

}

function vela_load_scripts(){
    
    global $wyde_options;

    $theme_info = wp_get_theme('Vela');

    $version = $theme_info->get( 'Version' );

    //Load stylesheets
    vela_load_styles();

    $asset_base_uri = get_template_directory_uri();

    //Plugins script.
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-effects-core');

    //Modernizr
    wp_register_script('modernizr', $asset_base_uri . '/js/modernizr.js', array('jquery'), null, false);
    wp_enqueue_script('modernizr');

    wp_register_script('wyde-plugins', $asset_base_uri . '/js/plugins.js', array('jquery'), $version, true);
    wp_enqueue_script('wyde-plugins');

    $page_settings = array();
    $page_settings['siteURL'] = get_site_url();
    $page_settings['mobile_animation'] = isset( $wyde_options['mobile_animation'] ) ? $wyde_options['mobile_animation']:false;
    if( isset( $wyde_options['preload_images'] ) && $wyde_options['preload_images'] ){
        $page_settings['isPreload'] = true;
    }else{
        $page_settings['isPreload'] = false;
    }
    wp_localize_script('wyde-plugins', 'page_settings', $page_settings);

    wp_register_script('wyde-page', $asset_base_uri . '/js/page.js', null, $version, true);
    wp_enqueue_script('wyde-page');

    //if Ajax Page Transition enabled
    if($wyde_options['ajax_page']){

        wp_enqueue_script( 'comment-reply' );

        if(!wp_script_is('wpb_composer_front_js')){
            wp_enqueue_script('wpb_composer_front_js');
        }

        if(!wp_script_is('jquery_ui_tabs_rotate')){
            wp_enqueue_script('jquery_ui_tabs_rotate');
        }

        if(!wp_script_is('jcarousellite')){
            //load jcarousellite from visual composer
            wp_enqueue_script('jcarousellite');
        }

        if(!wp_script_is('nivo-slider')){
            //load nivo-slider from visual composer
            wp_enqueue_script('nivo-slider');
        }

        wp_enqueue_script('jquery-ui-accordion');


        //Ajax Page Transition script
        wp_register_script('ajax-page', $asset_base_uri . '/js/ajax-page.js', null, $version, true);
        wp_enqueue_script('ajax-page');
        $ajax_settings = array();
        $ajax_settings['transition'] = $wyde_options['ajax_page_transition'];
        if( isset($wyde_options['ajax_page_exclude_urls']) && is_array($wyde_options['ajax_page_exclude_urls']) ){
            $ajax_settings['excludeURLs'] = $wyde_options['ajax_page_exclude_urls'];
        }
        wp_localize_script('ajax-page', 'ajax_page_settings', $ajax_settings);

    }

    //Bootstrap script
    wp_deregister_script( 'bootstrapjs' );
    wp_register_script('bootstrapjs', $asset_base_uri . '/js/bootstrap.min.js', null, null, true);
    wp_enqueue_script('bootstrapjs');

    //Deregister script from Visual Composer or another plugins
    wp_deregister_script( 'waypoints' );
    wp_deregister_script( 'isotope' );
    wp_deregister_script( 'flexslider' );
    wp_deregister_script( 'prettyphoto' );

    //Google Maps API
    wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js', null, null, true);
    wp_enqueue_script('googlemaps');

    //Smooth Scroll
    if($wyde_options['smooth_scroll']){
        wp_enqueue_script('smoothscroll', $asset_base_uri . '/js/smoothscroll.js', null, $version, true);   
        wp_enqueue_script('smoothscroll');
    }

    //Ajax Search
    if($wyde_options['ajax_search']){
           
        wp_register_script('ajax-search', $asset_base_uri . '/js/ajax-search.js', null, $version, true);
        wp_enqueue_script('ajax-search');
        wp_localize_script( 'ajax-search', 'ajax_search_settings', array('ajaxURL'=> admin_url( 'admin-ajax.php' )));

    }
    
    //Style selector script for demo only
    //wp_enqueue_script('vela-demo-script', $asset_base_uri . '/js/style-selector.js', null, null, true);

}
add_action('wp_enqueue_scripts', 'vela_load_scripts');

function vela_load_admin_scripts(){
    
    $asset_base_uri = get_template_directory_uri();
    
    wp_deregister_style('font-awesome');
    wp_register_style('font-awesome', $asset_base_uri . '/css/font-awesome.min.css', null, '4.3.0');
    wp_enqueue_style('font-awesome');

    wp_register_style('vela-animation', $asset_base_uri . '/css/animation.min.css', null, null);
    wp_enqueue_style('vela-animation');

}
add_action( 'admin_enqueue_scripts', 'vela_load_admin_scripts');

function vela_theme_activation()
{
	global $pagenow;
	if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']))
	{	
        //update woocommerce thumbnail size after theme activation
        update_option('shop_thumbnail_image_size', array('width' => 150, 'height' => 150, 'crop'    =>  true));
		update_option('shop_catalog_image_size', array('width' => 300, 'height' => 300, 'crop'  =>    true));
		update_option('shop_single_image_size', array('width' => 640, 'height' => 640, 'crop'   => true));
	}
}
add_action('admin_init','vela_theme_activation');


function wyde_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

    $sep = ' | ';

	// Add the site description for the home/front page.
	if ( is_home() || is_front_page() ){
		$title = get_bloginfo( 'name' );
        $desc = get_bloginfo( 'description' );
        if( !empty($desc) ) $title .= ' - ' .$desc;
	}else{
        // Add a page number if necessary.
	    if ( $paged >= 2 || $page >= 2 ){
		    $title = "$title - " . sprintf( __( 'Page %s', 'Vela' ), max( $paged, $page ) ) . $sep. get_bloginfo( 'name' );
	    }else{
	        $title .= $sep. get_bloginfo( 'name' );
	    }
	}
	
	return trim($title);
}
add_filter( 'wp_title', 'wyde_wp_title', 10, 2 );


//update post view
function wyde_track_post_views ($post_id) {
    if ( !is_single() ){
        return;
    }
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;   
    }
    wyde_set_post_views($post_id);
}
add_action( 'wp_head', 'wyde_track_post_views');
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Register default function when plugin not activated
function wyde_plugins_loaded() {
	if(!function_exists('is_woocommerce')) {
		function is_woocommerce() { return false; }
	}
}
add_action('wp_head', 'wyde_plugins_loaded');

function vela_custom_head_script(){
    global $wyde_options, $wyde_color_scheme;
    $wyde_color_scheme = wyde_get_color_scheme(); 
    echo '<style type="text/css" data-name="vela-color-scheme">';
    ob_start();
	include_once get_template_directory() . '/css/custom-css.php';
	echo ob_get_clean();
    echo '</style>';
    if( !empty($wyde_options['head_script']) ){
        /**
        *Echo extra HTML/JavaScript/Stylesheet from theme options > advanced - head content
        */
        echo balanceTags( $wyde_options['head_script'], true );
    } 
}
add_action('wp_head', 'vela_custom_head_script', 160);

//Add the Open Graph doctype support
function add_opengraph_doctype( $output ) {
    global $wyde_options;
    
    if( isset($wyde_options['page_og_support']) && !$wyde_options['page_og_support'] ){
        return $output;
    }else{
	   return $output .' prefix="og: http://ogp.me/ns#"';
    }
}
add_filter('language_attributes', 'add_opengraph_doctype');


//Add og meta inside <head>
function add_og_meta() {
    global $wyde_options, $post;
    
    if (!is_singular()) {
        return;
    }
        
    if( isset($wyde_options['page_og_support']) && !$wyde_options['page_og_support'] ){
        return;
    }
       
	echo sprintf('<meta property="og:title" content="%s"/>', get_the_title());
	echo sprintf('<meta property="og:url" content="%s"/>', get_permalink());
	echo sprintf('<meta property="og:site_name" content="%s"/>', get_bloginfo('name'));
    echo '<meta property="og:type" content="article"/>';
    if(!has_post_thumbnail( $post->ID )) { 
    	if( !empty( $wyde_options['logo_image']['url'] )){
    	   echo sprintf('<meta property="og:image" content="%s"/>', esc_url( $wyde_options['logo_image']['url'] ));    	    
    	}
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        echo sprintf('<meta property="og:image" content="%s"/>', esc_url( $thumbnail_src[0] ) );
    }
    
}
add_action('wp_head', 'add_og_meta', 5);


//Allow skype protocal for social icons
function wyde_allow_skype_protocol( $protocols ){
    $protocols[] = 'skype';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'wyde_allow_skype_protocol' );


//Set excerpt length for masonry
function masonry_excerpt_length( $length ) {
    global $wyde_blog_layout;
    if($wyde_blog_layout == 'masonry'){
        $length = 15;
    } 
	return $length;
}
add_filter( 'excerpt_length', 'masonry_excerpt_length', 999 );

//Set image quality
function wyde_image_full_quality($quality) {
    return 80;
}
add_filter('jpeg_quality', 'wyde_image_full_quality');
add_filter('wp_editor_set_quality', 'wyde_image_full_quality');


//Set post title placeholder
function get_post_title ( $title ) {
    switch(get_post_type()){
        case 'testimonial':
        $title = __( 'Enter the customer\'s name here', 'Vela' );
        break;
        case 'team-member':
        $title = __( 'Enter the member\'s name here', 'Vela' );
        break;
    }

	return $title;
}
add_filter( 'enter_title_here', 'get_post_title' );


//Flush rewrite rules after switch theme
function wyde_after_switch_theme() {
    //flush rewrite rules after switch theme
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'wyde_after_switch_theme' );


/* Custom Functions */
include_once get_template_directory() . '/inc/custom-functions.php';

/* Theme Options Framework */
require_once( get_template_directory() . '/admin/options.php' );

/* Metaboxes */
include_once get_template_directory() . '/inc/metaboxes/options.php';

/* Shortcodes */
include_once get_template_directory() . '/shortcodes/class-shortcodes.php';

/* Ajax Search */
include_once get_template_directory() . '/inc/class-ajax-search.php';

if(class_exists('Woocommerce')){
/* WooCommerce Functions */
include_once get_template_directory() . '/inc/woocommerce.php';
}

/* Widgets */
include_once get_template_directory() . '/widgets/widgets.php';

/* TGM Plugin Activation */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/* register required plugins */
function register_required_plugins() {
	
	$plugins = array(
		array(
			'name'     				=> 'Wyde Core', 
			'slug'     				=> 'wyde-core', 
			'source'   				=> get_template_directory() . '/inc/plugins/wyde-core.zip',
			'required' 				=> true, 
			'version' 				=> '1.6.0', 
			'force_activation' 		=> true,
			'force_deactivation' 	=> false, 
			'external_url' 			=> '', 
		),
        array(
			'name'     				=> 'WPBakery Visual Composer', 
			'slug'     				=> 'js_composer', 
			'source'   				=> get_template_directory() . '/inc/plugins/js_composer.zip',
			'required' 				=> false, 
			'version' 				=> '4.9.2', 
			'force_activation' 		=> false,
			'force_deactivation' 	=> false, 
			'external_url' 			=> '', 
		),
        array(
			'name'     				=> 'Slider Revolution', 
			'slug'     				=> 'revslider', 
			'source'   				=> get_template_directory() . '/inc/plugins/revslider.zip',
			'required' 				=> false, 
			'version' 				=> '5.1.6',
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false, 
			'external_url' 			=> '',
		),
        array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7',
			'required' 				=> false,
			'version' 				=> '4.0.3',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false
		)
	);

	$config = array(
		'domain'       		=> 'Vela',         	            // Text domain - likely want to be the same as your theme.
		'default_path'        => '',                          // Default absolute path to pre-packaged plugins        
        'menu'              => 'install-required-plugins',  // Menu slug.
        'parent_slug'       => 'themes.php',            // Parent menu slug.
        'capability'        => 'edit_theme_options',
        'has_notices'       => true,                        // Show admin notices or not
        'dismissable'       => true,                        // If false, a user cannot dismiss the nag message.
        'is_automatic'      => false,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                      => __( 'Install Recommended Plugins', 'Vela' ),
            'menu_title'                      => __( 'Install Plugins', 'Vela' ),
            'installing'                      => __( 'Installing Plugin: %s', 'Vela' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'Vela' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop(
                'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop(
                'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'Vela'
            ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop(
                'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                'Vela'
            ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'Vela'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'Vela'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'Vela'
            ),
            'return'                          => __( 'Return to Required Plugins Installer', 'Vela' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'Vela' ),
            'activated_successfully'          => __( 'The following plugin was activated successfully:', 'Vela' ),
            'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'Vela' ),  // %1$s = plugin name(s).
            'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'Vela' ),  // %1$s = plugin name(s).
            'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'Vela' ), // %s = dashboard link.
            'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'Vela' ),
            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
	);

	tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'register_required_plugins' );