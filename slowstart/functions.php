<?php
 
function wpbootstrap_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

/*搜索的自动完成的服务器端代码*/
function autocomplete(){
if($_GET['action']=='autocomplete'){
//输出的形式设置为JSON,不然前端的插件检测不到数据

//获取全局变量
$wpdb=$GLOBALS['wpdb'];
$constrs='[';
$resault=$_GET['searcht'];
//到数据库匹配标题
$posts_info = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'post' and post_status = 'publish' and post_title like '%".$resault."%' limit 0,5");
	if(!empty($posts_info))
	{
		foreach($posts_info as $k=>$v)
		{
			$constrs=$constrs.'"'.$v->post_title.'",';
		}
		//构造输出的字符串
		$constrs=substr($constrs,0,strlen($constrs)-1).']';
		echo $constrs;
		//停止其他操作,不然输出的字符串会不正确,这取决于wordpress本身的复杂性
		die();
	}
	else
	{
		echo "[]";
		//停止其他的操作
		die();
	}
}
}
add_action('init','autocomplete');
//获取第一张图片
function get_content_first_image($content){
	if ( $content === false ) $content = get_the_content(); 
	//正则匹配
	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $images);

	if($images){       
		return $images[1][0];
	}else{
		return false;
	}
}

//生成评论
function aurelius_comment($comment, $args, $depth) 
{
   $GLOBALS['comment'] = $comment; ?>   
   <li class="comment" id="li-comment-<?php comment_ID(); ?>">
   <div class="comment_content" >	
		<div class="gravatar"> <?php if (function_exists('get_avatar') && get_option('show_avatars')) 
		{
			$img1=get_avatar($comment, 35); 			
			$img1=str_replace('src','data-original',$img1);
			$jl_dir=get_bloginfo('template_directory');
			$img1=str_replace('<img ', '<img '.'src="'.$jl_dir.'/images/loading.gif'.'" ', $img1);
			echo $img1;
		}		
		?></div>
			<span class="comment_author">
					<?php if (get_comment_author_url()) : ?>
					<a id="commentauthor-<?php comment_ID() ?>" href="<?php comment_author_url() ?>">
					<?php else : ?>
					<span id="commentauthor-<?php comment_ID() ?>">
					<?php endif; ?> 
					<?php comment_author() ?> 
					<?php if(get_comment_author_url()) : ?>
					</a>					
					<?php else : ?>
					</span>
					<?php endif; ?>
			</span>
			<span class="comment_time">发表于：<?php echo get_comment_time('Y-m-d H:i'); ?>
					&nbsp;&nbsp;&nbsp;<?php edit_comment_link('修改'); ?>|
					<a href="javascript:void(0);" onclick="reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment');"><?php _e('Reply'); ?></a>
			</span>
		</div>
		<div class="comment_text" id="comment-<?php comment_ID(); ?>">
				<?php if ($comment->comment_approved == '0') : ?>
					<em>你的评论正在审核，稍后会显示出来！</em><br />
      	<?php else:?>
      	<?php comment_text(); ?>
      	<?php endif; ?>
		</div>		
	</li>
<?php } 
/*ajax获取评论*/
function load_comment(){
	if($_GET['action'] =='load_comment' && $_GET['id'] != ''){
		$comment = get_comment($_GET['id']);
		if(!$comment) {
			fail(printf('Whoops! Can\'t find the comment with id  %1$s', $_GET['id']));
		}
		aurelius_comment($comment, null,null);
		die();
	}
}
add_action('init', 'load_comment');
/*邮件回复!!*/
function comment_mail_notify($comment_id) {
	
     $comment = get_comment($comment_id);//根据id获取这条评论相关数据
     $content=$comment->comment_content;
     //对评论内容进行匹配    
     $match_count=preg_match_all('/<a href="#comment-([0-9]+)?" rel="nofollow">/si',$content,$matchs);     
     if($match_count>0){//如果匹配到了
         foreach($matchs[1] as $parent_id){//对每个子匹配都进行邮件发送操作
             SimPaled_send_email($parent_id,$comment);		
         }       
     }else if($comment->comment_parent!='0'){//以防万一，有人故意删了@回复，还可以通过查找父级评论id来确定邮件发送对象
         $parent_id=$comment->comment_parent;
         SimPaled_send_email($parent_id,$comment);
		
     }else return;
 }
 add_action('comment_post', 'comment_mail_notify');
 function SimPaled_send_email($parent_id,$comment){//发送邮件的函数 by Qiqiboy.com
     $admin_email = get_bloginfo ('admin_email');//管理员邮箱
     $parent_comment=get_comment($parent_id);//获取被回复人（或叫父级评论）相关信息
     $author_email=$comment->comment_author_email;//评论人邮箱
     $to = trim($parent_comment->comment_author_email);//被回复人邮箱
     $spam_confirmed = $comment->comment_approved;     
	 if ($spam_confirmed != 'spam' && $to != $admin_email && $to != $author_email) {
           $wp_email='398893500@qq.com';
           //$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
         $subject = '您在 [' . get_option("blogname") . '] 的留言有了回應';
         $message = '<div style="background-color:#eef2fa;border:1px solid #d8e3e8;color:#111;padding:0 15px;-moz-border-radius:5px;-webkit-border-radius:5px;-khtml-border-radius:5px;">
             <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
             <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
             . trim(get_comment($parent_id)->comment_content) . '</p>
             <p>' . trim($comment->comment_author) . ' 给你的回复:<br />'
             . trim($comment->comment_content) . '<br /></p>
             <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($comment->comment_ID,array("type" => "all"))) . '">查看回复的完整內容</a></p>
             <p>欢迎再度狂踩 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
             <p>(此邮件有系统自动发出, 请勿回复.)</p></div>';
         $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
         $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
         //wp_mail( $to, $subject, $message, $headers );
		$saeTo = $to;
		$saeSubject = $subject;
		$saeMessage = $message;
		$saeSMTPUser = 'wp_jeanlyn@sina.cn';//SMTP邮箱
		$saeSMTPPass = 'only0156';//SMTP密码
		$mail = new SaeMail();
		$saeStmp='smtp.sina.cn';
		$duankou=25;
           //$result = $mail->quickSend($saeTo, $saeSubject, $saeMessage, $saeSMTPUser, $saeSMTPPass,$qqstmp,$duankou);		
           //$options = array("from"=>$wp_email, "to"=>$to, "smtp_host"=>’邮箱的smtp服务器地址’,"smtp_username"=>’你的邮箱地址’,”smtp_password”=>’邮箱密码’,”subject”=>$subject,”content”=>$message,”content_type”=>’HTML’);
		$options =array("from"=>$saeSMTPUser,"to"=>$saeTo,"smtp_port"=>25,"smtp_host"=>$saeStmp,"smtp_username"=>$saeSMTPUser,"smtp_password"=>$saeSMTPPass,"subject"=>$saeSubject,"content"=>$saeMessage,"content_type"=>'HTML');
		$result=false;
                if($mail->setOpt($options))
                	$result=$mail->send();
		else if ($result === false)
			var_dump($mail->errno(), $mail->errmsg());
          
                
     }
 }	
	
//分页
function pagenavi( $before = '', $after = '', $p = 2 ) {
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 )
        return;
    if ( empty( $paged ) )
        $paged = 1;
    echo $before.'<ul class="pagination">';
    if ( $paged > 1 )
        p_link( $paged - 1, '上一页', '«' );
    if ( $paged > $p + 1 )
        p_link( 1, '首页' );
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
        if ( $i > 0 && $i <= $max_page )
            $i == $paged ? print "<li class='disabled'><a href='".esc_html( get_pagenum_link( $i ) )."'>{$i}</a></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p ) p_link( $max_page, '末页' );
    if ( $paged < $max_page ) p_link( $paged + 1,'下一页', '»' );
    echo '</ul>'.$after;
}

function p_link( $i, $title = '', $linktype = '' ) {
    if ( $title == '' ) $title = "跳到第{$i}页";
    if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a></li>";
}
	
?>

