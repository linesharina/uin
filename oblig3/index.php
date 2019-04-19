<?php 
	require("head.php"); 
	include("header.php");
?>
<main>
	<nav>
		<?php 
			echo "<a href='./'>Vis alle</a>";
			
			sort($movies);
			foreach ($movies as $key => $value) {
				echo "<a href='./?movie=".$key."'>".$value['title']."</a>";
			}
		?>
	</nav>
	<?php	
		if(!isset($_GET['movie'])) {
			foreach ($movies as $key => $value) {
				$movie = $movies[$key];				
				@require('all-movies.php');
			}
		} else {
			$chosenMovie = $_GET['movie'];
			$movie = $movies[$chosenMovie];
			
			@require('movie-template.php');
		}
	?>
</main>
<?php include("footer.php"); ?>
