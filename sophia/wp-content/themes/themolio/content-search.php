<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_title( '<h1 class="entry-title"><a href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'themolio' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a></h1>' ); ?>
    <div class="entry-meta">
        <?php themolio_posted_on(); ?>
    </div>
    <div class="entry-content">
        <?php the_excerpt(); ?>
    </div>
    <div class="entry-info">
        <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
        <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
    </div>
</div>