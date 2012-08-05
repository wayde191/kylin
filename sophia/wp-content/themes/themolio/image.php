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
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <!-- Start of post -->
                <?php the_title( '<h1 class="entry-title"><a href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'themolio' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a></h1>' ); ?>
                <div class="entry-meta">
                    <?php themolio_posted_on(); ?>
                </div>
                <div class="entry-content">
                    <div class="entry-attachment">
                        <?php
                            $attachments = array_values(get_children(array(
                                'post_parent' => $post->post_parent,
                                'post_status' => 'inherit',
                                'post_type' => 'attachment',
                                'post_mime_type' => 'image',
                                'order' => 'ASC',
                                'orderby' => 'menu_order ID'
                            )));
                            foreach ($attachments as $k => $attachment) {
                                if ($attachment->ID == $post->ID)
                                    break;
                            }
                            $k++;
                            if (count($attachments) > 1) {
                                if (isset($attachments[$k]))
                                    $next_attachment_url = get_attachment_link($attachments[$k]->ID);
                                else
                                    $next_attachment_url = get_attachment_link($attachments[0]->ID);
                            } else {
                                $next_attachment_url = wp_get_attachment_url();
                            }
                        ?>
                        <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
                            <?php
                                $attachment_size = apply_filters('themolio_attachment_size', THEMOLIO_CONTAINER_WIDTH);
                                echo wp_get_attachment_image($post->ID, array($attachment_size, 1024)); // filterable image width with 1024px limit for image height.
                            ?>
                        </a>
                        <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                        <div class="entry-caption">
                            <?php the_excerpt(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php the_content(__('Continue reading &raquo;', 'themolio')); ?>
                    <?php wp_link_pages(array('before' => '<div class="page-link clearfix"><span class="pages-title">'.__('Pages:','themolio').'</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                </div>
                <div class="entry-info">
                    <?php comments_popup_link(__('Reply','themolio'), __('1 comment','themolio'), __('% comments','themolio'), 'comments-link', __('Comments off','themolio')); ?>
                    <?php edit_post_link(__('Edit', 'themolio'), '', ''); ?>
                </div>
            </div> <!-- End of post -->
            <div class="post-navigation clearfix">
                <span class="nav-previous"><?php previous_image_link( false, __( '&laquo; Previous','themolio') ); ?></span>
                <span class="nav-next"><?php next_image_link( false, __( 'Next &raquo;','themolio') ); ?></span>
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