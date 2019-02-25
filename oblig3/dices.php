<?php 
	for($i = 1; $i <= 6; $i++) {
		
		if($i == $movie['dice']) {
			echo "<img src='./img/dices/dice-".$i.".png' alt='Dice' class='chosen-dice'>";
		} else {
			echo "<img src='./img/dices/dice-".$i."-transparent.png' alt='Dice' class='dices'>";
		}

	}
?>

