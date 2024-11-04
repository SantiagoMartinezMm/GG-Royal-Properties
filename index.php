<?php
/**
 * The main template file.
 */

get_header(); ?>

<div class="container">
    <div class="content-area">
        <main class="site-main">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="entry-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('property-thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </header>

                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="read-more">Leer Más</a>
                        </footer>
                    </article>
                <?php endwhile; ?>

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
        </main>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <?php dynamic_sidebar('property-search-sidebar'); ?>
    </aside>
</div>

<?php get_footer(); ?>
