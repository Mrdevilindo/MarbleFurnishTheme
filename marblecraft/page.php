<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main id="main" class="site-main container mx-auto my-8 px-4">

    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden'); ?>>
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-auto object-cover']); ?>
                </div>
            <?php endif; ?>
            
            <div class="p-6">
                <div class="entry-content prose max-w-none">
                    <?php the_content(); ?>
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'marblecraft'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
