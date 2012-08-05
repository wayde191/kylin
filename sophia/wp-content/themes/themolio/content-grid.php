<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options; ?>
<?php $count = 1; ?>
<div class="grid grid-col-<?php echo $themolio_options['grid_cols']; ?>">
<?php while(have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php $grid_img = themolio_post_image($post->ID,'','',$post->post_content,'grid-img'); ?>
        <?php if(trim($grid_img) != ''): ?>
            <div class="grid-thumb">
                <a href="<?php the_permalink(); ?>"><?php echo $grid_img; ?></a>
            </div>
        <?php endif; ?>
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
    <?php if($count % themolio_get_posts_per_col() == 0): ?>
    </div>
    <div class="grid grid-col-<?php echo $themolio_options['grid_cols']; ?>">
    <?php endif; ?>
    <?php $count++; ?>
<?php endwhile; ?>
</div>
<div class="clear"></div>