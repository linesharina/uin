<?php

	$chosenMovie = null;

	if(isset($_GET['movie'])) {
		$chosenMovie = $_GET['movie'];

		if($chosenMovie == 'tangled') {
			@include 'tangled.php';
		}

		if($chosenMovie == 'bighero6') {
			@include 'big-hero-6.php';
		}

		if($chosenMovie == 'coco') {
			@include 'coco.php';
		}
	}

	$movies = [
		'tangled' => 'Tangled',
		'bighero6' => 'Big Hero 6',
		'coco' => 'Coco'
	];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>UIN - Oblig 1</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>
<body class="<?php echo $chosenMovie; ?>">
