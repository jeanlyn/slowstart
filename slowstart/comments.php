	<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('请不要直接加载该页面! Thanks!');
	?>
	<?php 
		if ( !comments_open() ) :
		// If registration required and not logged in.
		elseif ( get_option('comment_registration') && !is_user_logged_in() ) : 
	?>
		<p>你必须 <a href="<?php echo wp_login_url( get_permalink() ); ?>">登录</a> 才能发表评论.</p>
		<?php else  : ?>	
		
		<!-- Comment Form	-->
		<form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">   	
    	<h3>发表评论</h3>
    	<ul>
        <?php if ( !is_user_logged_in() ) : ?>
        <?php cancel_comment_reply_link() ?>
        <li class="input">
           <!--   <label for="name">昵称</label>-->
            <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>"  />
        </li>
        <li class="input">
            <!-- <label for="email">电子邮件</label>-->
            <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>"   />
        </li>
        <li class="input">
           <!--   <label for="email">网址(选填)</label>-->
            <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>"  />
        </li>
        <?php else : ?>
        <li class="clearfix">您已登录:<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出登录">退出 &raquo;</a></li>
        <?php endif; ?>
        <li class="clearfix">
         <!-- <label for="message">评论内容</label> -->   
            <textarea id="comment" name="comment" tabindex="4" rows="3" cols="40" ></textarea>
        </li>
        <li class="clearfix">
            <!-- Add Comment Button -->
            <button type="button" onClick="Javascript:document.forms['commentform'].submit()" class="btn btn-link">发表评论(ctrl+enter)</button> 
		</li>
   	 	</ul>
    	<?php comment_id_fields(); ?>
    	<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
	<!-- Comment's List -->
	 <div class="hr dotted clearfix">&nbsp;</div>
	<ul id="custom_comment">
	<?php    
    if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { 
        // if there's a password
        // and it doesn't match the cookie
    ?>
    <li class="decmt-box">
        <p><a href="#commentform">请输入密码再查看评论内容.</a></p>
    </li>
    <?php 
        } else if ( !comments_open() ) {
    ?>
    <li class="decmt-box">
        <p><a href="#commentform">评论功能已经关闭!</a></p>
    </li>
    <?php 
        } else if ( !have_comments() ) { 
    ?>
    <li class="decmt-box">
        <p><a href="#commentform">还没有任何评论，你来说两句吧</a></p>
    </li>
    
    <?php 
        } else {
            wp_list_comments('type=comment&callback=aurelius_comment');
     ?>
            <div id="nav_pages" class="navigation">
           	 <?php // paginate_comments_links(array('prev_text' => '&laquo;prev', 'next_text' => 'next&raquo;')); ?>
            </div>
    <?php 
        }
   	 ?>		
	</ul>
	