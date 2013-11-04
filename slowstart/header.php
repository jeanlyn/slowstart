<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Jeanlyn</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
	 <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	 <!--[if lt IE 9]>
	 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 <script src="https://code.jquery.com/jquery.js"></script>
	 <?php wp_enqueue_script("jquery");?>
	 <?php wp_head();?>
</head>
<body>		
			<div>				
				<div class="navbar-wrapper">
					<div class="container">
						<div class="navbar-header"><a class="navbar-brand">HOME</a></div>
						<div class="navbar-collapse collapse">
							<div class="navbar navbar-inverse navbar-static-top">
								<ul class="nav navbar-nav"> 
									<li><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></li>
									<?php wp_list_pages(array('title_li' => '', 'exclude' => 4)); ?> 
								</ul>						
							</div>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>
		
		