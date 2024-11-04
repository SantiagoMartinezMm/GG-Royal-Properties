<?php
/**
 * Template Name: Contacto Propiedad
 * Description: Página de contacto específica para una propiedad en particular.
 */

get_header(); ?>

<div class="container">
    <header class="contact-header">
        <h1><?php esc_html_e('Contacto para esta Propiedad', 'gg-royal-properties'); ?></h1>
        <p><?php esc_html_e('Por favor, completa el formulario para solicitar más información.', 'gg-royal-properties'); ?></p>
    </header>

    <div class="property-contact-form">
        <?php
        // Información de la propiedad
        if (isset($_GET['property_id'])) {
            $property_id = intval($_GET['property_id']);
            $property_title = get_the_title($property_id);
            $property_price = get_post_meta($property_id, '_property_price', true);
            $property_location = get_post_meta($property_id, '_property_location', true);

            if ($property_id && get_post_status($property_id) === 'publish') {
                ?>
                <div class="property-details">
                    <h2><?php echo esc_html($property_title); ?></h2>
                    <p><strong><?php esc_html_e('Precio:', 'gg-royal-properties'); ?></strong> <?php echo esc_html($property_price); ?></p>
                    <p><strong><?php esc_html_e('Ubicación:', 'gg-royal-properties'); ?></strong> <?php echo esc_html($property_location); ?></p>
                </div>
                <?php
            }
        }
        ?>

        <!-- Contact Form -->
        <div class="contact-form">
            <?php
            if (shortcode_exists('contact-form-7')) {
                echo do_shortcode('[contact-form-7 id="contact-form" title="Formulario de Contacto"]');
            } else {
                esc_html_e('Por favor instala y activa Contact Form 7 para habilitar el formulario de contacto.', 'gg-royal-properties');
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
