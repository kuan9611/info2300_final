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
      <script src="https://cdn.jsdelivr.net/leaflet.esri.renderers/2.0.2/esri-leaflet-renderers.js"></script>
      <script src="https://muxlab.github.io/Leaflet.VectorIcon/L.VectorIcon.js"></script>
      <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>
      <script src="https://cdn.jsdelivr.net/leaflet.esri.webmap/0.4.0/esri-leaflet-webmap.js"></script>

      <link rel="stylesheet" href="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.css" />
      <script src="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.js"></script>

      <script type="text/javascript" src="js/scripts.js"></script>');
  }
  include_once("includes/header.php");
?>
<?php
  require_once 'includes/config.php';
  $article_id = trim(filter_input( INPUT_GET, "id", FILTER_VALIDATE_INT));
  if (empty($article_id)) {
    print ("<p class='message'>Article not found</p>");
  } else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $article_row = $mysqli->query("SELECT * FROM Articles WHERE article_id = $article_id");
    //get the names of authors (in case more than one), concatenated by ","
    $authors_row = $mysqli->query("SELECT GROUP_CONCAT(name) FROM Authorship INNER JOIN Authors USING(author_id) WHERE article_id = $article_id");
    if (!$article_row||$article_row->num_rows != 1||!$authors_row) {
      print ("<p class='message'>Article not found</p>");
    } else {
      $article = $article_row->fetch_assoc();
      $authors = $authors_row->fetch_row()[0];
      $title = $article['title'];
      $content = $article['content'];
      $date_posted = $article['date_posted'];
      $date_edited = $article['date_edited'];
      print("<div class='article'>");
        print("<h1>$title</h1>");
        //can add link to author later
        print("<p class='author'> Posted $date_posted by $authors </p>");
      print("</div>");
?>

<?php

      $content_arr=explode("|", $content); //paragraphs stored in database separated by "|"
      print("<div class='article'>");
      foreach ($content_arr as $para) {
        //image is signaled by image_id: a letter appended by two digits, like a01, c09.
        //Letter corresponds to the article, digits show the position of an image inside an article
        if (preg_match_all('/[a-z][\d][\d]/',$para, $matches)>0) {
          print( "<div class='image'>");
          foreach ($matches[0] as $image_id){
            $images = $mysqli->query("SELECT * FROM Images WHERE image_id = '$image_id'");
            if (!$images) {
              print ("<p class='message'>Image not found</p>");
            } else {
              $image = $images->fetch_assoc();
              $file = "images/".$image['filename'];
              //image resizing imformation can be stored in the database and applied here later
              print("<img src='$file' alt='Image not found' class='img'>");
            }
          }
          print("</div>");
        } else {
          //tags like <p> and <h2> are directly stored in database
          print($para);
        }
      }
      print("</div>");
    }
  }
?>
<button id="maptoggle">Toggle Map</button>
<button id="leaveComment">Leave a Comment</button>
<div id="mapcontainer">
  <div id="map"></div>
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
