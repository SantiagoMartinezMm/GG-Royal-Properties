<?php
/**
 * Template for displaying the archive of properties.
 */

get_header(); ?>

<div class="properties-archive">
    <div class="container">
        <header class="archive-header">
            <h1><?php esc_html_e('Todas las Propiedades', 'gg-royal-properties'); ?></h1>
        </header>

        <div class="properties-filters">
            <?php dynamic_sidebar('property-search-sidebar'); ?>
        </div>

        <div class="properties-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="property-card">
                        <div class="property-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('property-thumbnail'); ?>
                                </a>
                            <?php endif; ?>
                            <div class="property-status">
                                <?php
                                $status_terms = get_the_terms(get_the_ID(), 'property_status');
                                if ($status_terms && !is_wp_error($status_terms)) {
                                    echo esc_html($status_terms[0]->name);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="property-details">
                            <h2 class="property-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="property-price">
                                $<?php echo number_format(get_post_meta(get_the_ID(), '_property_price', true)); ?>
                            </div>
                            <div class="property-location">
                                <?php echo esc_html(get_post_meta(get_the_ID(), '_property_location', true)); ?>
                            </div>
                            <div class="property-features">
                                <span class="feature">
                                    <i class="fas fa-bed"></i>
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bedrooms', true)); ?> <?php esc_html_e('Habitaciones', 'gg-royal-properties'); ?>
                                </span>
                                <span class="feature">
                                    <i class="fas fa-bath"></i>
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_bathrooms', true)); ?> <?php esc_html_e('Baños', 'gg-royal-properties'); ?>
                                </span>
                                <span class="feature">
                                    <i class="fas fa-vector-square"></i>
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_area', true)); ?> m²
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <!-- Pagination -->
                <div class="pagination">
                    <?php the_posts_pagination(array(
                        'prev_text' => __('Anterior', 'gg-royal-properties'),
                        'next_text' => __('Siguiente', 'gg-royal-properties'),
                    )); ?>
                </div>
            <?php else : ?>
                <p><?php esc_html_e('No se encontraron propiedades.', 'gg-royal-properties'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
