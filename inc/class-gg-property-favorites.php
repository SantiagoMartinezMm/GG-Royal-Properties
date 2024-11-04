<?php

class GG_Property_Favorites {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_toggle_favorite', array($this, 'toggle_favorite'));
        add_action('wp_ajax_nopriv_toggle_favorite', array($this, 'toggle_favorite'));
    }

    public function enqueue_scripts() {
        if (is_singular('property') || is_post_type_archive('property')) {
            wp_enqueue_script('gg-favorites', get_template_directory_uri() . '/assets/js/favorites.js', array('jquery'), '1.0', true);
            wp_localize_script('gg-favorites', 'ggFavoritesData', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('gg_favorites_nonce')
            ));
        }
    }

    public function toggle_favorite() {
        check_ajax_referer('gg_favorites_nonce', 'nonce');

        $property_id = isset($_POST['property_id']) ? intval($_POST['property_id']) : 0;
        $user_id = get_current_user_id();

        if (!$user_id) {
            wp_send_json_error('User not logged in');
            return;
        }

        $favorites = get_user_meta($user_id, '_favorite_properties', true);
        if (!is_array($favorites)) {
            $favorites = array();
        }

        $is_favorite = in_array($property_id, $favorites);

        if ($is_favorite) {
            $favorites = array_diff($favorites, array($property_id));
            $status = 'removed';
        } else {
            $favorites[] = $property_id;
            $status = 'added';
        }

        update_user_meta($user_id, '_favorite_properties', array_unique($favorites));

        wp_send_json_success(array(
            'status' => $status,
            'property_id' => $property_id
        ));
    }

    // Utility function to check if a property is favorite
    public static function is_favorite($property_id) {
        $user_id = get_current_user_id();
        if (!$user_id) {
            return false;
        }

        $favorites = get_user_meta($user_id, '_favorite_properties', true);
        if (!is_array($favorites)) {
            return false;
        }

        return in_array($property_id, $favorites);
    }
}

new GG_Property_Favorites();
