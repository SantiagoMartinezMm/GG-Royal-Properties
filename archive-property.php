<?php
/**
 * Template for displaying the property archive (all properties).
 */

get_header(); ?>

<div class="container properties-archive">
    <header class="archive-header">
        <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
        <p class="archive-description"><?php esc_html_e('Encuentra la propiedad perfecta para ti.', 'gg-royal-properties'); ?></p>
    </header>

    <!-- Property Search Widget -->
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
            <?php endwhile; ?>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Anterior', 'gg-royal-properties'),
                    'next_text' => __('Siguiente', 'gg-royal-properties'),
                ));
                ?>
            </div>

        <?php else : ?>
            <p><?php esc_html_e('No se encontraron propiedades disponibles.', 'gg-royal-properties'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
