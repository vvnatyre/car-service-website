<?php
	session_start();
	require_once('connect.php');
	$icon = $_FILES['file']['name'];
	$path = 'uploads/'.time().$_FILES['file']['name'];

	move_uploaded_file($_FILES['file']['tmp_name'],'../'.$path);

	$title = $_POST['title'];

	// mysqli_query($connect,"INSERT INTO `image_game` (`id`, `image_link`, `id_game`) VALUES (NULL, '$path', '$title')");
	// mysqli_query($connect, "INSERT INTO users (id, img) VALUES (NULL, '$patch')");
	$stmt = mysqli_prepare($connect, "UPDATE users SET img= ? WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "si", $path, $_SESSION['id']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	$redicet = $_SERVER['HTTP_REFERER'];
	@header ("Location: $redicet");



?>