<?php
/**
 * Template Name: Propiedades Favoritas
 * Description: Muestra las propiedades que los usuarios han marcado como favoritas.
 */

if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

get_header(); ?>

<div class="container">
    <header class="favorites-header">
        <h1><?php esc_html_e('Mis Propiedades Favoritas', 'gg-royal-properties'); ?></h1>
        <p><?php esc_html_e('Estas son las propiedades que has guardado como favoritas.', 'gg-royal-properties'); ?></p>
    </header>

    <div class="favorites-list">
        <div class="properties-grid">
            <?php
            $user_id = get_current_user_id();
            $favorite_properties = get_user_meta($user_id, '_favorite_properties', true);

            if (!empty($favorite_properties) && is_array($favorite_properties)) {
                $args = array(
                    'post_type' => 'property',
                    'post__in' => $favorite_properties,
                    'posts_per_page' => -1,
                );

                $favorites_query = new WP_Query($args);

                if ($favorites_query->have_posts()) :
                    while ($favorites_query->have_posts()) : $favorites_query->the_post(); ?>
                        <div class="property-card">
                            <div class="property-thumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('property-thumbnail'); ?>
                                    </a>
                                <?php endif; ?>
                                <button class="favorite-button is-favorite"
                                        data-property-id="<?php echo get_the_ID(); ?>"
                                        title="<?php esc_attr_e('Quitar de favoritos', 'gg-royal-properties'); ?>">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>

                            <div class="property-details">
                                <h2 class="property-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="property-price">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_price', true)); ?>
                                </div>
                                <div class="property-location">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_location', true)); ?>
                                </div>
                                <div class="property-features">
                                    <span class="feature">
                                        <i class="fas fa-bed"></i>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bedrooms', true)); ?>
                                    </span>
                                    <span class="feature">
                                        <i class="fas fa-bath"></i>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bathrooms', true)); ?>
                                    </span>
                                    <span class="feature">
                                        <i class="fas fa-vector-square"></i>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), '_property_area', true)); ?> m²
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p><?php esc_html_e('No tienes propiedades favoritas guardadas.', 'gg-royal-properties'); ?></p>
                <?php endif;
            } else {
                echo '<p>' . esc_html__('No tienes propiedades favoritas guardadas.', 'gg-royal-properties') . '</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
