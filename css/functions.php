<?php
/**
 * Maav functions and definitions
 */

/**
 * Define Constants
 * ================
 */
define( 'MAAV_THEME_ROOT', esc_url( get_template_directory_uri() ) );
define( 'MAAV_INC_DIR', get_template_directory() . '/inc/' );
define( 'MAAV_PARENT_THEME_NAME', wp_get_theme( get_template() )->get( 'Name' ) );
define( 'MAAV_PARENT_THEME_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );
define( 'MAAV_PARENT_THEME_AUTHOR', wp_get_theme( get_template() )->get( 'Author' ) );
define( 'MAAV_PRIMARY_COLOR', '#1e1e1e' );
define( 'MAAV_SECONDARY_COLOR', '#1e1e1e' );
define( 'MAAV_PRIMARY_FONT', 'Open Sans' );
define( 'MAAV_SECONDARY_FONT', 'Raleway' );
define( 'MAAV_SHORTCODE_CATEGORY', esc_html__( 'By', 'maav' ) . ' ' . MAAV_PARENT_THEME_NAME );

if ( ! function_exists( 'maav_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     * ===========================================================================
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function maav_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain( 'maav', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
                                'primary' => esc_html__( 'Primary Menu', 'maav' ),
                            ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'maav_custom_background_args', array(
            'default-color' => '#ffffff',
            'default-image' => '',
        ) ) );

        // Support woocommerce
        add_theme_support( 'woocommerce' );
		// ---------------------------------------------
		// Remove Cross Sells From Default Position 
 
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style( array( 'assets/css/editor-style.css', maav_fonts_url() ) );

        add_image_size( 'maav-post-widget', 640, 480, true );
        add_image_size( 'maav-team-member-1', 450, 583, true );
        add_image_size( 'maav-blog-1', 540, 680, true );
        add_image_size( 'maav-blog-2', 370, 200, true );
        add_image_size( 'maav-blog-3', 270, 340, true );
        add_image_size( 'maav-blog-4', 770, 400, true );
        add_image_size( 'maav-grid-minimal', 370, 500, true );
        add_image_size( 'maav-grid-classic', 400, 400, true );
        add_image_size( 'maav-grid-rectangle', 500, 340, true );
        add_image_size( 'maav-grid-masonry', 370, 9999, false );
        add_image_size( 'maav-grid-metro', 400, 400, true );
        add_image_size( 'maav-grid-metro-width-2', 800, 400, true );
        add_image_size( 'maav-grid-metro-height-2', 400, 800, true );
        add_image_size( 'maav-portfolio-slider', 1170, 600, true );
        add_theme_support( 'kungfu-portfolio' );
        add_theme_support( 'kungfu-sidebar' );
        add_theme_support( 'kungfu-metabox' );
        add_theme_support( 'kungfu-thumbs' );
    }
}
add_action( 'after_setup_theme', 'maav_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * ===========================================================================
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}

function maav_widgets_init() {
    register_sidebar( array(
                          'name'          => esc_html__( 'Sidebar', 'maav' ),
                          'id'            => 'sidebar_01',
                          'description'   => esc_html__( 'Sidebar for pages.', 'maav' ),
                          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                          'after_widget'  => '</aside>',
                          'before_title'  => '<h3 class="widget-title">',
                          'after_title'   => '</h3>',
                      ) );
    if ( class_exists( 'WooCommerce' ) ) {
        register_sidebar( array(
                              'name'          => esc_html__( 'Sidebar for shop', 'maav' ),
                              'id'            => 'sidebar-shop',
                              'description'   => esc_html__( 'Sidebar for shop pages.', 'maav' ),
                              'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                              'after_widget'  => '</aside>',
                              'before_title'  => '<h3 class="widget-title">',
                              'after_title'   => '</h3>',
                          ) );
    }
    register_sidebar( array(
                          'name'          => esc_html__( 'Bottom Footer Widget 01', 'maav' ),
                          'id'            => 'bottom_footer_01',
                          'description'   => esc_html__( 'Bottom Footer Column 1', 'maav' ),
                          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                          'after_widget'  => '</aside>',
                          'before_title'  => '<h3 class="widget-title">',
                          'after_title'   => '</h3>',
                      ) );
    register_sidebar( array(
                          'name'          => esc_html__( 'Bottom Footer Widget 02', 'maav' ),
                          'id'            => 'bottom_footer_02',
                          'description'   => esc_html__( 'Bottom Footer Column 2', 'maav' ),
                          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                          'after_widget'  => '</aside>',
                          'before_title'  => '<h3 class="widget-title">',
                          'after_title'   => '</h3>',
                      ) );
}

