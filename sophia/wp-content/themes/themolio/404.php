<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php get_header(); ?>
<div class="container<?php themolio_fullwidth_class(); ?>">
    <div id="post-0" class="post no-results not-found">
        <h1 class="entry-title"><?php _e('404 Page not found','themolio'); ?></h1>
        <div class="entry-content">
            <p><?php _e('Page your are looking for does not exist or has been moved. Try using the top menu or search...','themolio'); ?></p>
            <p><?php get_search_form(); ?></p>
        </div>
    </div>
</div>
<?php get_footer(); ?>