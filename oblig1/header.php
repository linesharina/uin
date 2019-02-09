<header>
	<h1><a href="index.php">Movie archive</a></h1>
	<nav>
		<?php 
			foreach ($movies as $movie_slug => $movie_name) {
				$nav_item_class = 'nav-item';

				if ($chosenMovie == $movie_slug) {
					$nav_item_class .= ' nav-item-active';
				}

				echo '<a href="./?movie=' . $movie_slug . '" class="' . $nav_item_class . '">' . $movie_name . '</a>';
			}
		?>
	</nav>
</header>