add_action( 'widgets_init', 'maav_widgets_init' );

function maav_scripts() {

    $header_type = Maav_Helper::get_post_meta( 'header_type', '' );
    if ( $header_type == '' ) {
        $header_type = Kirki::get_option( 'maav', 'header_type' );
    }

    $wnm_custom = array(
        'templateUrl'       => MAAV_THEME_ROOT,
        'ajaxurl'           => admin_url( 'admin-ajax.php' ),
        'nav_sticky_enable' => esc_js( Kirki::get_option( 'maav', 'nav_sticky_enable' ) ),
        'header_type'       => esc_js( $header_type ),
        'back_to_top'       => esc_js( Kirki::get_option( 'maav', 'back_to_top' ) ),
    );

    wp_enqueue_style( 'font-awesome', MAAV_THEME_ROOT . '/assets/libs/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style( 'ion-icons', MAAV_THEME_ROOT . '/assets/libs/ion/css/ionicons.min.css' );
    wp_enqueue_style( 'etline', MAAV_THEME_ROOT . '/assets/libs/et-line/etline.css' );
    wp_enqueue_style( 'pe-icon-7-stroke', MAAV_THEME_ROOT . '/assets/libs/pe-icon-7-stroke/css/pe-icon-7-stroke.min.css' );
    wp_enqueue_style( 'waitme', MAAV_THEME_ROOT . '/assets/libs/waitMe/waitMe.min.css' );
    wp_enqueue_style( 'magnific-popup', MAAV_THEME_ROOT . '/assets/libs/magnific-popup/magnific-popup.css' );
    wp_enqueue_style( 'colorbox', MAAV_THEME_ROOT . '/assets/libs/colorbox/colorbox.css' );
    wp_enqueue_style( 'style', MAAV_THEME_ROOT . '/style.css' );
    wp_enqueue_style( 'main', MAAV_THEME_ROOT . '/assets/css/main.css' );

    $maav_custom_css = Kirki::get_option( 'maav', 'custom_css' );
    if ( Kirki::get_option( 'maav', 'custom_css_enable' ) == 1 ) {
        wp_add_inline_style( 'main', html_entity_decode( $maav_custom_css, ENT_QUOTES ) );
    }

    if ( Kirki::get_option( 'maav', 'nav_sticky_enable' ) == 1 ) {
        wp_enqueue_script( 'head-room-jquery', MAAV_THEME_ROOT . '/assets/libs/headroom/jQuery.headroom.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
        wp_enqueue_script( 'head-room', MAAV_THEME_ROOT . '/assets/libs/headroom/headroom.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    }

    wp_enqueue_script( 'waitMe', MAAV_THEME_ROOT . '/assets/libs/waitMe/waitMe.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'youtube-bg', MAAV_THEME_ROOT . '/assets/js/ytb.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'magnific-popup', MAAV_THEME_ROOT . '/assets/libs/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'owl-carousel', MAAV_THEME_ROOT . '/assets/libs/owl-carousel/owl.carousel.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'colorbox', MAAV_THEME_ROOT . '/assets/libs/colorbox/jquery.colorbox-min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'imagesloaded', MAAV_THEME_ROOT . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'hoverdir', MAAV_THEME_ROOT . '/assets/js/jquery.hoverdir.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'isotope-masonry', MAAV_THEME_ROOT . '/assets/libs/isotope/isotope.pkgd.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'waypoints', MAAV_THEME_ROOT . '/assets/libs/waypoints/jquery.waypoints.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'counterup', MAAV_THEME_ROOT . '/assets/libs/counterup/jquery.counterup.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'nicescroll', MAAV_THEME_ROOT . '/assets/libs/nicescroll/jquery.nicescroll.min.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_enqueue_script( 'main', MAAV_THEME_ROOT . '/assets/js/main.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    wp_localize_script( 'main', '$maav', $wnm_custom );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'woo', MAAV_THEME_ROOT . '/assets/js/woo.js', array( 'jquery' ), MAAV_PARENT_THEME_VERSION, true );
    }
}

add_action( 'wp_enqueue_scripts', 'maav_scripts' );

add_action( 'wp_enqueue_scripts', 'maav_extra_css' );

function maav_extra_css() {
	$title_bg = Maav_Helper::get_post_meta( 'title_bg', '' );
	$extra_style          = '';
    if ( $title_bg != '' ) {
        $extra_style = ".page-feature-image {
            background-image: url($title_bg)!important;
			
        }";
	} else {
		
	$p_bg = unserialize(get_post_meta(get_the_ID(), '_maav_portfolio_breadcrumb', true));
	$title_portfolio_bg = isset($p_bg['title_portfolio_bg']) ? $p_bg['title_portfolio_bg'] : '';
	$extra_style          = '';
    if ( $title_portfolio_bg != '' ) :
        $extra_style = ".single-portfolio .page-feature-image {
            background-image: url($title_portfolio_bg)!important;
			
        }"; 
	
    endif;
	}
	

    if ( $extra_style !== '' ) {
        wp_add_inline_style( 'main', html_entity_decode( $extra_style, ENT_QUOTES ) );
    }
}

require_once get_template_directory() . '/core/core.php';
require_once MAAV_INC_DIR . 'helper.php';
require_once MAAV_INC_DIR . 'customizer/customizer.php';
require_once MAAV_INC_DIR . 'oneclick.php';
require_once MAAV_INC_DIR . 'tha-theme-hooks.php';
require_once MAAV_INC_DIR . 'tgm-plugin-activation.php';
require_once MAAV_INC_DIR . 'tgm-plugin-registration.php';
require_once MAAV_INC_DIR . 'meta-boxes.php';
require_once MAAV_INC_DIR . 'widgets/widgets.php';
require_once MAAV_INC_DIR . 'custom-header.php';
require_once MAAV_INC_DIR . 'template-tags.php';
require_once MAAV_INC_DIR . 'walker-nav-menu.php';
require_once MAAV_INC_DIR . 'extras.php';
require_once MAAV_INC_DIR . 'woo.php';
if ( is_admin() ) {
    require_once MAAV_INC_DIR . 'admin.php';
}

// Extend VC
if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
    function maav_requireVcExtend() {
        require get_template_directory() . '/inc/vc-extend.php';
    }

    add_action( 'init', 'maav_requireVcExtend', 2 );
}

if ( ! function_exists( 'maav_fonts_url' ) ) {
    /**
     * Register Google fonts for Maav.
     *
     * Create your own maav_fonts_url() function to override in a child theme.
     *
     * @since Maav 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function maav_fonts_url() {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'maav' ) ) {
            $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
        }

        /* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'maav' ) ) {
            $fonts[] = 'Montserrat:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'maav' ) ) {
            $fonts[] = 'Inconsolata:400';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                                            'family' => urlencode( implode( '|', $fonts ) ),
                                            'subset' => urlencode( $subsets ),
                                        ), 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
}

function maav_excerpt_length( $length ) {
    return 100;
}

add_filter( 'excerpt_length', 'maav_excerpt_length', 999 );

add_action( 'wp_ajax_portfolio_infinite_load', 'maav_portfolio_infinite_loading' );
add_action( 'wp_ajax_nopriv_portfolio_infinite_load', 'maav_portfolio_infinite_loading' );

function maav_portfolio_infinite_loading() {
    $args = array(
        'post_type'      => $_POST['post_type'],
        'posts_per_page' => $_POST['posts_per_page'],
        'orderby'        => $_POST['orderby'],
        'order'          => $_POST['order'],
        'paged'          => $_POST['paged'],
    );

    $style             = isset( $_POST['style'] ) ? $_POST['style'] : 1;
    $overlay_style     = isset( $_POST['overlay_style'] ) ? $_POST['overlay_style'] : 'inner-text';
    $i                 = ( $args['paged'] - 1 ) * $args['posts_per_page'];
    $count             = $_POST['count'];
    $image_size        = $_POST['image_size'];
    $overlay_animation = $_POST['overlay_animation'];
    $maav_query   = new WP_Query( $args );

    if ( $maav_query->have_posts() ) :
        include( get_template_directory() . '/loop/portfolio/style-' . $style . '.php' );
    endif;
    wp_reset_postdata();
    wp_die();
}

add_action( 'wp_ajax_post_infinite_load', 'maav_post_infinite_loading' );
add_action( 'wp_ajax_nopriv_post_infinite_load', 'maav_post_infinite_loading' );

function maav_post_infinite_loading() {
    $args = array(
        'post_type'      => $_POST['post_type'],
        'posts_per_page' => $_POST['posts_per_page'],
        'orderby'        => $_POST['orderby'],
        'order'          => $_POST['order'],
        'paged'          => $_POST['paged'],
    );

    $style           = isset( $_POST['style'] ) ? $_POST['style'] : 1;
    $i               = ( $args['paged'] - 1 ) * $args['posts_per_page'];
    $count           = $_POST['count'];
    $maav_query = new WP_Query( $args );

    if ( $maav_query->have_posts() ) :
        include( get_template_directory() . '/loop/post/style-' . $style . '.php' );
    endif;
    wp_reset_postdata();
    wp_die();
}

/**
 * Filter arguments of tag cloud widget to enlarge our text and add commas
 */
function maav_filter_tag_cloud( $args ) {
    $args['smallest']  = 18;
    $args['largest']   = 32;
    $args['unit']      = 'px';
    $args['separator'] = ' , ';

    return $args;
}

add_filter( 'widget_tag_cloud_args', 'maav_filter_tag_cloud' );

add_filter( 'demo_options_settings', function ( $settings ) {
    $op = '.maav-posts.style-4 .post-categories, .woocommerce .product .price ins, .woocommerce .widget_price_filter .price_slider_amount .button:hover, #primary-menu li.current-menu-parent > a, #primary-menu li.current-menu-item > a, .maav-heading.style-2 .heading-text, .btn-filter.current, .maav-posts .post-categories a, .related-portfolio-title.related-portfolio-title a:hover, .related-portfolio-categories.related-portfolio-categories a:hover, .maav-portfolios .portfolio-title.portfolio-title a:hover, .maav-portfolios .portfolio-categories.portfolio-categories a:hover, .maav-button.style-2:hover, .maav-button.style-2:focus, .maav-pricing-table.style-1 .maav-pricing-heading, .social-networks-widget .social-network-list a:hover,.maav-counter.style-1 .counter, .primary-color, #maav-esg-our-work .esg-filterbutton.selected, .maav-recent-posts .post-categories a, .maav-our-team .our-team-social-networks a:hover, .maav-box-icon:hover .heading, .maav-box-icon.style-4:hover .icon, .woocommerce-cart .cart-collaterals .cart_totals tr.order-total th, .woocommerce-cart .cart-collaterals .cart_totals tr.order-total, .woocommerce div.product .stock { color: $value; }';
    $op .= '.primary-bgcolor, .vc_progress_bar.vc_progress-bar-color-main_color .vc_general.vc_single_bar .vc_bar, .maav-grid-wrapper .filter-counter, .onsale {background-color: $value }';
    $op .= '.primary-border-color, .maav-box-icon.style-2 .icon { border-color: $value }';
    $op .= '.maav-grid-wrapper .filter-counter:before { border-top-color: $value }';

    $op .= '.header01 .primary-menu-wrap a:hover, .header01 .primary-menu-wrap .current-menu-ancestor > a, .header01 .primary-menu-wrap .current-menu-parent > a, .header01 .primary-menu-wrap .current-menu-item > a { color: $value; }';
    $op .= '.header02 .primary-menu-wrap a:hover, .header02 .primary-menu-wrap .current-menu-ancestor > a, .header02 .primary-menu-wrap .current-menu-parent > a, .header02 .primary-menu-wrap .current-menu-item > a { color: $value; }';
    $op .= '.header03 .primary-menu-wrap a:hover, .header03 .primary-menu-wrap .current-menu-ancestor > a, .header03 .primary-menu-wrap .current-menu-parent > a, .header03 .primary-menu-wrap .current-menu-item > a { color: $value; }';
    $op .= '.header04 .primary-menu-wrap a:hover, .header04 .primary-menu-wrap .current-menu-ancestor > a, .header04 .primary-menu-wrap .current-menu-parent > a, .header04 .primary-menu-wrap .current-menu-item > a { color: $value; }';
    $op .= '.header05 .primary-menu-wrap a:hover, .header05 .primary-menu-wrap .current-menu-ancestor > a, .header05 .primary-menu-wrap .current-menu-parent > a, .header05 .primary-menu-wrap .current-menu-item > a { color: $value; }';

    $op .= '.mini-cart .mini-cart__button .mini-cart-icon:after { background-color: $value; }';

    $op .= 'a:hover, a:focus { color: $value }';

    // Top footer link hover color
    $op .= '.page-top-footer a:hover, .page-top-footer a:focus { color: $value }';

    return array_merge( $settings, array(
        array(
            'id'       => 'maav_custom',
            'label'    => 'Custom',
            'settings' => array(
                array(
                    'settings'  => 'color_preset',
                    'type'      => 'colorpattern',
                    'label'     => 'Primary Color',
                    'transport' => 'postMessage',
                    'default'   => 'red',
                    'choices'   => array(
                        '#3467b7' => '#3467b7',
                        '#F43837' => '#F43837',
                        '#13929E' => '#13929E',
                        '#ED9F17' => '#ED9F17',
                        '#3E923A' => '#3E923A',
                        '#883B81' => '#883B81',
                        '#EC6420' => '#EC6420',
                        '#47AFE8' => '#47AFE8',
                        '#8A3D28' => '#8A3D28',
                        '#BBA16C' => '#BBA16C',
                        '#1EC3A4' => '#1EC3A4',
                        '#96B2B7' => '#96B2B7',
                    ),
                    'output'    => $op,
                ),
                array(
                    'settings'  => 'primary_color',
                    'type'      => 'color',
                    'label'     => 'Color Picker',
                    'transport' => 'postMessage',
                    'default'   => '#3467b7',
                    'value'     => '#3467b7',
                    'output'    => $op,
                ),
                array(
                    'settings'  => 'box_mode',
                    'type'      => 'buttonset',
                    'label'     => 'Layout',
                    'transport' => 'reload',
                    'reload'    => 'param',
                    'default'   => '0',
                    'choices'   => array(
                        '1' => 'Boxed',
                        '0' => 'Wide',
                    ),
                ),
                array(
                    'settings'  => 'background_pattern',
                    'type'      => 'imagepattern',
                    'label'     => 'Background Pattern',
                    'transport' => 'postMessage',
                    'default'   => '',
                    'choices'   => array(
                        DEMO_OPTIONS_URL . 'assets/patterns/1.png'  => DEMO_OPTIONS_URL . 'assets/patterns/1.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/2.png'  => DEMO_OPTIONS_URL . 'assets/patterns/2.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/3.png'  => DEMO_OPTIONS_URL . 'assets/patterns/3.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/4.png'  => DEMO_OPTIONS_URL . 'assets/patterns/4.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/5.png'  => DEMO_OPTIONS_URL . 'assets/patterns/5.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/6.png'  => DEMO_OPTIONS_URL . 'assets/patterns/6.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/7.png'  => DEMO_OPTIONS_URL . 'assets/patterns/7.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/8.png'  => DEMO_OPTIONS_URL . 'assets/patterns/8.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/9.png'  => DEMO_OPTIONS_URL . 'assets/patterns/9.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/11.png' => DEMO_OPTIONS_URL . 'assets/patterns/11.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/12.png' => DEMO_OPTIONS_URL . 'assets/patterns/12.png',
                        DEMO_OPTIONS_URL . 'assets/patterns/13.png' => DEMO_OPTIONS_URL . 'assets/patterns/13.png',
                    ),
                    'output'    => 'body {background-image: url("$value"); background-size:auto; background-repeat: repeat; background-attachment: fixed;}',
                ),
                array(
                    'settings'  => 'background_pattern',
                    'type'      => 'imagepattern',
                    'label'     => 'Background Image',
                    'transport' => 'postMessage',
                    'default'   => '',
                    'choices'   => array(
                        DEMO_OPTIONS_URL . 'assets/patterns/bg1.jpg' => DEMO_OPTIONS_URL . 'assets/patterns/bg1.jpg',
                        DEMO_OPTIONS_URL . 'assets/patterns/bg2.jpg' => DEMO_OPTIONS_URL . 'assets/patterns/bg2.jpg',
                        DEMO_OPTIONS_URL . 'assets/patterns/bg3.jpg' => DEMO_OPTIONS_URL . 'assets/patterns/bg3.jpg',
                        DEMO_OPTIONS_URL . 'assets/patterns/bg4.jpg' => DEMO_OPTIONS_URL . 'assets/patterns/bg4.jpg',
                    ),
                    'output'    => 'body {background-image: url("$value"); background-size:cover; background-repeat: no-repeat; background-attachment: fixed;}',
                ),
            ),
        ),
    ) );
} );
/*
* Like Button function
*/

/*
Name:  WordPress Post Like System
Description:  A simple and efficient post like system for WordPress.
Version:      0.5.2
Author:       Jon Masterson
Author URI:   http://jonmasterson.com/
License:
Copyright (C) 2015 Jon Masterson
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 * Register the stylesheets for the public-facing side of the site.
 * @since    0.5
 */
add_action( 'wp_enqueue_scripts', 'maav_sl_enqueue_scripts' );
function maav_sl_enqueue_scripts() {
	wp_enqueue_script( 'simple-likes-public-js', get_template_directory_uri() . '/assets/js/simple-likes-public.js', array( 'jquery' ), '0.5', false );
	wp_localize_script( 'simple-likes-public-js', 'simpleLikes', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'like' => esc_html__( 'Like', 'maav' ),
		'unlike' => esc_html__( 'Unlike', 'maav' )
	) ); 
}
/**
 * Processes like/unlike
 * @since    0.5
 */
add_action( 'wp_ajax_nopriv_maav_process_simple_like', 'maav_process_simple_like' );
add_action( 'wp_ajax_maav_process_simple_like', 'maav_process_simple_like' );
function maav_process_simple_like() {
	// Security
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
	if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
		exit( esc_html__( 'Not permitted', 'maav' ) );
	}
	// Test if javascript is disabled
	$disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
	// Test if this is a comment
	$is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
	// Base variables
	$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
	$result = array();
	$post_users = NULL;
	$like_count = 0;
	// Get plugin options
	if ( $post_id != '' ) {
		$count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
		$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
		if ( !maav_already_liked( $post_id, $is_comment ) ) { // Like the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = maav_post_user_likes( $user_id, $post_id, $is_comment );
				if ( $is_comment == 1 ) {
					// Update User & Comment
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					}
				} else {
					// Update User & Post
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_user_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
				$user_ip = maav_sl_get_ip();
				$post_users = maav_post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ++$count;
			$response['status'] = "liked";
			$response['icon'] = maav_get_liked_icon();
		} else { // Unlike the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = maav_post_user_likes( $user_id, $post_id, $is_comment );
				// Update User
				if ( $is_comment == 1 ) {
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, "_comment_like_count", --$user_like_count );
					}
				} else {
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, '_user_like_count', --$user_like_count );
					}
				}
				// Update Post
				if ( $post_users ) {	
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[$uid_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
				$user_ip = maav_sl_get_ip();
				$post_users = maav_post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					$uip_key = array_search( $user_ip, $post_users );
					unset( $post_users[$uip_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
			$response['status'] = "unliked";
			$response['icon'] = maav_get_unliked_icon();
		}
		if ( $is_comment == 1 ) {
			update_comment_meta( $post_id, "_comment_like_count", $like_count );
			update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
		} else { 
			update_post_meta( $post_id, "_post_like_count", $like_count );
			update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
		}
		$response['count'] = maav_get_like_count( $like_count );
		$response['testing'] = $is_comment;
		if ( $disabled == true ) {
			if ( $is_comment == 1 ) {
				wp_redirect( get_permalink( get_the_ID() ) );
				exit();
			} else {
				wp_redirect( get_permalink( $post_id ) );
				exit();
			}
		} else {
			wp_send_json( $response );
		}
	}
}
/**
 * maav_vpm_remove_meta_box
 */
function maav_vpm_remove_meta_box() {
	remove_meta_box( 'postcustom', 'portfolio', 'normal' );
	remove_meta_box( 'postexcerpt', 'portfolio', 'normal' );
	remove_meta_box( 'authordiv', 'portfolio', 'normal' );
	remove_meta_box( 'commentsdiv', 'portfolio', 'normal' );
	remove_meta_box( 'commentstatusdiv', 'portfolio', 'normal' );
	remove_meta_box( 'revisionsdiv', 'portfolio', 'normal' );
}
add_action( 'add_meta_boxes', 'maav_vpm_remove_meta_box' );
/**
 * Utility to test if the post is already liked
 * @since    0.5
 */
function maav_already_liked( $post_id, $is_comment ) {
	$post_users = NULL;
	$user_id = NULL;
	if ( is_user_logged_in() ) { // user is logged in
		$user_id = get_current_user_id();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
	} else { // user is anonymous
		$user_id = maav_sl_get_ip();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" ); 
		if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
			$post_users = $post_meta_users[0];
		}
	}
	if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
		return true;
	} else {
		return false;
	}
} // maav_already_liked()
/**
 * Output the like button
 * @since    0.5
 */
