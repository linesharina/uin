<section class="main-left">
	<img src="<?php echo $movie['img'] ?>" alt="Bilde av film">
</section>
<section class="main-right">
	<h2><?php echo $movie['title']; ?></h2>
	<div class="terninger"><?php @require('dices.php'); ?></div>
	<a href="?movie=<?php echo $key; ?>" class="button">Read more</a>	
</section>