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

      <script type="text/javascript" src="js/map.js"></script>
      <script type="text/javascript" src="js/comments.js"></script>');
  }
  include_once("includes/header.php");
?>

<?php
  require_once 'includes/config.php';
  $article_id = trim(filter_input( INPUT_GET, "id", FILTER_VALIDATE_INT));
  echo "<script> var articleId = $article_id; </script>";

  if (empty($article_id)) {
    print ("<p class='message'>Article not found</p>");
  } else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $article_row = $mysqli->query("SELECT * FROM Articles WHERE article_id = $article_id");
    //get the names of authors (in case more than one), concatenated by ","
    $authors_row = $mysqli->query("SELECT name, author_id FROM Authorship INNER JOIN Authors USING(author_id) WHERE article_id = $article_id");
    $tags_row = $mysqli->query("SELECT * FROM Tags JOIN Tagged USING(tag_id) WHERE article_id = $article_id");
    if (!$article_row||$article_row->num_rows != 1||!$authors_row||!$tags_row) {
      print ("<p class='message'>Article not found</p>");
    } else {
      $article = $article_row->fetch_assoc();
      $title = $article['title'];
      $content = $article['content'];
      $reference = $article['reference'];
      $date_posted = $article['date_posted'];
      $date_edited = $article['date_edited'];
      $authorfull = array();
      print("<div class='article'>");
        print("<h1>$title</h1>");
        print("<p class='author'> Posted $date_posted by ");
        while($row = $authors_row->fetch_assoc()) {
          $authorname = $row['name'];
          $authorlink = $row['author_id'];
          $authorfull[] = "<a href='author.php?author=$authorlink'>$authorname</a>";
        }
        $authorlist = implode(", ", $authorfull);
        print_r($authorlist);
        print("</p>");
      print("</div>");

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
              $width = $image['width'];
              $height = $image['height'];
              $width_pr = (!empty($width))?"width=".$width:"";
              $height_pr = (!empty($height))?"height=".$height.";'":"";
              print("<img src='$file' alt='Image not found' class='img' style='min-width:400px;$height_pr;$width_pr;'>");
            }
          }
          print("</div>");

        } else {
          print($para);//tags like <p> and <h2> are directly stored in database
        }
      }
      print("Tags: ");
      $count = 0;
      while ($row = $tags_row->fetch_assoc()) {
        if ($count!=0) print(", ");
        else $count = 1;
        $id = $row['tag_id'];
        $tag = $row['tag'];
        print("<a href='search.php?tag=$id'>$tag</a> ");
      }
      print("<br><br>");
      if ($reference!=NULL) {
        print("<button onclick='showReference(this)' id='showReference'>References:</button>");
        $reference_arr=explode("|", $reference);
        print("<div class='hide' id='reference'>");
        foreach ($reference_arr as $ref) {
          print("<p class='ref'>$ref</p>");
        }
        print("</div>");
      }
      print("</div>");
    }
  }
?>

<script>
  function showReference() {
    var reference = document.getElementById('reference');
    if(reference.className=='hide'){
        reference.className = 'show' ;
    }else{
        reference.className = 'hide';
    }
  }
</script>

<div id="mapcontainer">
  <div id="map"></div>
</div>
<button id="maptoggle">Toggle Map</button>
<?php
if (isset($_SESSION["user"])) {
  print("<button id='leaveComment'>Leave a Comment</button>");
}
?>
<button id="showComment">Show Comments</button>
<button id="hideComment">Hide Comments</button>

<script>
  var markers = [];
  var id2marker = new Map();
  <?php
  $threads = $mysqli->query("SELECT * FROM Threads
                              WHERE article_id = $article_id
                              AND on_map > 0");
  while ($thread = $threads->fetch_assoc()) {
    print("var marker = L.marker([{$thread['latitude']},
                                    {$thread['longitude']}]);\n");
    print("marker.bindPopup('");
    $comments = $mysqli->query("SELECT * FROM Comments
                                WHERE thread_id = {$thread['thread_id']}");
    while ($comment = $comments->fetch_assoc()) {
      print('<div class="comment-box" id="'.$comment['comment_id'].'d"><b>'.$comment['username'].'</b> ('.$comment['date'].'):<br>'.$comment['content']);
      if (isset($_SESSION["user"]) && $_SESSION["user"] === $comment['username']) {
        print('<br><a class="comment-delete" id="'.$comment['comment_id'].'c">delete</a>');
      }
      print('</div>');
    }
    if (isset($_SESSION["user"])) {
      print('<a class="comment-reply" id="'.$thread['thread_id'].'r">reply</a>');
    }
    print("');\n");
    print("markers.push(marker);\n");
    print("id2marker.set({$thread['thread_id']}, marker);\n");
  }
  ?>
</script>

<div id="commentBox">
  <form method="post">
    <textarea id="commentText" name="text_c" placeholder="Enter comment ..."></textarea>
    <br>
    <input type="button" id="cancelComment" name="cancel_c" value="Cancel">
    <input type="button" id="postComment" name="post_c" value="Post">
  </form>
</div>

<div id="discussion-section">
  <h3 id="section-header"><i><?php print($title); ?></i> · Comments</h3>
  <?php
  if (isset($_SESSION["user"])) {
    print("<textarea id='scommentText' placeholder='enter comment'></textarea><br><a id='postScomment'>post</a>");
  }
  $threads = $mysqli->query("SELECT * FROM Threads
                              WHERE article_id = $article_id
                              AND on_map = 0");
  while ($thread = $threads->fetch_assoc()) {
    print('<div class="section-thread" id="'.$thread['thread_id'].'st">');
    $comments = $mysqli->query("SELECT * FROM Comments
                                WHERE thread_id = {$thread['thread_id']}");
    while ($comment = $comments->fetch_assoc()) {
      print('<div class="section-comment" id="'.$comment['comment_id'].'sc"><b>'.$comment['username'].'</b> ('.$comment['date'].'):<br>'.$comment['content']);
      if (isset($_SESSION["user"]) && $_SESSION["user"] === $comment['username']) {
        print('<br><a class="scomment-delete" id="'.$comment['comment_id'].'sd">delete</a>');
      }
      print('</div>');
    }
    if (isset($_SESSION["user"])) {
      print('<a class="scomment-reply" id="'.$thread['thread_id'].'sr">reply</a>');
    }
    print('</div>');
  }
  ?>
</div>

<!-- <div id="disqus_thread"></div>
<script>
/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

var disqus_config = function () {
//this.page.url = PAGE_URL;  default would be window.location.href
<?php //echo "this.page.identifier = $article_id ;";
      //echo "this.page.title = ".json_encode($title)." ;"; ?>
};

(function() {
	var d = document, s = d.createElement('script');
	s.src = 'https://cpr-gis.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript> -->


<?php
  include_once("includes/footer.php");
?>
</body>
</html>
