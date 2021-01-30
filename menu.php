<?php

	session_start();
	
	if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
		exit();
	}
	
	//delete the entered data
	if (isset($_SESSION['fr_expenseAmount'])) unset($_SESSION['fr_expenseAmount']);
	if (isset($_SESSION['fr_expenseDate'])) unset($_SESSION['fr_expenseDate']);
	if (isset($_SESSION['fr_expensePaymentMethod'])) unset($_SESSION['fr_expensePaymentMethod']);
	if (isset($_SESSION['fr_expenseCategory'])) unset($_SESSION['fr_expenseCategory']);
	if (isset($_SESSION['fr_comment'])) unset($_SESSION['fr_comment']);
	
	//delete errors
	if (isset($_SESSION['e_expenseAmount'])) unset($_SESSION['e_expenseAmount']);	
	if (isset($_SESSION['e_expenseDate'])) unset($_SESSION['e_expenseDate']);	
	if (isset($_SESSION['e_expensePaymentMethod'])) unset($_SESSION['e_expensePaymentMethod']);
	if (isset($_SESSION['e_expenseCategory'])) unset($_SESSION['e_expenseCategory']);
	if (isset($_SESSION['e_comment'])) unset($_SESSION['e_comment']);
	
?>

<!DOCTYPE HTML>
<html lang="pl"> 
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="img/ikona.png" />
	
	<title>Menu</title>
	
	<meta name="description" content="Strona główna - Aplikacja do zarządzania swoimi finansami." />
	<meta name="keywords" content="aplikacja, budżet, osobosty, wydatki, przychody, bilans, oszczędzanie, finanse" />
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
	
</head>

<body>
	
		<header>
			<div class="container text-white text-center text-uppercase">
				<div class="pt-4 h1 font-weight-bold">Osobisty Menadżer Budżetu</div>
				<div class="motto">... żyj po swojemu <i class="icon-smile"></i></div>
			</div>
		</header>
			
		<nav class="navbar sticky mt-4 navbar-expand-lg navbar-dark">
			
			<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav mx-auto">
				
					<li class="nav-item active">
						<a class="nav-link" href="#"><i class="icon-home"> Strona główna </i></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="income.php"><i class="icon-money"> Dodaj przychód </i></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="expense.php"><i class="icon-basket"> Dodaj wydatek </i></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="balance.php"><i class="icon-chart-bar"> Przeglądaj bilans </i></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-wrench"> Ustawienia </i></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="logout.php"><i class="icon-logout"> Wyloguj (<?= $_SESSION['username']; ?>) </i></a>
					</li>
					
				</ul>
			
			</div>
			
		</nav>
		
		<main>
		
			<div class="container mt-3 text-center">
				<h2 class="mt-5 mb-3"><?= "Witaj ".$_SESSION['username'].", co dziś robimy?"; ?></h2>
				<?php 
					if (isset($_SESSION['saveExpense']) && $_SESSION['saveExpense'] == true) {
						echo '<div class="mb-3"><span style="color: green; font-size: 20px; font-weight: bold;">Wydatek został dodany pomyślnie</span></div>';
						unset ($_SESSION['saveExpense']);
					} 
				?>
				<img class="imagemenu" src="img/imgmenu.jpg" alt="">
				<h3 class="mt-3">Zaczynajmy!</h3>
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