<?php session_start(); ?>

<!DOCTYPE HTML>
<html>
	<head lang="en">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cornell Policy Review</title>
		<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
		<link rel="stylesheet" href="SlickNav/dist/slicknav.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">

		<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600" rel="stylesheet">
		<link href=https://fonts.googleapis.com/css?family=Open+Sans:300italic,700italic,700,300 rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400|Roboto" rel="stylesheet">

		<link rel="stylesheet" type="text/css" media="all" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    	<script src="SlickNav/dist/jquery.slicknav.min.js"></script>
    	<script type="text/javascript" src="js/scripts.js"></script>
		<?php if (function_exists('customHeader')) {customHeader();}?>
	</head>

	<body>
		<div id="page">
			<header>
				<a class="logo" title="Cornell Policy Review" href="http://www.cornellpolicyreview.com"><span>Cornell Policy Review</span></a>
				<div id="topnav">
					<a href="#" id="searchtoggl"><i class="fa fa-search fa-lg"></i></a>
					<?php 
					if (isset($_SESSION["user"])) {
						print("<a href='#' id='logout'>Sign out</a>");
					} else {
						print("<a href='login.php'>Sign in</a>");
					}
					?>
				</div>
			</header>
			<div id="mobilemenu">
			</div>
			<div id="searchbar" class="clearfix">
				<form id="searchform" method="get" action="searchpage.php">
				    <button type="submit" id="searchsubmit" class="fa fa-search fa-3x"></button>
				    <input type="search" class="search" name="locationsearch" id="locationsearch" placeholder="Location..." autocomplete="off">
				    <input type="search" class="search"  name="tagsearch" id="taglocation" placeholder="Tag..." autocomplete="off">
				</form>
			</div>


			<nav>
				<ul id="menu">
					<li><a href="#">Home</a></li>
					<li><a href="#" aria-haspopup="true">Articles</a>
						<ul>
							<?php 
									require_once 'includes/config.php';
									$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    							$articles_info = $mysqli->query("SELECT location,article_id FROM Articles");
    							if (empty($articles_info)) {
    								print("didnt work");
							      print($mysqli->error);
							    } else {
										while ($row = $articles_info->fetch_assoc()) {
											$article_id = $row['article_id'];
											$title = $row['location'];
											print("<li><a href='article.php?id=$article_id'>$title</a></li>");
										}
									}
							?>
						</ul>
					</li>
					<li><a href="#" aria-haspopup="true">Authors</a>
						<ul>
							<?php 
    							$authors_info = $mysqli->query("SELECT name,author_id FROM Authors");
    							if (empty($authors_info)) {
    								print("didnt work");
							      print($mysqli->error);
							    } else {
										while ($row = $authors_info->fetch_assoc()) {
											$author_id = $row['author_id'];
											$name = $row['name'];
											print("<li><a href='author.php?author=$author_id'>$name</a></li>");
										}
									}
							?>
						</ul>
					</li>
				</ul>
			</nav>
			<div class="SpecEd">
				<h1>Special Edition: GIS</h1>
				<h2>Geographical Information System</h2>
			</div>
