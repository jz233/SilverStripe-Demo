<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<% base_tag %>
	<!-- SS默认MetaTag集 -->
	$MetaTags
	
	<title>$Title</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	
	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> 
	<![endif]-->
	
	
</head>
<body>
	<!-- BEGIN WRAPPER -->
	<div id="wrapper">
		
		<header id="header">
			<!-- 顶层TopBar -->
			<% include TopBar %>
			<!-- 导航栏MainNav -->
			<% include MainNav %>
		</header>
		
		<!-- 页面主内容 Layout(注释中不能写变量提示符) 模板是HomePage.ss-->
		$Layout
		
				
		<!-- BEGIN FOOTER -->
		<!-- 底层Footer -->
		<% include Footer %>

		<!-- END FOOTER -->
	
	</div>
	<!-- END WRAPPER -->


</body>
</html>