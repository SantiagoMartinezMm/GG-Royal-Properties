<?php

class GG_Property_Search {
    public function __construct() {
        add_action('wp_ajax_gg_advanced_property_search', array($this, 'handle_advanced_search'));
        add_action('wp_ajax_nopriv_gg_advanced_property_search', array($this, 'handle_advanced_search'));
    }

    public function handle_advanced_search() {
        check_ajax_referer('gg_advanced_search_nonce', 'nonce');

        $args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
            'meta_query' => array(),
            'tax_query' => array(),
        );

        // Filtrar por ubicación
        if (!empty($_POST['location'])) {
            $args['meta_query'][] = array(
                'key' => '_property_location',
                'value' => sanitize_text_field($_POST['location']),
                'compare' => 'LIKE'
            );
        }

        // Filtrar por tipo de propiedad
        if (!empty($_POST['property_type'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($_POST['property_type'])
            );
        }

        // Filtrar por rango de precios
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

        // Filtrar por estado de la propiedad
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
}

new GG_Property_Search();

