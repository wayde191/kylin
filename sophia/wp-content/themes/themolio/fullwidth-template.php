<?php
/**
 * Template Name: Full-width, no sidebar
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php get_header(); ?>
<div class="container<?php themolio_fullwidth_class(); ?>">
    <?php if( have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <?php get_template_part('content', 'page'); ?>
            <?php comments_template( '', true ); ?>
        <?php endwhile; ?>
    <?php else: ?>
    <div id="post-0" class="post no-results not-found">
        <h1 class="entry-title"><?php _e('Sorry, no entries found','themolio'); ?></h1>
        <div class="entry-content">
            <p><?php _e('Try searching again...','themolio'); ?></p>
            <p><?php get_search_form(); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>