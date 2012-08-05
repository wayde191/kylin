<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options, $isThemolioMobile; ?>
<?php get_header(); ?>
<div class="container<?php themolio_fullwidth_class(); ?>">
    <?php if( have_posts()) : ?>
        <?php if($themolio_options['blog_style'] == 'grid' and !$isThemolioMobile): ?>
            <?php get_template_part('content', 'grid'); ?>
        <?php else: ?>
            <?php while(have_posts()) : the_post(); ?>
                <?php get_template_part('content', get_post_format()); ?>
            <?php endwhile; ?>
        <?php endif; ?>
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
<?php if($themolio_options['blog_style'] != 'grid' and !$isThemolioMobile): ?>
    <?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>