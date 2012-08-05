<?php get_header(); ?>
	
	<!-- Container -->
	<div id="content-wrap">
	
		<!-- single post content -->
		<div id="singlepost">
		<!-- single post loop -->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post">
				<!-- title of the post -->
				<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<!-- content -->
				<?php the_excerpt(); ?>

				<!-- Post Details -->
				<div class="postinfo">
					<?php _e("发表时间:") ?> <?php the_time('F j, Y'); ?> | <?php _e("日志分类:"); ?> <?php the_category(',') ?><?php if(is_home() || is_404() || is_category() || is_day() || is_month() || is_year() || is_search()) { ?> | <?php comments_popup_link(__('发表评论'), __('1 条评论'), __('% 条评论'));?> <?php } ?>
				</div>
			</div>
			<!-- End of Loop fore single post -->
		<?php endwhile; ?>
			<div id="pagenavi">
				<div class="left"><?php posts_nav_link('','','&laquo; 较早日志') ?></div>
				<div class="right"><?php posts_nav_link('','较新日志 &raquo;','') ?></div>
			</div>
		<?php else : ?>
			<p>没有日志符合你的搜索要求.</p>
		<?php endif; ?>
		</div>
		<!-- /singlepost  -->
				
<?php get_sidebar(); ?>

<?php get_footer(); ?>