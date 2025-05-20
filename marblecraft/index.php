<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header(); ?>

<main id="main" class="site-main container mx-auto my-8 px-4">

    <?php if (have_posts()) : ?>

        <header class="page-header mb-8">
            <?php if (is_home() && !is_front_page()) : ?>
                <h1 class="page-title text-3xl font-bold"><?php single_post_title(); ?></h1>
            <?php else : ?>
                <h1 class="page-title text-3xl font-bold"><?php esc_html_e('Latest Posts', 'marblecraft'); ?></h1>
            <?php endif; ?>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-4">
                        <header class="entry-header mb-4">
                            <?php the_title('<h2 class="entry-title text-xl font-bold"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="hover:text-blue-600">', '</a></h2>'); ?>
                            
                            <div class="entry-meta text-sm text-gray-600">
                                <?php
                                printf(
                                    esc_html__('Posted on %s', 'marblecraft'),
                                    '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>'
                                );
                                ?>
                            </div>
                        </header>
                        
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <footer class="entry-footer mt-4">
                            <a href="<?php the_permalink(); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 px-4 rounded-md">
                                <?php esc_html_e('Read More', 'marblecraft'); ?>
                            </a>
                        </footer>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php if (get_the_posts_pagination()) : ?>
            <div class="pagination-container mt-8">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('Previous', 'marblecraft'),
                    'next_text' => __('Next', 'marblecraft'),
                    'class'     => 'flex justify-center',
                ));
                ?>
            </div>
        <?php endif; ?>

    <?php else : ?>

        <div class="no-results bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4"><?php esc_html_e('Nothing Found', 'marblecraft'); ?></h2>
            <div class="page-content">
                <?php if (is_search()) : ?>
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'marblecraft'); ?></p>
                    <?php get_search_form(); ?>
                <?php else : ?>
                    <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'marblecraft'); ?></p>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>