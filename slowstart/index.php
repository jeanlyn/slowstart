<?php get_header(); ?>	
	<!--主体内容-->
	<div class="container">
	<?php $i=1; if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
		<?php
				if(strstr(get_the_category($post->ID)[0]->name,"miniblog")):
		?>
		<hr class="featurette-divider">
		<div class="row featurette">
			<div class="col-md-7">
				<a href="<?php the_permalink();?>"><?php echo get_avatar(get_bloginfo ('admin_email'),45); ?></a>
				<div >
					<div class="minblog">
					<p class="content"><?php the_content();?></p>
					<p class="small"><span class="glyphicon glyphicon-time"></span> <?php the_time('Y-m-d');?></p>
					</div>					
					<div class="minidot"></div>
				</div>
			</div>
		</div>
		<?php elseif($i++%2==1):?>
		<hr class="featurette-divider">
		<div class="row featurette">
			<div class="col-md-7">
				<h2 class="featurette-heading"><a class="title" href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a></h2>
				<p class="small"><span class="glyphicon glyphicon-tag"></span><?php the_tags('',',','');?> <span class="glyphicon glyphicon-time"></span> <?php the_time('Y-m-d');?> <span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭');?>
				<p class="lead"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 380,"..."); ?></p>
			</div>
        <div class="col-md-5">
		<a href="<?php the_permalink();?>">
          <img class="featurette-image img-responsive lazyload" data-original="<?php 			
			$img=get_content_first_image(apply_filters('the_content',$post->post_content));			
			if($img!=false){
				echo $img;
			}
			else{
				$r=strval(rand(0,100)%10);
				echo get_bloginfo("template_directory").'/images/home/blog'.$r.'.jpg';
			}
		  ?>" alt="500x500" src="<?php bloginfo("template_directory");?>/images/loading.gif"></a>
        </div>
      </div>

	  <?php else:?>
	  <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
		<a href="<?php the_permalink();?>">
        <img class="featurette-image img-responsive lazyload" data-original="<?php 			
			$img=get_content_first_image(apply_filters('the_content',$post->post_content));			
			if($img!=false){
				echo $img;
			}
			else{
				$r=strval(rand(0,100)%10);
				echo get_bloginfo("template_directory").'/images/home/blog'.$r.'.jpg';
			}
		  ?>" alt="500x500" src="<?php bloginfo("template_directory");?>/images/loading.gif"></a>
		</div>
        <div class="col-md-7">
          <h2 class="featurette-heading"><a class="title" href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a></h2>
		  <p class="small"><span class="glyphicon glyphicon-tag"></span><?php the_tags('',',','');?> <span class="glyphicon glyphicon-time"></span> <?php the_time('Y-m-d');?> <span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭');?>
          <p class="lead"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 380,"..."); ?></p>
        </div>
      </div>
	 
		
		<?php endif; endwhile; else: ?>
		<p><?php _e('对不起,博主还没有文章!'); ?></p>
	<?php endif; ?>	
	<!-- 分页 -->
	<hr >
	<?php pagenavi(); ?>
	</div>	
<?php get_footer(); ?>