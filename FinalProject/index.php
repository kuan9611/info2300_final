<!DOCTYPE HTML>
<html>
	<head lang="en">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cornell Policy Review</title>
		<link rel="stylesheet" type="text/css" media="screen" href="css/screen2.css">

		<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600" rel="stylesheet"> 
		<link href=http://fonts.googleapis.com/css?family=Open+Sans:300italic,700italic,700,300 rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400|Roboto" rel="stylesheet"> 

		<link rel="stylesheet" type="text/css" media="all" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		  <!-- Load Leaflet from CDN-->
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet-src.js"></script>

		<!-- Load Esri Leaflet from CDN -->
		<script src="https://unpkg.com/esri-leaflet@2.0.8"></script>
		<script src="https://leaflet.github.io/Leaflet.label/leaflet.label.js"></script>
		<script src="https://cdn.rawgit.com/Leaflet/Leaflet.heat/gh-pages/dist/leaflet-heat.js"></script>
		<script src="https://cdn.jsdelivr.net/leaflet.esri.heatmap-feature-layer/2.0.0-beta.1/esri-leaflet-heatmap-feature-layer.js"></script>
		<script src="http://cdn.jsdelivr.net/leaflet.esri.renderers/2.0.2/esri-leaflet-renderers.js"></script>
		<script src="https://muxlab.github.io/Leaflet.VectorIcon/L.VectorIcon.js"></script>
		<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
		<script src="https://cdn.jsdelivr.net/leaflet.esri.webmap/0.4.0/esri-leaflet-webmap.js"></script>

		<script type="text/javascript" src="js/scripts.js"></script>
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
		<section class="article">
		<h1> Title of the Article</h1>
		</section>		
		<div id="map"></div>
		<section class="article">
		<h2> This is a subheading </h2>
		<p>Lorem ipsum dolor sit amet, ei eam novum iriure. Ponderum aliquando pri ei, et dicit tantas ignota sit. Et sale omittam nam. Ne nam soleat laoreet, timeam convenire eloquentiam vis et.

Duo ut quodsi epicuri, his ad verear singulis atomorum. Ad ius vitae diceret mandamus, vel eu labitur lobortis consectetuer, ex vel sonet primis omittam. Ea mea placerat consectetuer voluptatibus, option iracundia adipiscing pri ad, per ea ferri nobis laoreet. Quo ludus menandri an, est praesent consequuntur cu. Vocent corpora tacimates ad his.

Etiam possit honestatis vel id. Eu his mutat sonet reprehendunt, aeque facilis abhorreant in duo. Ut iracundia dissentiunt pro, mei ea deleniti scaevola eleifend, vix ipsum iusto mundi ex. Cu idque latine vivendo sit, alii ullamcorper vim in.

Eu epicurei invidunt est, ius te phaedrum voluptatum intellegebat. Graece integre per in. Wisi impetus assentior eam ut, graece utroque nominati quo et, eu vis veri necessitatibus. Suas integre comprehensam at cum. At possit graecis vis.

Mel in soleat evertitur, per debet sonet ut. Solum elitr in per. No denique abhorreant sea. Vim justo legimus invenire ad, eius recusabo praesent ei cum. Pro liber eligendi conclusionemque eu, eros imperdiet eos eu.</p>
		<h2> This is another subheading </h2>
		<p>Lorem ipsum dolor sit amet, ei eam novum iriure. Ponderum aliquando pri ei, et dicit tantas ignota sit. Et sale omittam nam. Ne nam soleat laoreet, timeam convenire eloquentiam vis et.

Duo ut quodsi epicuri, his ad verear singulis atomorum. Ad ius vitae diceret mandamus, vel eu labitur lobortis consectetuer, ex vel sonet primis omittam. Ea mea placerat consectetuer voluptatibus, option iracundia adipiscing pri ad, per ea ferri nobis laoreet. Quo ludus menandri an, est praesent consequuntur cu. Vocent corpora tacimates ad his.

Etiam possit honestatis vel id. Eu his mutat sonet reprehendunt, aeque facilis abhorreant in duo. Ut iracundia dissentiunt pro, mei ea deleniti scaevola eleifend, vix ipsum iusto mundi ex. Cu idque latine vivendo sit, alii ullamcorper vim in.

Eu epicurei invidunt est, ius te phaedrum voluptatum intellegebat. Graece integre per in. Wisi impetus assentior eam ut, graece utroque nominati quo et, eu vis veri necessitatibus. Suas integre comprehensam at cum. At possit graecis vis.

Mel in soleat evertitur, per debet sonet ut. Solum elitr in per. No denique abhorreant sea. Vim justo legimus invenire ad, eius recusabo praesent ei cum. Pro liber eligendi conclusionemque eu, eros imperdiet eos eu.</p>
		</section>
		</div>

<script>
  // to draw a different webmap, just append its id instead
  // webmap.html?id=13750b8b548d48bfa99a9731f2a93ba0

  var webmapId = '22c504d229f14c789c5b49ebff38b941'; // Default WebMap ID
  getIdfromUrl();

  var webmap = L.esri.webMap(webmapId, { map: L.map("map") });

  webmap.on('load', function() {
      var overlayMaps = {};
      webmap.layers.map(function(l) {
          overlayMaps[l.title] = l.layer;
      });
      L.control.layers({}, overlayMaps, {
          position: 'bottomleft'
      }).addTo(webmap._map);
  });

  function getIdfromUrl() {
    var urlParams = location.search.substring(1).split('&');
    for (var i=0; urlParams[i]; i++) {
        var param = urlParams[i].split('=');
        if(param[0] === 'id') {
            webmapId = param[1]
        }
    }
  }
</script>
	</body>
</html>
