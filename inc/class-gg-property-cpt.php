<?php

class GG_Property_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save_meta'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => 'Propiedades',
            'singular_name'      => 'Propiedad',
            'add_new'            => 'Añadir Nueva',
            'add_new_item'       => 'Añadir Nueva Propiedad',
            'edit_item'          => 'Editar Propiedad',
            'all_items'          => 'Todas las Propiedades',
            'view_item'          => 'Ver Propiedad',
            'search_items'       => 'Buscar Propiedades',
            'not_found'          => 'No se encontraron propiedades',
            'not_found_in_trash' => 'No hay propiedades en la papelera',
            'menu_name'          => 'Propiedades'
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'menu_icon'          => 'dashicons-building',
            'rewrite'            => array('slug' => 'propiedades'),
            'show_in_rest'       => true,
            'menu_position'      => 5,
            'capability_type'    => 'post',
            'taxonomies'         => array('property_type', 'property_status')
        );

        register_post_type('property', $args);
    }

    public function register_taxonomies() {
        // Property Type Taxonomy
        register_taxonomy('property_type', 'property', array(
            'label'             => 'Tipo de Propiedad',
            'hierarchical'      => true,
            'rewrite'           => array('slug' => 'tipo-propiedad'),
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'labels'            => array(
                'name'              => 'Tipos de Propiedad',
                'singular_name'     => 'Tipo de Propiedad',
                'search_items'      => 'Buscar Tipos',
                'all_items'         => 'Todos los Tipos',
                'parent_item'       => 'Tipo Superior',
                'parent_item_colon' => 'Tipo Superior:',
                'edit_item'         => 'Editar Tipo',
                'update_item'       => 'Actualizar Tipo',
                'add_new_item'      => 'Añadir Nuevo Tipo',
                'new_item_name'     => 'Nombre del Nuevo Tipo'
            )
        ));

        // Property Status Taxonomy
        register_taxonomy('property_status', 'property', array(
            'label'             => 'Estado',
            'hierarchical'      => true,
            'rewrite'           => array('slug' => 'estado-propiedad'),
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'labels'            => array(
                'name'              => 'Estados',
                'singular_name'     => 'Estado',
                'search_items'      => 'Buscar Estados',
                'all_items'         => 'Todos los Estados',
                'edit_item'         => 'Editar Estado',
                'update_item'       => 'Actualizar Estado',
                'add_new_item'      => 'Añadir Nuevo Estado',
                'new_item_name'     => 'Nombre del Nuevo Estado'
            )
        ));
    }

    public function register_meta_boxes() {
        add_meta_box(
            'property_details',
            'Detalles de la Propiedad',
            array($this, 'render_details_meta_box'),
            'property',
            'normal',
            'high'
        );

        add_meta_box(
            'property_gallery',
            'Galería de Imágenes',
            array($this, 'render_gallery_meta_box'),
            'property',
            'normal',
            'high'
        );
    }

    public function render_details_meta_box($post) {
        wp_nonce_field('gg_property_details', 'gg_property_details_nonce');
        
        $fields = array(
            'price'       => array('label' => 'Precio', 'type' => 'text'),
            'location'    => array('label' => 'Ubicación', 'type' => 'text', 'description' => 'Ingrese una dirección válida para el mapa'),
            'bedrooms'    => array('label' => 'Dormitorios', 'type' => 'number'),
            'bathrooms'   => array('label' => 'Baños', 'type' => 'number'),
            'area'        => array('label' => 'Área (m²)', 'type' => 'text'),
            'features'    => array('label' => 'Características Adicionales', 'type' => 'textarea', 'description' => 'Ingrese una característica por línea')
        );

        echo '<div class="property-meta-fields">';
        foreach ($fields as $key => $field) {
            $value = get_post_meta($post->ID, '_property_' . $key, true);
            echo '<p>';
            echo '<label for="property_' . $key . '">' . $field['label'] . ':</label>';
            
            if ($field['type'] === 'textarea') {
                echo '<textarea id="property_' . $key . '" name="property_' . $key . '" rows="4" class="widefat">' . esc_textarea($value) . '</textarea>';
            } else {
                echo '<input type="' . $field['type'] . '" id="property_' . $key . '" name="property_' . $key . '" value="' . esc_attr($value) . '" class="widefat">';
            }
            
            if (!empty($field['description'])) {
                echo '<small>' . $field['description'] . '</small>';
            }
            echo '</p>';
        }
        echo '</div>';
    }

    public function render_gallery_meta_box($post) {
        wp_nonce_field('gg_property_gallery', 'gg_property_gallery_nonce');
        
        $gallery_images = get_post_meta($post->ID, '_property_gallery_images', true);
        require_once get_template_directory() . '/template-parts/admin/gallery-metabox.php';
    }

    public function save_meta($post_id) {
        if (!isset($_POST['gg_property_details_nonce']) || !wp_verify_nonce($_POST['gg_property_details_nonce'], 'gg_property_details')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array(
            'property_price',
            'property_location',
            'property_bedrooms',
            'property_bathrooms',
            'property_area',
            'property_features'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }

        if (isset($_POST['property_gallery_images'])) {
            $gallery_images = explode(',', sanitize_text_field($_POST['property_gallery_images']));
            update_post_meta($post_id, '_property_gallery_images', array_filter(array_map('intval', $gallery_images)));
        }
    }
}

new GG_Property_CPT();
