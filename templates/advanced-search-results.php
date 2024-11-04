<?php
/**
 * Template Name: Resultados de Búsqueda Avanzada
 * Description: Muestra los resultados de la búsqueda avanzada de propiedades
 */

get_header(); ?>

<div class="container">
    <header class="search-results-header">
        <h1><?php esc_html_e('Resultados de Búsqueda', 'gg-royal-properties'); ?></h1>
        <p><?php esc_html_e('Estas son las propiedades que cumplen con tus criterios de búsqueda.', 'gg-royal-properties'); ?></p>
    </header>

    <div class="search-results-list">
        <div class="properties-grid">
            <?php
            if (isset($_GET['location']) || isset($_GET['property_type']) || isset($_GET['price_range']) || isset($_GET['property_status'])) {
                $args = array(
                    'post_type' => 'property',
                    'posts_per_page' => -1,
                    'meta_query' => array(),
                    'tax_query' => array(),
                );

                if (!empty($_GET['location'])) {
                    $args['meta_query'][] = array(
                        'key' => '_property_location',
                        'value' => sanitize_text_field($_GET['location']),
                        'compare' => 'LIKE',
                    );
                }

                if (!empty($_GET['property_type'])) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'property_type',
                        'field' => 'slug',
                        'terms' => sanitize_text_field($_GET['property_type']),
                    );
                }

                if (!empty($_GET['price_range'])) {
                    list($min_price, $max_price) = explode('-', sanitize_text_field($_GET['price_range']));
                    if ($min_price) {
                        $args['meta_query'][] = array(
                            'key' => '_property_price',
                            'value' => (int)$min_price,
                            'type' => 'NUMERIC',
                            'compare' => '>=',
                        );
                    }
                    if ($max_price && $max_price !== '+') {
                        $args['meta_query'][] = array(
                            'key' => '_property_price',
                            'value' => (int)$max_price,
                            'type' => 'NUMERIC',
                            'compare' => '<=',
                        );
                    }
                }

                if (!empty($_GET['property_status'])) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'property_status',
                        'field' => 'slug',
                        'terms' => sanitize_text_field($_GET['property_status']),
                    );
                }

                $search_query = new WP_Query($args);

                if ($search_query->have_posts()) :
                    while ($search_query->have_posts()) : $search_query->the_post(); ?>
                        <div class="property-card">
                            <div class="property-thumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('property-thumbnail'); ?>
                                    </a>
                                <?php endif; ?>
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
                    <p><?php esc_html_e('No se encontraron propiedades que coincidan con tus criterios de búsqueda.', 'gg-royal-properties'); ?></p>
                <?php endif;
            } else {
                echo '<p>' . esc_html__('Por favor, utiliza el formulario de búsqueda avanzada para encontrar propiedades.', 'gg-royal-properties') . '</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
