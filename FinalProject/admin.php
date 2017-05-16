<?php include_once("includes/header.php"); 


?>
	<div id="admin-panel">
		<div id="admin">
			<div class="button" id="all"><button onclick="window.location.href='admin.php'">All Comments</button></div>
			<div class="button" id = "article_select">
				<select id="articles">
					<option value="">Filter by articles</option>
  						<?php require_once 'includes/config.php';
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
					        while($article = $articles->fetch_assoc()){
					              $article_id = $article["article_id"];
					              $title = $article['title'];
					              echo "<option value=$article_id>$title</option>";
					        }
  						?>
				</select>
			</div>
		</div>
		<div id = "result">

			<table id="comments">
				<colgroup>
					<col class="column-one">
        			<col class="column-two">
        			<col class="column-three">
        			<col class="column-four">
        			<col class="column-five">
        			<col class="colum-six">
				</colgroup>
				
				<thead>
					<tr>
						<th>Comment ID</th>
						<th>Content</th>
						<th>Article</th>
						<th>User Name</th>
						<th>Post Time</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
			        require_once 'includes/admin_functions.php';
					$page = get_page();
					$comments = get_comments($page);

			        while($comment = $comments->fetch_assoc()){
			              $comment_id = $comment["comment_id"];
			              $content = $comment['content'];
			              $username = $comment['username'];
			              $time = $comment['date'];
			              $article_title = $comment['title'];  

			              print( "<tr>
			              			<td>$comment_id</td>
			              			<td>$content</td>
			              			<td>$article_title</td>
			              			<td>$username</td>
			              			<td>$time</td>
			              			<td>
			              			<a class='admin-delete' id='".$comment_id."ad'>Delete</a></td>
			              		</tr> 		
			              "); 
			        }      
	    			?>
    			</tbody>
			</table>

			<?php
				echo '<p>';
				$older_page = $page + 1;
				echo "<a id='next-page' data-page='$older_page'
					href='admin.php?page=$older_page'>Show more comments</a></p>";
				echo '<img id="ajax-loader" style="display:none;" src="images/ajax_loader.gif">';
			?>
	
		</div>

		
	</div>
	<?php include_once("includes/footer.php"); ?>
</div>
	<script type="text/javascript">

		//when the page is loading, show all comments	
		$(document).ready(function(){
	
			$("#admin-panel").on("click", ".admin-delete", function() {
				var id = parseInt($(this).attr('id'));
				var request = $.ajax({
			      url: "includes/del_comment.php",
			      type: "POST",
			      data: { 'cmt_id': id }
			    });
			    request.done(function(resp) {
			      var resp = $.parseJSON(resp);
			      if (resp.success) {
			        window.location.reload();
			      }
			    });
			});

			$( "#next-page").click( function() {
				//Hide the "next" link so it can't be clicked again and show a "loading" image
				$( '#next-page').hide();
				$( '#ajax-loader').css( 'display', 'block');
		
				//Prepare the data to send with the ajax request
				var page = $( '#next-page').data('page' );
				var dataToSend = { page : page };

				//Make the ajax request
				request = $.ajax({
					url: "admin-ajax.php",
					type: "get",
					data: dataToSend,
					dataType: "json"
				});
		
			//Increment the data attribute of the "next" link so it will be accurate for the next click
			page++;
			$( '#next-page').data('page', page );

			//Specify the function to run when the response comes back from the server
			request.done(function(response){
				$.each( response.comments, function() {
					$('#comments > tbody:last').append(
						'<tr>' +
							'<td>' + this.comment_id + '</td>' +
							'<td>' + this.content + '</td>' +
							'<td>' + this.title + '</td>' +
							'<td>' + this.username + '</td>' +
							'<td>' + this.date + '</td>' +
							'<td>' + "<a class='admin-delete' id='"+this.comment_id+"ad'>Delete</a></td>"
							+'</tr>');

				});

				if (response.comments.length==0) {
					$('#next-page').text("No more comments");
				}

				$( '#next-page').show();
				$( '#ajax-loader').hide();
			});

			//Prevent the default click action from happening
			return false;
	});

});
		// when filter by article
		$("#articles").on('change', function(){
			var article_id = $("#articles").val();
			console.log(article_id);
			var dataToSend = { article_id : article_id };

		request = $.ajax({
					url: "admin-article-ajax.php",
					type: "get",
					data: dataToSend,
					dataType: "json"
				});

		request.done(function(response){
			$("#comments > tbody").html("");
			$('#next-page').hide();
			if(response.comments.length == 0) {

				$('#result > p').html("");

				$('#result').append('<p>No comments for this article.</p>');

			}else {
				$('#result > p').html("");
				$.each( response.comments, function() {
						$('#comments > tbody').append(
							'<tr>' +
								'<td>' + this.comment_id + '</td>' +
								'<td>' + this.content + '</td>' +
								'<td>' + this.title + '</td>' +
								'<td>' + this.username + '</td>' +
								'<td>' + this.date + '</td>' +
								'<td>'+ "<form action='includes/del_comment.php' method='POST' id =\"comment" + this.comment_id + "\">"
											+ "<input type='hidden' name='cmt_id' value="  + this.comment_id  + ">"
										+ "</form>"
										+ "<a href='includes/del_comment.php' onclick='document.getElementById(\""+ "comment"+this.comment_id + "\""+").submit();return false;'>Delete</a></td>"
								+'</tr>');
					});
			}

		});
	});

	
	</script>
</body>
</html>
