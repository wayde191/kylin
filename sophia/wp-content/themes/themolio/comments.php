<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php if (post_password_required()) : ?>
<div id="comments">
    <div class="comments-container">
        <span class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'themolio'); ?></span>
    </div>
</div>
<?php
    return;
    endif;
?>
<div id="comments">
<?php if (have_comments()) : ?>
    <div class="comments-section-heading clearfix">
        <span class="comments-title" onclick="showComments()">
            <?php printf(_n('One comment', '%1$s comments', get_comments_number(), 'themolio'), number_format_i18n(get_comments_number())); ?>
        </span>
        <span class="comments-write-title" onclick="showCommentForm()">
            <?php _e('Submit a comment','themolio'); ?>
        </span>
    </div>
    <div class="comments-container">
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <div class="comment-navigation">
            <span class="nav-previous"><?php previous_comments_link(__('&laquo; Older Comments','themolio')); ?></span>
            <span class="nav-next"><?php next_comments_link(__('Newer Comments &raquo;','themolio')); ?></span>
            <div class="clear"></div>
        </div>
        <?php endif; ?>
        <ul class="commentlist">
            <?php wp_list_comments(array('callback' => 'themolio_list_comments')); ?>
        </ul>
    </div>
<?php elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')): ?>
    <div class="comments-container">
        <span class="nocomments"><?php _e('Comments are closed.', 'themolio'); ?></span>
    </div>
<?php endif; ?>
<?php comment_form(); ?>
</div>