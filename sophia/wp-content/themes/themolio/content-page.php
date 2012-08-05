<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options; ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php if($themolio_options['show_page_meta']): ?>
    <div class="entry-meta">
        <?php themolio_posted_on(); ?>
    </div>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(__('Continue reading &raquo;', 'themolio')); ?>
        <?php wp_link_pages(array('before' => '<div class="page-link clearfix"><span class="pages-title">'.__('Pages:','themolio').'</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div>
    <div class="entry-info">
		<?php if(get_comments_number() > 0): ?>
        <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
		<?php endif; ?>
        <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
    </div>
</div>