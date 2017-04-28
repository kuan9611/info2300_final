<?php
  //custom HTML headers
  function customHeader(){
    print('
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
      <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
      <script src="https://cdn.jsdelivr.net/leaflet.esri.webmap/0.4.0/esri-leaflet-webmap.js"></script>

      <link rel="stylesheet" href="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.css" />
      <script src="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.js"></script>

      <script type="text/javascript" src="js/scripts.js"></script>');
  }
  include_once("includes/header.php");
?>
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

	L.control.mousePosition().addTo(webmap._map);
	webmap._map.on("click", function(e) {
		console.log(e.latlng);
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

<div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

var disqus_config = function () {
//this.page.url = PAGE_URL;  default would be window.location.href
this.page.identifier = 1; // Can use article id
};

(function() {
	var d = document, s = d.createElement('script');
	s.src = 'https://cpr-gis.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

</body>
</html>
