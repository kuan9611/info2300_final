<?php include_once("includes/header.php"); ?>

<div id="searchresults">
	<?php
    if(!empty($_GET["search"])){
      $search = trim(htmlentities($_GET["search"]));
      $pattern = "%$search%";
      print("<h3>Search word: $search </h3>");
      require_once 'includes/config.php';
      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
      $sql = "SELECT * FROM Articles WHERE content LIKE ? OR title LIKE ? OR date_posted LIKE ? OR date_edited LIKE ? OR location LIKE ?";
      $stmt = $mysqli->prepare($sql);
      $stmt -> bind_param('sssss', $pattern, $pattern, $pattern, $pattern, $pattern);
      $stmt -> execute();
      $result = $stmt ->get_result();
      $stmt -> close();
      print("<h3>Article:</h3>");
      while ($row = $result->fetch_assoc()) {
      	$article_id = $row['article_id'];
        $title = $row['title'];
        $location = $row['location'];
        $authors_row= $mysqli->query("SELECT author_id, name FROM Authorship INNER JOIN Authors USING(author_id) WHERE article_id = $article_id");
        $authors = $authors_row->fetch_assoc();
        $author = $authors['name'];
        $author_id = $authors['author_id'];
        print( "<div class='results'>
                  <p><a href='article.php?id=$article_id'>$title</a></p>
                  <p>Location: $location</p>
                  <p>Author: $author</p>
                </div>");
        }
      print("<h3>Authors:</h3>");
      $sql = "SELECT * FROM Authors WHERE name LIKE ? OR description LIKE ?";
      $stmt = $mysqli->prepare($sql);
      $stmt -> bind_param('ss', $pattern, $pattern);
      $stmt -> execute();
      $result = $stmt ->get_result();
      $stmt -> close();
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $id = $row['author_id'];
        $article_row = $mysqli->query("SELECT title, article_id FROM Articles INNER JOIN Authorship USING(article_id) WHERE author_id = $id");
        $articles = $article_row->fetch_assoc();
        $article = $articles['title'];
        $article_id = $articles['article_id'];
        print( "<div class='results'>
                  <p>$name   <a href='author.php?author=$id'>Go to page</a></p>
                  <p>Article: <a href='article.php?id=$article_id'>$article</a></p><br>
                </div>");
      }
    }

    if(!empty($_GET["tag"])){
      $tag_id = filter_input( INPUT_GET, "tag", FILTER_VALIDATE_INT);
      require_once 'includes/config.php';
      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

      $sql0 = "SELECT tag FROM Tags WHERE tag_id = ?";
      $stmt0 = $mysqli->prepare($sql0);
      $stmt0 -> bind_param('i', $tag_id);
      $stmt0 -> execute();
      $result0 = $stmt0 ->get_result();
      $tag = $result0->fetch_assoc()['tag'];
      $stmt0 -> close();
      print("<h3>Tag: $tag</h3>");

      $sql = "SELECT * FROM Articles JOIN Tagged USING(article_id) WHERE tag_id = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt -> bind_param('i', $tag_id);
      $stmt -> execute();
      $result = $stmt ->get_result();
      while ($row = $result->fetch_assoc()) {
        $article_id = $row['article_id'];
        $title = $row['title'];
        $location = $row['location'];
        $authors_row= $mysqli->query("SELECT author_id, name FROM Authorship INNER JOIN Authors USING(author_id) WHERE article_id = $article_id");
        $authors = $authors_row->fetch_assoc();
        $author = $authors['name'];
        $author_id = $authors['author_id'];
        print( "<div class='results'>
                  <p><a href='article.php?id=$article_id'>$title</a></p>
                  <p>Location: $location</p>
                  <p>Author: $author</p>
                </div>");
      }
    }

	?>
</div>

<?php
  include_once("includes/footer.php");
?>
  </body>
</html>
