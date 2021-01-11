<!DOCTYPE HTML>
<html lang="pl"> 
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="img/ikona.png" />
	
	<title>Przychód</title>
	
	<meta name="description" content="Dodaj przychód - Aplikacja do zarządzania swoimi finansami." />
	<meta name="keywords" content="aplikacja, budżet, osobosty, wydatki, przychody, bilans, oszczędzanie, finanse" />
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
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
			
		<nav class="navbar sticky mt-4 navbar-expand-lg navbar-dark">
			
			<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav mx-auto">
				
					<li class="nav-item">
						<a class="nav-link" href="menu.php"><i class="icon-home"> Strona główna </i></a>
					</li>
					
					<li class="nav-item active">
						<a class="nav-link" href="#"><i class="icon-money"> Dodaj przychód </i></a>
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
						<a class="nav-link" href="index.php"><i class="icon-logout"> Wyloguj (Użytkownik) </i></a>
					</li>
					
				</ul>
			
			</div>
			
		</nav>
		
		<main>
			
			<article>
				<div class="container">
					<div class="row">
						<div class="mx-auto">
							<form class="text-center">
								<h2 class="font-weight-bold mt-4">Dodaj przychód</h2>

								<div class="row mx-auto mt-4">
									<div class="form-group form-inline mx-auto">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-money-1"></i></span>
										</div>
										<label class="sr-only">Kwota</label>
										<input type="number" name="amount" min="0" step="0.01" placeholder="Podaj kwotę w zł" aria-label="Kwota" required>
									</div>
								</div>
								
								<div class="row mx-auto mt-4">
									<div class="form-group form-inline mx-auto">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar"></i></span>
										</div>
										<label class="sr-only">Data</label>
										<input type="date" id="date" name="date" aria-label="Data" required>
									</div>
								</div>

								<fieldset class="mx-auto">
									
									<legend class="font-weight-bold">Kategoria:</legend>
									<div class="mt-2">
										<div><label><input type="radio" value="salary" name="category" checked> Wynagrodzenie </label></div>
										<div><label><input type="radio" value="bankInterest" name="category"> Odsetki bankowe </label></div>
										<div><label><input type="radio" value="saleOnAllegro" name="category"> Sprzedaż na Allegro </label></div>
										<div><label><input type="radio" value="other" name="category"> Inne </label></div>
									</div>
								</fieldset>

								<div class="mx-auto mt-4">
									<label class="h4 font-weight-bold">Komentarz (opcjonalnie):</label>
									<textarea name="comment" class="col-10" rows="2" cols="50"></textarea>
								</div>
								
								<div class="row mx-auto">
									<button id="anuluj" type="submit" class="col-2 mx-auto">Anuluj</button>
									<button type="submit" class="col-2 mx-auto">Dodaj</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</article>
			
		</main>
		
		<footer class="container-fluid p-3 mt-4 text-center text-white">
			Wszelkie prawa zastrzeżone &copy; 2020  Dziękuję za wizytę!
		</footer>
		
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<script>
			setCurrentDate();
		</script>
		
</body>
</html>