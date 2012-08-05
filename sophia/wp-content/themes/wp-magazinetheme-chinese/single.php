<?php get_header(); ?>

	<!-- Container -->
	<div id="content-wrap">
	
		<!-- single post content -->
		<div id="singlepost">
			<div class="post">
				<!-- single post loop -->
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<!-- title of the single pot -->
				<h3><?php the_title(); ?></h3>
				<!-- content -->
				<?php the_content(__('')); ?>

				<!-- Single Post Details -->
			</div>
			
			<div class="single-entry-nav">
				<div class="left"><?php previous_post_link('&laquo; %link') ?></div>
				<div class="right"><?php next_post_link('%link &raquo;') ?></div>
				<div style="clear:both"></div>
			</div>
				
			<div id="comment-wrapper">
				<?php comments_template(); ?>
			</div>		
				
			<!-- End of Loop fore single post -->
			<?php endwhile; else : ?>
			<?php endif; ?>
		</div>
		<!-- /singlepost  -->
				
<?php get_sidebar(); ?>

<?php get_footer(); ?>