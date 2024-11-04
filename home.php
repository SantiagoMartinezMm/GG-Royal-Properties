<?php
/**
 * Template for displaying the home page with featured properties.
 */

get_header(); ?>

<div class="home-page">
    <div class="hero-section">
        <div class="container">
            <h1>Bienvenido a G&G Royal Propiedades</h1>
            <p>Encuentra la propiedad perfecta para ti.</p>
            <?php dynamic_sidebar('property-search-sidebar'); ?>
        </div>
    </div>

    <div class="container">
        <header class="home-header">
            <h1><?php esc_html_e('Propiedades Destacadas', 'gg-royal-properties'); ?></h1>
            <p><?php esc_html_e('Descubre nuestras propiedades más exclusivas.', 'gg-royal-properties'); ?></p>
        </header>

        <div class="properties-featured">
            <div class="properties-grid">
                <?php
                // Query for featured properties
                $featured_args = array(
                    'post_type' => 'property',
                    'posts_per_page' => 6,
                    'meta_key' => '_property_featured',
                    'meta_value' => 'yes',
                );
                $featured_query = new WP_Query($featured_args);

                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
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
                                    $<?php echo number_format(get_post_meta(get_the_ID(), '_property_price', true)); ?>
                                </div>
                                <div class="property-location">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_property_location', true)); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p><?php esc_html_e('No se encontraron propiedades destacadas.', 'gg-royal-properties'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- About Us Section -->
        <div class="about-section">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <p>En G&G Royal Propiedades nos dedicamos a ofrecer las mejores opciones inmobiliarias para ti. Nuestro equipo se encarga de acompañarte en cada paso del proceso de compra, venta o alquiler de propiedades.</p>
            </div>
        </div>

        <!-- Latest Posts Section -->
        <div class="latest-posts">
            <h2><?php esc_html_e('Últimas Publicaciones', 'gg-royal-properties'); ?></h2>
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <h3 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </header>
                            <div class="entry-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php the_posts_pagination(array(
                        'prev_text' => __('Anterior', 'gg-royal-properties'),
                        'next_text' => __('Siguiente', 'gg-royal-properties'),
                    )); ?>
                </div>
            <?php else : ?>
                <p><?php esc_html_e('No se encontraron publicaciones.', 'gg-royal-properties'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
