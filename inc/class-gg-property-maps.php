<?php

class GG_Property_Maps {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts() {
        if (is_singular('property')) {
            wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
            wp_enqueue_script('gg-property-map', get_template_directory_uri() . '/assets/js/property-map.js', array('leaflet-js'), '1.0', true);
            wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
            
            $property_location = get_post_meta(get_the_ID(), '_property_location', true);
            wp_localize_script('gg-property-map', 'ggMapData', array(
                'location' => $property_location
            ));
        }
    }
}

new GG_Property_Maps();
