<?php require("head.php"); ?>
<?php require("header.php"); ?>
<main>
	<?php 
		if($chosenMovie !== null) {		
			@include 'movie-template.php';
		} else {
			echo "<p class='choose-movie'>Select a movie from the menu</p>";
		}
	?>
</main>
<?php require("footer.php"); ?>
