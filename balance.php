<?php

	session_start();
	
	if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
		exit();
	}

	if(!isset($_SESSION['secondPeriod'])) {	
		require_once "currentMonth.php";
	}
	unset($_SESSION['secondPeriod']);
	
	//get values
	$incomes = $_SESSION['incomes'];
	$expenses = $_SESSION['expenses'];
	$incomesDetails = $_SESSION['incomesDetails'];
	$expensesDetails = $_SESSION['expensesDetails'];
	$heading = $_SESSION['heading'];
	
?>

<!DOCTYPE HTML>
<html lang="pl"> 
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="img/ikona.png" />
	
	<title>Bilans</title>
	
	<meta name="description" content="Przeglądaj bilans - Aplikacja do zarządzania swoimi finansami." />
	<meta name="keywords" content="aplikacja, budżet, osobosty, wydatki, przychody, bilans, oszczędzanie, finanse" />
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
	<script src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="jquery-3.5.1.min.js"></script>
	<script src="personalBudget.js"></script>
	
</head>

<body>
	
	<header>
		<div class="container text-white text-center text-uppercase">
			<div class="pt-4 h1 font-weight-bold">Osobisty Menadżer Budżetu</div>
			<div class="motto">... żyj po swojemu <i class="icon-smile"></i></div>
		</div>
	</header>
		
	<nav class="navbar mt-4 navbar-expand-xl navbar-dark">
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="mainmenu">
		
			<ul class="navbar-nav mx-auto">
			
				<li class="nav-item">
					<a class="nav-link" href="menu.php"><i class="icon-home"> Strona główna </i></a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="income.php"><i class="icon-money"> Dodaj przychód </i></a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="expense.php"><i class="icon-basket"> Dodaj wydatek </i></a>
				</li>
				
				<li class="nav-item active">
					<a class="nav-link" href="#"><i class="icon-chart-bar"> Przeglądaj bilans </i></a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="icon-wrench"> Ustawienia </i></a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="logout.php"><i class="icon-logout"> Wyloguj (<?= $_SESSION['username']; ?>) </i></a>
				</li>
				
			</ul>
		
		</div>

		<div class="nav-item dropdown">
			<button class="dropbtn dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="submenu" aria-haspopup="true"> Wybierz okres </button>
				
				<div class="dropdown-content dropdown-menu m-0" aria-labelledby="submenu">
				
					<a class="dropdown-item" href="balance.php"> Bieżący miesiąc </a>
					<a class="dropdown-item" href="previousMonth.php"> Poprzedni miesiąc </a>
					<a class="dropdown-item" href="currentYear.php"> Bieżący rok </a>
					
					<div class="dropdown-divider"></div>
					
					<a class="dropdown-item" href="#" data-toggle="modal" data-target="#chooseCustom"> Niestandardowy </a>
				
				</div>
		</div>
		
	</nav>
	
	<main>
		<article>
			<div class="container">
				<div class="row">
					<div class="mx-auto text-center mb-4">
						<h2 class="font-weight-bold mt-4"><?= $heading; ?></h2>
					</div>	
					<div class="container">
					
						<div class="row">
							<div class="col-md-6">
								<table class="table table-sm table-striped table-primary text-center">
									<?php
									if ($incomes == NULL) {
										echo '<thead><tr><th scope="col" colspan="3">Przychody</th></tr>';
										echo '<tr><td>Brak przychodów w bieżącym miesiącu</td></tr></thead>';
									} else {
										echo'<thead><tr><th scope="col" colspan="3">Przychody</th></tr>';
										echo '<tr><th scope="col">Lp</th><th scope="col">Kategoria</th><th scope="col">Kwota [zł]</th></tr></thead>';
										echo '<tbody>';
										$totalIncome = 0;
										$olNumber = 0;
										foreach ($incomes as $income) {
											echo '<tr><th scope="row">'.(++$olNumber).'</th>';
											echo '<td>'.$income[0].'</td><td>'.$income[1].'</td></tr>';
											$totalIncome += $income[1];
										}
										echo '<tr><th scope="col" colspan="2">Suma:</th><td class="font-weight-bold">'.number_format($totalIncome, 2).'</td></tr>';
										echo '</tbody>';
									}
									?>
								  </tbody>
								</table>
							</div>
								
							<div class=" col-md-6">
								<table class="table table-sm table-striped table-secondary text-center">
								  <?php
									if ($expenses == NULL) {
										echo '<thead><tr><th scope="col" colspan="3">Wydatki</th></tr>';
										echo '<tr><td>Brak wydatków w bieżącym miesiącu</td></tr></thead>';
									} else {
										echo'<thead><tr><th scope="col" colspan="3">Wydatki</th></tr>';
										echo '<tr><th scope="col">Lp</th><th scope="col">Kategoria</th><th scope="col">Kwota [zł]</th></tr></thead>';
										echo '<tbody>';
										$totalExpense = 0;
										$olNumber = 0;
										foreach ($expenses as $expense) {
											echo '<tr><th scope="row">'.(++$olNumber).'</th>';
											echo '<td>'.$expense[0].'</td><td>'.$expense[1].'</td></tr>';
											$totalExpense += $expense[1];
										}
										echo '<tr><th scope="col" colspan="2">Suma:</th><td class="font-weight-bold">'.number_format($totalExpense, 2).'</td></tr>';
										echo '</tbody>';
									}
									?>
								</table>
							</div>
						</div>
								
						<div class="row ">
							<div class="col-md-8 offset-md-2">
								<table class="table table-sm table-striped table-info text-center">
									<tbody>
										<tr>
											<th>Bilans [zł]:</th>
											<th>3594.87</th>
										</tr>
										<tr>
											<th colspan="2">Gratulacje. Świetnie zarządzasz finansami!</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
						<div class="row">
							<div id="pieChart" class="mx-auto"></div>
						</div>
						
					</div>
				</div>
			</div>
		</article>
		
		<section>
			
			<div class="modal fade" id="chooseCustom" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Wskaż okres jaki Cię interesuje</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<form class="text-center" action="customPeriod.php" method="post">
							<div class="modal-body">
								
								<div class="row mx-auto mt-4">
									<div class="form-group form-inline mx-auto">
										<span class="text-dark mr-3 font-weight-bold">Od:</span>
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar"></i></span>
										</div>
										<label class="sr-only">Data</label>
										<input type="date" id="date1" name="date" aria-label="Data" required>
									</div>
								</div>
								
								<div class="row mx-auto mt-4">
									<div class="form-group form-inline mx-auto">
										<span class="text-dark mr-3 font-weight-bold">Do:</span>
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar"></i></span>
										</div>
										<label class="sr-only">Data</label>
										<input type="date" id="date" name="date" aria-label="Data" required>
									</div>
								</div>
						
							</div>
							
							<div class="modal-footer">
								<button id="anulujModal" type="submit" class="btn btn-reset" data-dismiss="modal">Anuluj</button>
								<button id="zatwierdz" type="submit" class="btn">Zatwierdź</button>
							</div>
						
						</form>
				
					</div>
				</div>
			</div>
			
		</section>
	</main>
	
	<footer class="container-fluid p-3 mt-4 text-center text-white">
		Wszelkie prawa zastrzeżone &copy; 2020-<?php echo date("Y");?> Dziękuję za wizytę!
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<script>
		setCurrentDate();
		drawChart();
	</script>
</body>
</html>