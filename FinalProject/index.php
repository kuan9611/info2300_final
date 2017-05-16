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
      <script src="https://cdn.rawgit.com/ardhi/Leaflet.MousePosition/master/src/L.Control.MousePosition.js"></script>');
  }

  include_once("includes/header.php");

?>

    <div id="slideShow">
      <?php
        require_once 'includes/config.php';
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->error) {
          print($mysqli->error);
          exit();
        }
        $articles = $mysqli->query("SELECT * FROM Articles");
        if (!$articles) {
          print($mysqli->error);
          exit();
        }

        $rows= array();
        while($article = $articles->fetch_assoc()){
              $article_id = $article["article_id"];
              $title = $article['title'];
              $titleTrimmed = str_replace(' ', '_', $title);
              $slide_id = $article['slide'];
              $slide_info = $mysqli->query("SELECT * FROM Images WHERE image_id = '$slide_id'");
              $slide = $slide_info->fetch_assoc();
              $slide_path = "images/".$slide['filename'];
              $rows[]=$article;

              echo "<div class=\"mySlides fade\">
                        <a href=\"article.php?id=$article_id&title=$titleTrimmed\">
                          <img src=\"$slide_path\" alt=\"image not found\">
                        </a>
                    </div>";
        }


      ?>
      <!--<div class="mySlides fade">
        <img src="https://designschool.canva.com/wp-content/uploads/sites/2/2016/04/Antique-Map.jpg" >
        <div class="text">Caption Text</div>
      </div>

      <div class="mySlides fade">
        <img src="http://ezramagazine.cornell.edu/SUMMER15/images/FTC.RMC2003.0095-v2.jpg" >
        <div class="text">Caption Two</div>
      </div>

      <div class="mySlides fade">
        <img src="http://geoawesomeness.com/wp-content/uploads/2015/06/submarine-cable-map-2015-l.png">
        <div class="text">Caption Three</div>
      </div>

      <div class="mySlides fade">
        <img src="https://cdn2.vox-cdn.com/uploads/chorus_asset/file/3498618/trademapsubmarinecables.0.jpg">
        <div class="text">Caption Four</div>
      </div>

      <div class="mySlides fade">
        <img src="http://img.microsiervos.com/mapacables2.jpg">
        <div class="text">Caption Five</div>
      </div> -->

      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

      <!--<div id = "dots">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
      </div>-->

    <div id="contents">
      <div id="articles">
        <div class="division_title">
        <h2>Feature Articles</h2>
        </div>
        <?php
          foreach ($rows as $row){

              $article_id = $row["article_id"];
              $title = $row['title'];
              $thumbnail_id = $row['thumbnail'];
              $thumbnail_info = $mysqli->query("SELECT * FROM Images WHERE image_id = '$thumbnail_id'");
              $thumbnail = $thumbnail_info->fetch_assoc();
              $thumbnail_path = "images/".$thumbnail['filename'];

              echo "<div class=\"entry\">
                      <div class=\"thumbnail\">
                        <img src=\"$thumbnail_path\" alt=\"image not found\">
                      </div>
                      <div class=\"article_intro\">
                        <h3><a href='article.php?id=$article_id'>$title</a></h3>
                      </div>
                    </div>";
          }

        ?>
<!--        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div> -->

      </div>

      <div id ="welcome">
          <img src="images/header.png" alt="Image Not Found">
          <div class="message">
            <div class="title-in-box">
              <h2>A Note from The Editor-In-Chief, Peter Fiduccia</h2>
              <p>The Cornell Policy Review is proud to launch our 2nd annual Special Edition, focused on the use of Geographic Information Systems (GIS). Our team continues to strive to cultivate engaging content across all of our platforms, and bringing the unique capabilities of GIS to bear on our policy analyses is no exception.</p> 
              <p>Geospatial information informs most every decision in our daily lives: from simple relationships such as where to go and how to get there, to understanding complex interactions such as climate data and population trends. By translating data from tabular to visualized forms, we offer a different tool with which to interpret that data: perspective. As the number of methods by which we aggregate data consistently grows, so too must we increase the novel ways in which we represent that data to citizens, policymakers, and stakeholders across the globe. Data visualization is not only a way to effectively communicate complex information, but also allows us to critically evaluate the systems of which we are all a part.</p>
              <p>The Review has paired with students from various backgrounds, studying in various academic pursuits, to bring you an example of how we believe Geographic Information Systems can impact how we gather, analyze, and present complex relationships. By gathering a deeper understanding of geography and our own relationship to location, we can make more informed decisions about our communities, societies, and the world.</p>
            </div>
          </div>
      </div>
    </div>

<?php
  include_once("includes/footer.php");
?>


<script>
  var slideIndex = 1;
  showSlides(slideIndex);
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    //for (i = 0; i < dots.length; i++) {
    //    dots[i].className = dots[i].className.replace(" active", "");
    //}
    slides[slideIndex-1].style.display = "block";
    //dots[slideIndex-1].className += " active";
  }
</script>
  </body>
</html>