<?php get_header(); ?>
	<!--文章主题内容-->
	<div class="container">
	<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
	<div class="page-header">
		<h1><?php the_title(); ?></h1>
		<p class="small"><span class="glyphicon glyphicon-tag"></span><?php the_tags('标签',',','');?> <span class="glyphicon glyphicon-time"></span> <?php the_time('Y-m-d');?> <span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭');?>
	</div>		
		<?php the_content(); ?>
	<div class="row" id="thecomments">
		<?php comments_template(); ?>
	</div>
	<?php else : ?>
	<div class="grid_8">
		没有找到你想要的页面！
	</div>
	<?php endif; ?>
	</div>
<?php get_footer(); ?>