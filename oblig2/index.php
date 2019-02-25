<?php 
	session_start();
	foreach($_POST as $key => $value) { 
	    $_SESSION[$key] = $value; 
	} 
	require("head.php"); 
?>
<?php require("header.php"); ?>
<main>
	<form method="post">
		<label for="movie">Pick a movie</label>
		<select name="movie" id="movie">
			<?php 
				foreach ($movies as $key => $value) {
					if(isset($_SESSION['movie']) && $_SESSION['movie'] == $key) {
						echo "<option value='".$key."' selected='selected'>".$value['title']."</option>";
					} else {
						echo "<option value='".$key."'>".$value['title']."</option>";
					}
				}
			?>
		</select>
		<button type="submit">Choose</button>
	</form>
	<?php
		if (isset($_SESSION['movie']) && $_SESSION['movie'] != null) {
			$movie = $movies[$_SESSION['movie']];
			require('movie-template.php');
		}
	?>
</main>
<?php require("footer.php"); ?>