function maav_get_simple_likes_button( $post_id, $is_comment = NULL ) {
	$is_comment = ( NULL == $is_comment ) ? 0 : 1;
	$output = '';
	$nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
	if ( $is_comment == 1 ) {
		$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
		$comment_class = esc_attr( ' sl-comment' );
		$like_count = get_comment_meta( $post_id, "_comment_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	} else {
		$post_id_class = esc_attr( ' sl-button-' . $post_id );
		$comment_class = esc_attr( '' );
		$like_count = get_post_meta( $post_id, "_post_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	}
	$count = maav_get_like_count( $like_count );
	$icon_empty = maav_get_unliked_icon();
	$icon_full = maav_get_liked_icon();
	// Loader
	$loader = '<span id="sl-loader"></span>';
	// Liked/Unliked Variables
	if ( maav_already_liked( $post_id, $is_comment ) ) {
		$class = esc_attr( ' liked' );
		$title = esc_html__( 'Unlike', 'maav' );
		$icon = $icon_full;
	} else {
		$class = '';
		$title = esc_html__( 'Like', 'maav' );
		$icon = $icon_empty;
	}
	$output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=maav_process_simple_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';
	return $output;
} // maav_get_simple_likes_button()
/**
 * Utility retrieves post meta user likes (user id array), 
 * then adds new user id to retrieved array
 * @since    0.5
 */
function maav_post_user_likes( $user_id, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_id, $post_users ) ) {
		$post_users['user-' . $user_id] = $user_id;
	}
	return $post_users;
} // maav_post_user_likes()
/**
 * Utility retrieves post meta ip likes (ip array), 
 * then adds new ip to retrieved array
 * @since    0.5
 */
function maav_post_ip_likes( $user_ip, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
	// Retrieve post information
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_ip, $post_users ) ) {
		$post_users['ip-' . $user_ip] = $user_ip;
	}
	return $post_users;
} // maav_post_ip_likes()
/**
 * Utility to retrieve IP address
 * @since    0.5
 */
