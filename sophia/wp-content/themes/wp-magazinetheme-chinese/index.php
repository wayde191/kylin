<?php get_header(); ?>
	
	<!-- Container/内容页面 -->	
	<div id="content-wrap">
		<!-- Left Column/左边日志的代码 -->
		<div id="leftcolumn">
		
			<!-- Featured Article/重点突出的日志 -->
			<div id="featured">	
				<!-- Featured article loop/日志调用函数 -->
				<?php query_posts('cat=3&showposts=1'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<!-- title of featured article/日志标题 -->
				<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>				<!-- content of featured article/日志的内容-->
				<?php the_excerpt_reloaded(30, '<img><a>', 'content', false, 'More...', true);?>
					<!-- Featured Article Post Details/内容 -->
					<div id="postdetails">
						<?php the_time('F j, Y'); ?> | <?php comments_popup_link(__('发表评论'), __('1 条评论'), __('% 条评论'));?> | <a href="<?php echo get_permalink(); ?>" title="Read More">详细阅读</a>
					</div>
				<!-- End of Loop fore featured article/日志函数调用结束 -->
				<?php endwhile; else : ?>
				<?php endif; ?>
			</div>
			
			<!-- Latest featured articles list/其他重点突出日志的列表 -->
			<div id="featurednewslist">
				<h2>其他推荐日志</h2>
				<ul>
					<?php query_posts('cat=3&showposts=10'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; else : ?>							
					<?php endif; ?>
				</ul>
			</div>			
			<?php include (TEMPLATEPATH . '/300x250ad.php'); ?>
		</div>
		<!-- /Left Column/左边栏日志结束-->
		
		<!-- Middle Column -->
		<div id="midcolumn">
			<h2>最新日志</h2>
			<!-- Loop for latest news/最新日志调用函数-->
			<?php $oddentry = 'class="gray" '; ?>
			<?php query_posts('cat=5,6,7,8,9,10,11,12,13&showposts=4'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php echo $oddentry; ?>>
				<div class="midcolumnpost">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<?php the_excerpt_reloaded(30, '<img><a>', 'content', false, 'More...', true);?>
					<div class="details">
						<?php the_time('F j, Y'); ?> | <?php comments_popup_link(__('发表评论'), __('1 条评论'), __('% 条评论'));?> | <a href="<?php echo get_permalink(); ?>" title="Read More">详细阅读</a>
					</div>
				</div>
			</div>
			<?php /* Changes every other post to a different class */	$oddentry = ( empty( $oddentry ) ) ? 'class="gray" ' : ''; ?>
			<!-- End of Loop for middle column -->
			<?php endwhile; else : ?>		
			<?php endif; ?>
		</div>
		<!-- /Middle Column -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>