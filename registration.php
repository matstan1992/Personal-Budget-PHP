<?php

	session_start();

	if ((isset($_POST['username'])) && (isset($_POST['email'])) && (isset($_POST['password1'])) && (isset($_POST['password2']))) {
		
		//successful validation
		$allGood = true;
		
		//username
		$username = $_POST['username'];
		
		//First letter uppercase, the rest lowercase
		$username = mb_convert_case($username, MB_CASE_TITLE, "UTF-8");
		
		//Length username
		if ((strlen($username) < 3) || (strlen($username) > 20)) {
			$allGood = false;
			$_SESSION['e_username'] = "Imię musi posiadać od 3 do 20 znaków!";
		}
		
		$alphabet = '/^[a-ząęółśżźćńA-ZĄĘÓŁŚŹŻĆŃ]+$/';	//regular expression
		
		if (!preg_match($alphabet, $username)) {
			$allGood = false;
			$_SESSION['e_username'] = "Imię musi składać się tylko ze znaków polskiego alfabetu!";
		}
		
		//email
		$email = $_POST ['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
			$allGood = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
		}
		
		//password
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1) < 8) || (strlen($password1) > 20)) {
			$allGood = false;
			$_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1 != $password2) {
			$allGood = false;
			$_SESSION['e_password'] = "Podane hasła nie są identyczne!";
		}
		
		//password hash
		$passwordHash = password_hash($password1, PASSWORD_DEFAULT);

		
		//remember the entered data
		$_SESSION['fr_username'] = $username;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;

		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($connection->connect_errno != 0) {
				throw new Exception(mysqli_connect_errno());
			} else {
				//email already exist in the database?
				$emailAlreadyExistInTheDatabase = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$emailAlreadyExistInTheDatabase) throw new Exception($connection->error);
				
				$howManyEmailAlreadyExist = $emailAlreadyExistInTheDatabase->num_rows;
				
				if ($howManyEmailAlreadyExist > 0) {
					$allGood = false;
					$_SESSION['e_email'] = "Istnieje już konto o podanym adresie e-mail!";
				}
				
				if ($allGood == true) {
					//Adding a user to the database
					if ($connection->query("INSERT INTO users VALUES (NULL, '$username', '$passwordHash', '$email')")) {
						
						if ($connection->query("INSERT INTO expenses_category_assigned_to_users(user_id, name) SELECT u.id, d.name FROM users AS u CROSS JOIN expenses_category_default AS d WHERE u.email='$email'")) {
							
							if ($connection->query("INSERT INTO incomes_category_assigned_to_users(user_id, name) SELECT u.id, d.name FROM users AS u CROSS JOIN incomes_category_default AS d WHERE u.email='$email'")) {
								
								if ($connection->query("INSERT INTO payment_methods_assigned_to_users(user_id, name) SELECT u.id, d.name FROM users AS u CROSS JOIN payment_methods_default AS d WHERE u.email='$email'")) {
									$_SESSION['successfulRegistration'] = true;
									header('Location: welcome.php');
								} else {
									throw new Exception($connection->error);
								}
							} else {
								throw new Exception($connection->error);
							}
						} else {
							throw new Exception($connection->error);
						}		
					} else {
						throw new Exception($connection->error);
					}
				}
				$connection->close();
			}
			
		} catch(Exception $e) {
			echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy o rejestrację w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
	}

?>

<!DOCTYPE HTML>
<html lang="pl"> 
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<link rel="shortcut icon" href="img/ikona.png" />
	
	<title>Rejestracja</title>
	
	<meta name="description" content="Rejestracja - Aplikacja do zarządzania swoimi finansami." />
	<meta name="keywords" content="aplikacja, budżet, osobosty, wydatki, przychody, bilans, oszczędzanie, finanse" />
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
		
</head>