function maav_sl_get_ip() {
	if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	}
	$ip = filter_var( $ip, FILTER_VALIDATE_IP );
	$ip = ( $ip === false ) ? '0.0.0.0' : $ip;
	return $ip;
} // maav_sl_get_ip()
/**
 * Utility returns the button icon for "like" action
 * @since    0.5
 */
function maav_get_liked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
	$icon = '<span class="sl-icon"><i class="fa fa-heart"></i></span>';
	return $icon;
} // maav_get_liked_icon()
/**
 * Utility returns the button icon for "unlike" action
 * @since    0.5
 */
function maav_get_unliked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
	$icon = '<span class="sl-icon"><i class="fa fa-heart-o"></i></span>';
	return $icon;
} // maav_get_unliked_icon()
/**
 * Utility function to format the button count,
 * appending "K" if one thousand or greater,
 * "M" if one million or greater,
 * and "B" if one billion or greater (unlikely).
 * $precision = how many decimal points to display (1.25K)
 * @since    0.5
 */
function maav_sl_format_count( $number ) {
	$precision = 2;
	if ( $number >= 1000 && $number < 1000000 ) {
		$formatted = number_format( $number/1000, $precision ).'K';
	} else if ( $number >= 1000000 && $number < 1000000000 ) {
		$formatted = number_format( $number/1000000, $precision ).'M';
	} else if ( $number >= 1000000000 ) {
		$formatted = number_format( $number/1000000000, $precision ).'B';
	} else {
		$formatted = $number; // Number is less than 1000
	}
	$formatted = str_replace( '.00', '', $formatted );
	return $formatted;
} // maav_sl_format_count()
/**
 * Utility retrieves count plus count options, 
 * returns appropriate format based on options
 * @since    0.5
 */
