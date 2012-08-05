<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options; ?>
<?php if ('gallery' == get_post_format()) : ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_title( '<h1 class="entry-title"><a href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'themolio' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a></h1>' ); ?>
    <div class="entry-meta">
        <?php themolio_posted_on(); ?>
    </div>
    <div class="entry-content">
        <?php if(post_password_required()): ?>
            <?php the_content(); ?>
        <?php else: ?>
        <?php
            $images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999));
            if($images):
                $total_images = count($images);
                $image = array_shift($images);
                $image_img_tag = wp_get_attachment_image($image->ID, 'thumbnail');
        ?>
            <div class="gallery-thumb">
                <a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
            </div>
            <p><?php printf(__('This gallery contains <a %1$s>%2$s photos</a>.', 'themolio'), 'href="' . get_permalink() . '" title="' . sprintf(esc_attr__('Permalink to %s', 'themolio'), the_title_attribute('echo=0')) . '" rel="bookmark"', $total_images); ?></p>
        <?php
            endif;
            the_excerpt();
        endif; ?>
    </div>
    <div class="entry-info">
        <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
        <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
    </div>
</div>
<?php elseif('status' == get_post_format()): ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-meta">
        <?php themolio_posted_on(); ?>
    </div>
    <div class="entry-content">
        <?php if($themolio_options['show_excerpts']): ?>
            <?php the_excerpt(); ?>
        <?php else: ?>
            <?php the_content(__('Continue reading &laquo;', 'themolio')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-link clearfix"><span class="pages-title">'.__('Pages:','themolio').'</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        <?php endif; ?>
    </div>
    <div class="entry-info">
        <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
        <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
    </div>
</div>
<?php else: ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_title( '<h1 class="entry-title"><a href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'themolio' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a></h1>' ); ?>
    <div class="entry-meta">
        <?php themolio_posted_on(); ?>
    </div>
    <?php $featured_img = themolio_post_image($post->ID,'','',$post->post_content,'featured-img'); ?>
    <?php if(trim($featured_img) != '' and $themolio_options['show_featured']): ?>
        <div class="entry-thumb">
            <a href="<?php the_permalink(); ?>"><?php echo $featured_img; ?></a>
        </div>
    <?php endif; ?>
    <div class="entry-content">
        <?php if($themolio_options['show_excerpts']): ?>
            <?php the_excerpt(); ?>
        <?php else: ?>
            <?php the_content(__('Continue reading &raquo;', 'themolio')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-link clearfix"><span class="pages-title">'.__('Pages:','themolio').'</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        <?php endif; ?>
    </div>
    <div class="entry-info">
        <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
        <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
    </div>
</div>
<?php endif; ?>