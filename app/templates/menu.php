<div class="header">
	<a href='/'>
		<div class="logo">
			Ceci est un header pour afficher un logo de Doge mais j'ai la flemme de chercher (aussi une redirection vers l'acceuil)
		</div>
	</a>
	<nav>
		<?php if(isset($_SESSION['is_authenticated'])){ ?>
			<div>
				<ul class="right">
					<li><a href="/mystatuses">My DogeTweets</a></li>
					<li><a href="/logout">Logout</a></li>
				</ul>
			</div>
			<div>
				<ul class="left">
					<li>Welcome <?= $_SESSION['user']->getUserName(); ?></li>
				</ul>
			</div>
		<?php }
		
			if(!isset($_SESSION['is_authenticated'])){ ?>
		<div style="display: <?= !isset($_SESSION['is_authenticated'])? 'block':'none' ?>">
			<ul class="left">
				<li><a href="/login">Login</a></li>
				<li><a href="/signin">Sign In</a></li>
			</ul>
		</div>
		<?php } ?>
	</nav>
</div>
