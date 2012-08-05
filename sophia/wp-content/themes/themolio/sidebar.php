<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options; ?>
<div id="sidebar-1" class="sidebar widget-area">
    <?php if($themolio_options['show_search']): ?>
    <div id="widget-search" class="widget">
        <?php get_search_form(); ?>
    </div>
    <?php endif; ?>
    <?php if(!dynamic_sidebar('sidebar-1')) : ?>
    <?php endif; ?>
</div>