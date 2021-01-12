<?php

	session_start();
	
	if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno != 0) {
		echo "Error: ".$connection->connect_errno;
	} else {
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
		
		if ($resultOfQuery = @$connection->query(sprintf("SELECT * FROM users WHERE email = '%s' AND password = '%s'", 
		mysqli_real_escape_string($connection, $email),
		mysqli_real_escape_string($connection, $password)))) {
			
			$howManyUsers = $resultOfQuery->num_rows;
			if ($howManyUsers > 0) {
				
				$_SESSION['logged'] = true;
				
				$userData = $resultOfQuery->fetch_assoc();
				$_SESSION['id'] = $userData['id'];
				$_SESSION['username'] = $userData['username'];
				$_SESSION['email'] = $userData['email'];
				
				unset($_SESSION['error']);
				$resultOfQuery->free_result();
				header('Location: menu.php');
				
			} else {
				
				$_SESSION['error'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło</span>';
				header('Location: index.php');

			}
		}
		
		$connection->close();
	}
	
	
?>