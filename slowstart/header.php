<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>
	<?php if(is_home()){
		bloginfo('name');echo '|';bloginfo('description');
	}
	else if(is_category()){
		single_cat_title();echo '|';bloginfo('name');
	}
	else if(is_single()||is_page()){
		single_post_title();
	}
	else if(is_search()){
		echo '搜索结果';echo '-';bloginfo('name');
	}
	else if(is_404()){
		echo'页面找不到';
	}
	else {
		wp_title('',true);
	}
	?>
	</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
	 <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	 <!--[if lt IE 9]>
	 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 <?php
if (is_home() || is_page()) {
    // 将以下引号中的内容改成你的主页description
    $description = "jeanlyn's blog";

    // 将以下引号中的内容改成你的主页keywords
    $keywords = ".net,sql,博客,hadoop,,hive,php,javascript,jquery";
}
elseif (is_single()) {
    $description1 = get_post_meta($post->ID, "description", true);
    $description2 = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200, "…");
    // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
    $description = $description1 ? $description1 : $description2;
    // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
    $keywords = get_post_meta($post->ID, "keywords", true);
    if($keywords == '') {
        $tags = wp_get_post_tags($post->ID);    
        foreach ($tags as $tag ) {        
            $keywords = $keywords . $tag->name . ", ";    
        }
        $keywords = rtrim($keywords, ', ');
    }
}
elseif (is_category()) {
    $description = category_description();
    $keywords = single_cat_title('', false);
}
elseif (is_tag()){
    $description = tag_description();
    $keywords = single_tag_title('', false);
}
$description = trim(strip_tags($description));
$keywords = trim(strip_tags($keywords));
?>
	<!-- 优化SEO -->
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<script src="https://code.jquery.com/jquery.js"></script>
	<?php wp_enqueue_script("jquery");?>
	<?php wp_head();?>
</head>
<body class="body">		
			<div class="header">
				<div class="jumbotron">
					<h1><?php echo bloginfo('name');?></h1>
					<h2><?php echo bloginfo('description');?></h2>					
				</div>				
				<div class="navbar-inverse" role="navigation">					
							<div class="collapse navbar-collapse bs-navbar-collapse">
								<ul class="nav navbar-nav"> 
									<li><a href="<?php echo site_url(); ?>">HOME</a></li>
									<?php wp_list_pages(array('title_li' => '', 'exclude' => 4)); ?>
									
								</ul>									
								<form method="get" id="searchform" action="<?php bloginfo('url'); ?>" class="navbar-form navbar-right" role="search"/>
								<div>
									<input type="hidden" value="1" id="IncludeBlogs" name="IncludeBlogs"/>
									<input type="text" id="searchtext" name="s" class="form-control" value="Press Enter Search"  />
								</div>
								</form>								
							</div>					
				</div><!--/.nav-collapse -->			
			</div>