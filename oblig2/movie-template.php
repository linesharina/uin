<section class="main-left">
	<img src="<?php echo $movie['img'] ?>" alt="Bilde av film">
</section>
<section class="main-right">
	<h2><?php echo $movie['title']; ?></h2>
	<p>
		<strong>Description:</strong> 
		<?php echo $movie['desc'] ?>
	</p>
	<p>
		<strong>Leading Role:</strong>
		<?php echo $movie['lead'] ?>
	</p>
	<img src="<?php echo $movie['dice'] ?>" alt="Terningskast">
	<a href="<?php echo $movie['link'] ?>" class="button" target="_blank">Read more at IMDB</a>	
</section>