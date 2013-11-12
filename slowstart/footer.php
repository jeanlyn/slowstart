<hr>
      <footer class="footer">
	  <div class="container">
		<!--分类-->
		<div class="row">
        <div class="col-lg-3">
           <h4>分类目录</h4>
		   <div class="cscroll">
			<ul  class="list-group">
				<?php $sep = '';		
					$list=get_categories();					
					foreach($list as $cat) {
						$sep=$sep . '<li class="list-group-item"><span class="badge">'.$cat->category_count.'</span><a href="' . get_category_link($cat->term_id) . '"  class="cat-' . $cat->slug . '" title="View all posts in '. esc_attr($cat->name) . '">'. $cat->cat_name . '</a></li> ';
					}
					echo $sep
?>
			</ul>
			</div>
        </div><!-- /.col-lg-3 -->
		<!--最近评论-->
        <div class="col-lg-3">
          <h4>最近评论</h4>
		  <div class="cscroll">
			<ul class="list-group recentcomment">
			<?php
				$show_comments = 5; //评论数量
				$my_email = get_bloginfo ('admin_email'); //获取博主自己的email
				$i = 1;
				$comments = get_comments('number=200&status=approve&type=comment'); //取得前200个评论，如果你每天的回复量超过200可以适量加大
				foreach ($comments as $rc_comment) {
					if ($rc_comment->comment_author_email != $my_email) {					
			?>
					
					<li class="list-group-item"><?php echo get_avatar($rc_comment->comment_author_email,32); ?><span class="comment_author"><?php echo $rc_comment->comment_author; ?> says:</span><br /><a href="<?php echo get_permalink($rc_comment->comment_post_ID); ?>#comment-<?php echo $rc_comment->comment_ID; ?>"><?php echo convert_smilies($rc_comment->comment_content); ?></a></li>
			<?php
					if ($i == $show_comments) break; //评论数量达到退出遍历
					$i++;
					} // End if
				} //End foreach
			?>
</ul></div>
        </div><!-- /.col-lg-3 -->
		<!--归档-->
        <div class="col-lg-3">
          <h4>文章存档</h4>
		  <div class="cscroll">
			<ul class="list-group"> 
				<?php wp_get_archives('type=monthly&format=custom&before=<li class="list-group-item">&after=</li>&limit=10')?>				
			</ul>
			</div>
        </div><!-- /.col-lg-3 -->
		<div class="col-lg-3">
          <h4>你想看?...</h4>
		  <div class="cscroll">
			<p><?php wp_tag_cloud('smallest=8&largest=22'); ?></p>
			</div
			</div><!-- /.col-lg-3 -->
      </div><!-- /.row -->
	  </div>
        <p style="text-align:center;"><strong>&copy 2013 <?php bloginfo('name');?> Design By</strong> <a href="http://www.jeanlyn.pw">jeanlyn</a></p>
		<?php wp_footer(); ?>
	<script src="<?php bloginfo("template_directory")?>/js/main.js"></script>
	<script src="<?php bloginfo("template_directory")?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
	(function($){
			$(window).load(function(){
				$(".cscroll").mCustomScrollbar({
					autoHideScrollbar:true,
					theme:"light-thin"
				});
			});
		})(jQuery);
	</script>
      </footer>
  </body>
</html>