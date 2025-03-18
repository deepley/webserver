<?php
/**
 * Template part for displaying posts
 *
 * @package NMDIAM
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    <div class="post-card-inner">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium_large', array('class' => 'post-thumbnail-img')); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="post-content">
            <header class="entry-header">
                <?php
                if (is_singular()) :
                    the_title('<h1 class="entry-title">', '</h1>');
                else :
                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                endif;

                if ('post' === get_post_type()) :
                ?>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <?php echo esc_html__('Posted on', 'nmdiam'); ?> 
                            <time><?php echo get_the_date(); ?></time>
                        </span>
                        <span class="byline">
                            <?php echo esc_html__('by', 'nmdiam'); ?> 
                            <span class="author vcard">
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php echo esc_html(get_the_author()); ?>
                                </a>
                            </span>
                        </span>
                    </div><!-- .entry-meta -->
                <?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                if (is_singular()) :
                    the_content(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'nmdiam'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        )
                    );

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'nmdiam'),
                            'after'  => '</div>',
                        )
                    );
                else :
                    the_excerpt();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="read-more-link">
                        <?php echo esc_html__('Read More', 'nmdiam'); ?>
                    </a>
                <?php
                endif;
                ?>
            </div><!-- .entry-content -->

            <?php if (is_singular()) : ?>
                <footer class="entry-footer">
                    <?php
                    // Display categories and tags
                    if ('post' === get_post_type()) {
                        $categories_list = get_the_category_list(', ');
                        if ($categories_list) {
                            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'nmdiam') . '</span>', $categories_list);
                        }

                        $tags_list = get_the_tag_list('', ', ');
                        if ($tags_list) {
                            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'nmdiam') . '</span>', $tags_list);
                        }
                    }
                    
                    // Edit Post Link
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Edit <span class="screen-reader-text">%s</span>', 'nmdiam'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer><!-- .entry-footer -->
            <?php endif; ?>
        </div><!-- .post-content -->
    </div><!-- .post-card-inner -->
</article><!-- #post-<?php the_ID(); ?> -->