function maav_get_like_count( $like_count ) {
	$like_text = esc_html__( 'Like', 'maav' );
	if ( is_numeric( $like_count ) && $like_count > 0 ) { 
		$number = maav_sl_format_count( $like_count );
	} else {
		$number = maav_sl_format_count( $like_count );
	}
	$count = '<span class="sl-count">' . esc_html ( $number ) . '</span>';
	return $count;
} // maav_get_like_count()
// User Profile List
add_action( 'show_user_profile', 'maav_show_user_likes' );
add_action( 'edit_user_profile', 'maav_show_user_likes' );
function maav_show_user_likes( $user ) { ?>        
	<table class="form-table">
		<tr>
			<th><label for="user_likes"><?php esc_html_e( 'You Like:', 'maav' ); ?></label></th>
			<td>
				<?php
					$types = get_post_types( array( 'public' => true ) );
					$args = array(
					'numberposts' => -1,
					'post_type' => $types,
					'meta_query' => array (
						array (
						'key' => '_user_liked',
						'value' => $user->ID,
						'compare' => 'LIKE'
						)
					) );		
			$sep = '';
			$like_query = new WP_Query( $args );
			if ( $like_query->have_posts() ) : ?>
				<p>
					<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
					echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					<?php
						$sep = ' &middot; ';
					endwhile; 
					?>
				</p>
			<?php else : ?>
				<p><?php esc_html_e( 'You do not like anything yet.', 'maav' ); ?></p>
			<?php 
			endif; 
				wp_reset_postdata(); 
			?>
			</td>
		</tr>
	</table>
<?php } // maav_show_user_likes()