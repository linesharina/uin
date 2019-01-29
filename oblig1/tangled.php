
<?php 
	require("head.php"); 
	require("header.php");
?>
<main>
	<?php 
		$tangled = array(
			'title' => 'Tangled',
			'bilde' => 'https://i.xdh.no/21307896afb9',
			'besk'	=> 'The magically long-haired Rapunzel has spent her entire life in a tower, 
						but now that a runaway thief has stumbled upon her, 
						she is about to discover the world for the first time, and who she really is.',
			'hoved'	=> 'Mandy Moore',
			'link'	=> 'https://www.imdb.com/title/tt0398286/'
	);?>
	
	<section class="main-left">
		<img src="<?php echo $tangled['bilde'] ?>">
	</section>
	<section class="main-right">
		<h2><?php echo $tangled['title'];  ?></h2>
		<p>Beskrivelse: <?php echo $tangled['besk'] ?></p>
		<p>Hovedrolle: <?php echo $tangled['hoved'] ?></p>
		<a href="<?php echo $tangled['link'] ?>" class="button" target="_blank">Les mer på IMDb</a>	
	</section>
	

</main>
<?php require("footer.php"); ?>
