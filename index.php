<?php

	session_start();
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
		header('Location: menu.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl"> 
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<link rel="shortcut icon" href="img/ikona.png" />
	
	<title>Logowanie</title>
	
	<meta name="description" content="Logowanie - Aplikacja do zarządzania swoimi finansami." />
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
					
						<div class="mx-auto mt-4 mb-2">			
								<a href="registration.php"><div class="noselected mr-2" style="width: 140px;"><h3 class="h5 font-weight-bold">Rejestracja</h3></div></a>
								<div class="selected" style="width: 140px;"><h3 class="h5 font-weight-bold">Logowanie</h3></div>	
						</div>
						
						<form class="mx-auto mb-4" action="login.php" method="post">
						
							<div class="row m-0">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-mail"></i></span></div>
										<label class="sr-only">E-mail</label>
										<input class="form-control col-9" type="email" placeholder="Podaj e-mail" aria-label="E-mail" required name="email">
								</div>
							</div>
							
							<div class="row m-0">
								<div class="form-group form-inline">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-lock"></i></span></div>
										<label class="sr-only">Hasło</label>
										<input class="form-control col-9" type="password" placeholder="Podaj hasło" aria-label="Hasło" required name="password">
								</div>
							</div>
							
							<div class="row">
								<button type="submit" class="col-12">Zaloguj</button>
							</div>
							<?php
								if (isset($_SESSION['error'])) 	echo $_SESSION['error'];
							?>
						</form>
						
					</section>
				</div>
			</div>
		</main>
		
		<footer class="container-fluid p-3 mt-4 text-center text-white">
			Wszelkie prawa zastrzeżone &copy; 2020-<?php echo date("Y");?>
		</footer>
		
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
		
</body>
</html>