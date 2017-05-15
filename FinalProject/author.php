<?php
  include_once("includes/header.php");
?>
<?php
	require_once 'includes/config.php';
	$author_id = trim(filter_input( INPUT_GET, "author", FILTER_VALIDATE_INT));
  if (empty($author_id)) {
    print ("<p class='message'>Author not found</p>");
  } else {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $author_row = $mysqli->query("SELECT * FROM Authors WHERE author_id = $author_id");
    $article_row = $mysqli->query("SELECT title, article_id FROM Articles INNER JOIN Authorship USING(article_id) WHERE author_id = $author_id");
    if (!$author_row) {
    	print ("<p class='message'>Author not found</p>");
  	} else {
      $authors = $author_row->fetch_assoc();
      $articles = $article_row->fetch_assoc();
      $article = $articles['title'];
      $articlelink = $articles['article_id'];
      $name = $authors['name'];
      $description = $authors['description'];
      $biopic_id = $authors['biopic'];
      $image = $mysqli->query("SELECT * FROM Images WHERE image_id = '$biopic_id'");
      $img = $image->fetch_assoc();
      $biopic = $img['filename'];
			print("<div class='authorinfo'>");
				print("<div id='authorcard'>");
					print("<div id='authorpic'>");
            if ($biopic == "default.png") { print(""); }
            else {print("<img src='images/$biopic' alt='Image not found' class='img'>");}
          print("</div>");
					print("");
					print("<div id='authorbio'><h3>$name</h3> <p>$description</p>");
						print("<div id='authorarticle'><h3>Article</h3> <a href='article.php?id=$articlelink'>$article</a>");
            print("</div>");
					print("</div>");
				print("</div>");
			print("</div>");
		}
	}
	?>


</body>
<?php
  include_once("includes/footer.php");
?>
</html>
