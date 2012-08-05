<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options, $isThemolioMobile; ?>
<?php get_header(); ?>
<div class="container">
    <?php if( have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <?php get_template_part('content', 'single'); ?>
            <div class="post-navigation clearfix">
                <span class="nav-previous"><?php previous_post_link( '%link', __( '&laquo; Previous', 'themolio') ); ?></span>
                <span class="nav-next"><?php next_post_link( '%link', __( 'Next &raquo;', 'themolio') ); ?></span>
            </div>
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
<?php if(!$isThemolioMobile): ?>
    <?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>