<!DOCTYPE html>
<html>
	<head>
		<title>DogeTweet</title>
		<link href="../style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once('menu.php'); ?>
		<div class="container">
			<div class="formlogin">
				<form method="post" action="/login">
					<label for="username">UserName</label>
					<input type="text" name="username" /><br/>
					<label for="password">Password</label>
					<input type="password" name="password" /><br/>
					<input type="submit" value="Login">
				</form>
			</div>
		</div>
	</body>
</html>

