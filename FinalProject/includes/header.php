<!DOCTYPE HTML>
<html>
	<head lang="en">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cornell Policy Review</title>
		<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
		<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">

		<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600" rel="stylesheet">
		<link href=https://fonts.googleapis.com/css?family=Open+Sans:300italic,700italic,700,300 rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400|Roboto" rel="stylesheet">

		<link rel="stylesheet" type="text/css" media="all" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<?php if (function_exists('customHeader')) {customHeader();}?>
	</head>
	<body>
		<div id="page">
			<header>
				<a class="logo" title="Cornell Policy Review" href="index.php"><span>Cornell Policy Review</span></a>
				<div id="topnav">
					<a href="#" id="searchtoggl"><i class="fa fa-search fa-lg"></i></a>
					<a href="#">Login</a>
				</div>
			</header>


			<div id="searchbar" class="clearfix">
				<form id="searchform" method="get" action="searchpage.php">
				    <button type="submit" id="searchsubmit" class="fa fa-search fa-4x"></button>
				    <input type="search" class="search" name="locationsearch" id="locationsearch" placeholder="Location..." autocomplete="off">
				    <input type="search" class="search"  name="tagsearch" id="taglocation" placeholder="Tag..." autocomplete="off">
				</form>
			</div>


			<nav>
				<ul>
					<li><a href="#" aria-haspopup="true">Articles</a>
						<ul>
							<li><a href="#">First One</a></li>
							<li><a href="#">Second</a></li>
							<li><a href="#">Third</a></li>
							<li><a href="#">Fourth</a></li>
							<li><a href="#">Fifth</a></li>
						</ul>
					</li>
					<li><a href="#" aria-haspopup="true">Authors</a>
						<ul>
							<li><a href="#">Jane Doe</a></li>
							<li><a href="#">John Doe</a></li>
							<li><a href="#">Blah McBlah</a></li>
							<li><a href="#">Bahd</a></li>
						</ul>
					</li>
					<li><a href="#">CPR Website</a></li>
				</ul>
			</nav>
			<div class="SpecEd">
				<h1>Special Edition: GIS</h1>
				<h2>Geographical Information System</h2>
			</div>

