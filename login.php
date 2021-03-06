<?php

	session_start();
	
	if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->query("SET NAMES 'utf8'");
		
		if ($connection->connect_errno != 0) {
			throw new Exception(mysqli_connect_errno());
		} else {
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$email = htmlentities($email, ENT_QUOTES, "UTF-8");
			
			if ($resultOfQuery = $connection->query(sprintf("SELECT * FROM users WHERE email = '%s'", 
			mysqli_real_escape_string($connection, $email)))) {
				$howManyUsers = $resultOfQuery->num_rows;
				
				if ($howManyUsers > 0) {
					$userData = $resultOfQuery->fetch_assoc();
						
					if (password_verify($password, $userData['password'])) {
						$_SESSION['logged'] = true;
						
						$_SESSION['id'] = $userData['id'];
						$_SESSION['username'] = $userData['username'];
						$_SESSION['email'] = $userData['email'];
						
						unset($_SESSION['error']);
						$resultOfQuery->free_result();
						header('Location: menu.php');
					} 	else {
						$_SESSION['error'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło</span>';
						header('Location: index.php');
					}
					
				} else {
					$_SESSION['error'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło</span>';
					header('Location: index.php');
				}
			} else {
				throw new Exception($connection->error);
			}
			
			$connection->close();
		}
	} catch(Exception $e) {
		echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy o wizytę w innym terminie!</span>';
		//echo '<br />Informacja developerska: '.$e;
	}
	
?>