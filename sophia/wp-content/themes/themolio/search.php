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
            <?php get_template_part('content', 'search'); ?>
        <?php endwhile; ?>
        <?php themolio_get_pagination(); ?>
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