<!DOCTYPE html>
<html>
	<head>
		<title>DogeTweet</title>
		<link href="../style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once('menu.php'); ?>
		<div class="container">
			<div class="messageform">
				<form action="/statuses" method="POST">
					<label for="message">What are you Doge-ing?</label><br/>
					<textarea name="message" maxlength="140" placeholder="Tell me more about Doge"></textarea><br/>
					<input type="submit" value="DogeTweet!">
				</form>
			</div>
			<div class="statuslist">
				<h2>Statuses</h2>
				<hr/>
					<?php 
						if(!empty($statuses)){
							foreach($statuses as $status) : ?>
							<a href="/statuses/<?= $status->getId(); ?>">
								<div class="statuses">
									<div class="username">
										<?= $status->getUserName(); ?>
									</div>
									<div class="date">
										<?= $status->getDatePost(); ?> 
									</div>
									<div class="message">
										<?= $status->getMessage(); ?>
									</div>
								</div>
							</a>
					<?php endforeach; 
					}?>
			</div>
		</div>
	</body>
</html>
