<!DOCTYPE html>
<html>
	<head>
		<title>DogeTweet</title>
		<link href="../style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once('menu.php'); ?>
		<div class="container">
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
										<div>
										<?php if(isset($_SESSION['is_authenticated']) && $_SESSION['user']->getId() === $status->getUserId()){ ?>

											<form action="/statuses/<?= $status->getId() ?>" method="POST">
												<input type="hidden" name="_method" value="DELETE">
												<input type="submit" value="Delete">
											</form>
										<?php } ?>
										</div>
										<br/>
									</div>
							</a>
					<?php endforeach; 
					}?>
			</div>
		</div>
	</body>
</html>
