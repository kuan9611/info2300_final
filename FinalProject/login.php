<?php include_once("includes/header.php"); ?>

<div id="login-area">
	<?php

	if (isset($_GET["login-submit"])) {

		$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
		$password = hash("sha256", $_GET['password']);

		require_once 'includes/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if($mysqli->connect_error) {
		   die("Connection failed: ".$mysqli->connect_error);
		}

		$query = "SELECT * FROM Accounts
				  WHERE username = ? AND password = ?";
		$stmt = $mysqli->stmt_init();
		if ($stmt->prepare($query)) {
			$stmt->bind_param("ss", $username, $password);
			$stmt->execute();
			$result = $stmt->get_result();
		}

		if ($result->fetch_row()) {
			$_SESSION["user"] = $username;
			echo "<p>Sign-in successful!</p>";
			echo '<script type="text/javascript">';
      		echo 'window.location.href="index.php";';
      		echo '</script>';
		}

		echo "<p>(!) Username or password incorrect</p>";
		
	}

	?>

	<h2>SIGN IN</h2>
	<p>Log in to post comment on map (sign-up will be added later)</p>
	<p>For testing, username: fp_wildcard2, password: 123456</p>
	<form id="login-form" method="get">
		<p>
	        <label>Username:</label>
	        <input type="text" name="username">
	    </p>
	    <p>
	        <label>Password:</label>
	        <input type="password" name="password">
	    </p>
	    <p>
	    	<label></label>
	    	<input class="submit" type="submit" name="login-submit">
	    </p>
	</form>
</div>

</div>
</body>

</html>