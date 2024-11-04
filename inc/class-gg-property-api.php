<?php

class GG_Property_API {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    // Registrar rutas de la API REST
    public function register_routes() {
        register_rest_route('gg/v1', '/properties/', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_properties'),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('gg/v1', '/property/(?P<id>\d+)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_property'),
            'permission_callback' => '__return_true',
        ));
    }

    // Obtener todas las propiedades
    public function get_properties($request) {
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => $request->get_param('per_page') ?: -1,
            'paged' => $request->get_param('page') ?: 1,
        );

        $properties = new WP_Query($args);
        $results = array();

        if ($properties->have_posts()) {
            while ($properties->have_posts()) {
                $properties->the_post();
                $results[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'price' => get_post_meta(get_the_ID(), '_property_price', true),
                    'location' => get_post_meta(get_the_ID(), '_property_location', true),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'property-thumbnail'),
                    'bedrooms' => get_post_meta(get_the_ID(), '_property_bedrooms', true),
                    'bathrooms' => get_post_meta(get_the_ID(), '_property_bathrooms', true),
                    'area' => get_post_meta(get_the_ID(), '_property_area', true),
                );
            }
            wp_reset_postdata();
        }

        return rest_ensure_response($results);
    }

    // Obtener detalles de una propiedad
    public function get_property($request) {
        $property_id = $request['id'];

        if (!get_post($property_id)) {
            return new WP_Error('no_property', 'No se encontró la propiedad', array('status' => 404));
        }

        $property = array(
            'id' => $property_id,
            'title' => get_the_title($property_id),
            'permalink' => get_permalink($property_id),
            'price' => get_post_meta($property_id, '_property_price', true),
            'location' => get_post_meta($property_id, '_property_location', true),
            'thumbnail' => get_the_post_thumbnail_url($property_id, 'property-large'),
            'bedrooms' => get_post_meta($property_id, '_property_bedrooms', true),
            'bathrooms' => get_post_meta($property_id, '_property_bathrooms', true),
            'area' => get_post_meta($property_id, '_property_area', true),
            'features' => get_post_meta($property_id, '_property_features', true),
            'gallery' => $this->get_gallery_images($property_id),
        );

        return rest_ensure_response($property);
    }

    // Obtener galería de imágenes de la propiedad
    private function get_gallery_images($property_id) {
        $gallery_images = get_post_meta($property_id, '_property_gallery_images', true);
        $images = array();

        if ($gallery_images) {
            foreach ($gallery_images as $image_id) {
                $images[] = wp_get_attachment_url($image_id);
            }
        }

        return $images;
    }
}

new GG_Property_API();
