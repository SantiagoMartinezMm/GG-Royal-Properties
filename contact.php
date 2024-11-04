<?php
/**
 * Template Name: Contacto
 * Description: Página de contacto para G&G Royal Propiedades
 */

get_header(); ?>

<div class="contact-page">
    <div class="container">
        <header class="contact-header">
            <h1><?php esc_html_e('Contáctanos', 'gg-royal-properties'); ?></h1>
            <p><?php esc_html_e('Estamos aquí para ayudarte con todas tus consultas sobre propiedades.', 'gg-royal-properties'); ?></p>
        </header>

        <!-- Contact Form Section -->
        <div class="contact-form-section">
            <h2><?php esc_html_e('Envíanos un Mensaje', 'gg-royal-properties'); ?></h2>
            <?php 
            // Si estás usando Contact Form 7, asegúrate de reemplazar 'contact-form' con el ID o título correcto de tu formulario
            echo do_shortcode('[contact-form-7 id="contact-form" title="Formulario de Contacto"]'); 
            ?>
        </div>

        <!-- Contact Details Section -->
        <div class="contact-details-section">
            <h2><?php esc_html_e('Detalles de Contacto', 'gg-royal-properties'); ?></h2>
            <p><strong><?php esc_html_e('Teléfono:', 'gg-royal-properties'); ?></strong> +56 9 1234 5678</p>
            <p><strong><?php esc_html_e('Correo Electrónico:', 'gg-royal-properties'); ?></strong> <a href="mailto:info@ggroyalpropiedades.com">info@ggroyalpropiedades.com</a></p>
            <p><strong><?php esc_html_e('Dirección:', 'gg-royal-properties'); ?></strong> Calle Falsa 123, Santiago, Chile</p>
        </div>

        <!-- Map Section -->
        <div class="contact-map-section">
            <h2><?php esc_html_e('Encuéntranos Aquí', 'gg-royal-properties'); ?></h2>
            <div id="contact-map" class="property-map"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa el mapa usando Leaflet en lugar de Google Maps
        const map = L.map('contact-map').setView([-33.4489, -70.6693], 13); // Coordenadas de Santiago, Chile

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([-33.4489, -70.6693]).addTo(map)
            .bindPopup('G&G Royal Propiedades')
            .openPopup();
    });
</script>

<?php get_footer(); ?>
