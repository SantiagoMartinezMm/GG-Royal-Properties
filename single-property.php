<?php get_header(); ?>

<div class="single-property">
    <div class="property-gallery">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('property-large');
        }

        $gallery_images = get_post_meta(get_the_ID(), '_property_gallery_images', true);
        if ($gallery_images && is_array($gallery_images)) {
            foreach ($gallery_images as $image_id) {
                echo wp_get_attachment_image($image_id, 'property-gallery');
            }
        }
        ?>
        <button class="favorite-button<?php echo GG_Property_Favorites::is_favorite(get_the_ID()) ? ' is-favorite' : ''; ?>"
                data-property-id="<?php echo get_the_ID(); ?>"
                title="<?php echo GG_Property_Favorites::is_favorite(get_the_ID()) ? 'Quitar de favoritos' : 'Añadir a favoritos'; ?>">
            <i class="fas fa-heart"></i>
        </button>
    </div>

    <div class="property-content">
        <div class="property-header">
            <h1 class="property-title"><?php the_title(); ?></h1>
            <div class="property-price">
                $<?php echo number_format(get_post_meta(get_the_ID(), '_property_price', true)); ?>
            </div>
            <div class="property-location">
                <strong>Ubicación:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_property_location', true)); ?>
            </div>
        </div>

        <div class="property-main-features">
            <span><strong>Habitaciones:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bedrooms', true)); ?></span>
            <span><strong>Baños:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bathrooms', true)); ?></span>
            <span><strong>Área:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_property_area', true)); ?> m²</span>
        </div>

        <div class="property-description">
            <?php the_content(); ?>
        </div>

        <div class="property-location">
            <h3>Ubicación</h3>
            <p><?php echo esc_html(get_post_meta(get_the_ID(), '_property_location', true)); ?></p>
            <div id="property-map" class="property-map"></div>
        </div>

        <div class="property-contact">
            <h3>Contactar Agente</h3>
            <?php echo do_shortcode('[contact-form-7 id="contact-form" title="Contacto Propiedad"]'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