<body>
	
		<header>
			<div class="container mb-2 text-white text-center text-uppercase">
				<div class="pt-4 h1 font-weight-bold">Osobisty Menadżer Budżetu</div>
				<div class="motto">... żyj po swojemu <i class="icon-smile"></i></div>
			</div>
		</header>
	
		<main>
			<div class="container">
				<div class="row m-0">
					<section id="text" class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 offset-xl-1 bg-ligh mt-4 mx-auto text-center">
						<h3 class="h4 font-weight-bold">Kontrola budżetu? Tak!</h3>
						<p class="mb-2"><b>Osobisty Menadżer Budżetu</b> jest to program stworzony z myślą o osobach, które kontrolują swoje fianse na papierze, bądź chcą dopiero zacząć. Jeśli męczy Cię już ciągłe spisywanie swoich przychodów i wydatków na kolejnych kartkach papieru, a pod koniec miesiąca i tak jest Ci ciężko oszacować czy w danym miesiącu jesteś na plusie czy na minusie, to ten program jest właśnie dla Ciebie! </p><p>Przecież niekontrolowane wydatki to przypuszczalne oszędności :-)</p>

						<h3 class="h4 font-weight-bold">Jak to działa?</h3>
						<p>Bardzo prosto. Logujemy się na swoje konto, a następnie z menu głównego wybieramy odpowiednią zakładkę. <br/>Chcąc dodać przychód do naszych finansów, wybieramy <b>"Dodaj przychód"</b>, zaznaczamy odpowiednią datę oraz rodzaj przychodu. <br/>Jeśli jest to wydatek klikamy <b>"Dodaj wydatek"</b> i wypełniamy analogicznie jak przy przychodzie. <br/>Natomiast, jeżeli interesuje nas zestawienie przychodów i rozchodów wybieramy <b>"Przeglądaj bilans"</b>. Tam korzystając z opcji wyboru daty możemy w prosty sposób dowiedzieć się czy w interesującym nas okresie nasze finanse są na plusie czy na minusie, no i przede wszystkim <b>ILE</b> ta kwota wynosi.</p> 
					</section>
					
					<section class="row content col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-5 offset-xl-1 bg-white my-auto mx-auto">
					
						<div class="mx-auto mt-4 mb-3">			
								<div class="selected mr-2"><h3 class="h5 font-weight-bold">Rejestracja</h3>(Nie mam konta)</div>
								<a href="index.php"><div class="noselected"><h3 class="h5 font-weight-bold">Logowanie</h3>(Mam konto)</div></a>	
						</div>
						
						<form class="mx-auto mb-4" method="post">
						
							<div class="row m-0 justify-content-center">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-user"></i></span></div>
										<label class="sr-only">Imię użytkownika</label>
										<input class="form-control col-9" type="text" placeholder="Podaj imię" aria-label="Imię" required value="<?php
											if (isset($_SESSION['fr_username'])) {
												echo $_SESSION['fr_username'];
												unset($_SESSION['fr_username']);
											}?>" name="username">
								</div>
							</div>
							<?php 	
									if (isset($_SESSION['e_username'])) {		
										echo '<div class="row mb-2 justify-content-center text-danger">'.$_SESSION['e_username'].'</div>';
										unset($_SESSION['e_username']);
									}
								?>
								
							<div class="row m-0 justify-content-center">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-mail"></i></span></div>
										<label class="sr-only">E-mail</label>
										<input class="form-control col-9" type="text" placeholder="Podaj e-mail" aria-label="E-mail" required value="<?php
											if (isset($_SESSION['fr_email'])) {
												echo $_SESSION['fr_email'];
												unset($_SESSION['fr_email']);
											}?>" name="email">
								</div>
							</div>
							<?php 	
									if (isset($_SESSION['e_email'])) {		
										echo '<div class="row mb-2 justify-content-center text-danger">'.$_SESSION['e_email'].'</div>';
										unset($_SESSION['e_email']);
									}
								?>
								
							<div class="row m-0 justify-content-center">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-lock"></i></span></div>
										<label class="sr-only">Hasło</label>
										<input class="form-control col-9" type="password" placeholder="Podaj hasło" aria-label="Hasło" required value="<?php
											if (isset($_SESSION['fr_password1'])) {
												echo $_SESSION['fr_password1'];
												unset($_SESSION['fr_password1']);
											}?>" name="password1">
								</div>
							</div>
							<?php 	
									if (isset($_SESSION['e_password'])) {
										echo '<div class="row mb-2 justify-content-center text-danger">'.$_SESSION['e_password'].'</div>';
										unset($_SESSION['e_password']);
									}
								?>
							
							<div class="row m-0 justify-content-center">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-lock"></i></span></div>
										<label class="sr-only">Powtórz hasło</label>
										<input class="form-control col-9" type="password" placeholder="Powtórz hasło" aria-label="Hasło" required value="<?php
											if (isset($_SESSION['fr_password2'])) {
												echo $_SESSION['fr_password2'];
												unset($_SESSION['fr_password2']);
											}?>" name="password2">
								</div>
							</div>
							
							<div class="row">
								<button type="submit" class="col-12">Zarejestruj</button>
							</div>
							
						</form>
						
					</section>
				</div>
			</div>
		</main>
		
		<footer class="container-fluid p-3 mt-4 text-center text-white">
			Wszelkie prawa zastrzeżone &copy; 2020-<?php echo date("Y");?> Dziękuję za wizytę!
		</footer>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
</body>
</html>