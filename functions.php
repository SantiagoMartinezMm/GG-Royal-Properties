<?php
/**
 * Theme functions and definitions.
 */

// Include required files
require_once get_template_directory() . '/inc/class-gg-property-cpt.php';
require_once get_template_directory() . '/inc/class-gg-property-maps.php';
require_once get_template_directory() . '/inc/class-gg-property-favorites.php';
require_once get_template_directory() . '/inc/class-gg-property-search.php';
require_once get_template_directory() . '/inc/class-gg-property-advanced-search.php';
require_once get_template_directory() . '/inc/class-gg-property-api.php';

// Enqueue Scripts and Styles
function gg_enqueue_scripts() {
    // Styles
    wp_enqueue_style('gg-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_style('gg-secondary-style', get_template_directory_uri() . '/assets/css/secondary_stylesheet.css', array(), '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');

    // Scripts
    wp_enqueue_script('gg-main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
    wp_enqueue_script('gg-advanced-search', get_template_directory_uri() . '/assets/js/advanced-search.js', array('jquery'), '1.0.0', true);
    
    if (is_singular('property')) {
        wp_enqueue_script('gg-favorites', get_template_directory_uri() . '/assets/js/favorites.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('gg-property-map', get_template_directory_uri() . '/assets/js/property-map.js', array('leaflet-js'), '1.0.0', true);
        wp_enqueue_media();
    }
}
add_action('wp_enqueue_scripts', 'gg_enqueue_scripts');

// Register Sidebars
function gg_register_sidebars() {
    register_sidebar(array(
        'name' => 'Búsqueda de Propiedades',
        'id' => 'property-search-sidebar',
        'description' => 'Widget área para el formulario de búsqueda de propiedades',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}
add_action('widgets_init', 'gg_register_sidebars');

// Add image sizes
add_image_size('property-thumbnail', 400, 300, true);
add_image_size('property-large', 1200, 800, true);
add_image_size('property-gallery', 800, 600, true);

// Add theme support
function gg_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'gg_theme_support');

// AJAX handler for advanced property search
function gg_advanced_property_search() {
    check_ajax_referer('gg_advanced_search_nonce', 'nonce');

    $args = array(
        'post_type' => 'property',
        'posts_per_page' => -1,
        'meta_query' => array(),
        'tax_query' => array(),
    );

    if (!empty($_POST['location'])) {
        $args['meta_query'][] = array(
            'key' => '_property_location',
            'value' => sanitize_text_field($_POST['location']),
            'compare' => 'LIKE'
        );
    }

    if (!empty($_POST['property_type'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['property_type'])
        );
    }

    if (!empty($_POST['price_range'])) {
        list($min_price, $max_price) = explode('-', sanitize_text_field($_POST['price_range']));
        if ($min_price) {
            $args['meta_query'][] = array(
                'key' => '_property_price',
                'value' => (int) $min_price,
                'type' => 'NUMERIC',
                'compare' => '>='
            );
        }
        if ($max_price && $max_price !== '+') {
            $args['meta_query'][] = array(
                'key' => '_property_price',
                'value' => (int) $max_price,
                'type' => 'NUMERIC',
                'compare' => '<='
            );
        }
    }

    if (!empty($_POST['property_status'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'property_status',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['property_status'])
        );
    }

    $properties = new WP_Query($args);
    $results = array();

    if ($properties->have_posts()) {
        while ($properties->have_posts()) {
            $properties->the_post();
            $results[] = array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'price' => get_post_meta(get_the_ID(), '_property_price', true),
                'location' => get_post_meta(get_the_ID(), '_property_location', true),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'property-thumbnail')
            );
        }
    }
    wp_reset_postdata();

    wp_send_json_success($results);
}
add_action('wp_ajax_nopriv_gg_advanced_property_search', 'gg_advanced_property_search');
add_action('wp_ajax_gg_advanced_property_search', 'gg_advanced_property_search');
