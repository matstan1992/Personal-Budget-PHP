<?php

	session_start();
	
	if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
		exit();
	}
	
	if  (isset($_POST['amount'])) {
		
		//successful validation
		$allGood = true;
		
		//amount
		$incomeAmount = $_POST['amount'];
		
		//change separator (comma / dot)
		if (strpos($incomeAmount, ",") == true) {
			$incomeAmount = str_replace(",", ".", $incomeAmount);
		}
		
		if (!is_numeric($incomeAmount) || $incomeAmount < 0) {
			$allGood = false;
			$_SESSION['e_incomeAmount'] = "Wprowadzona kwota musi być liczbą dodatnią!";
		}
		
		if ($incomeAmount >= 1000000) {
			$allGood = false;
			$_SESSION['e_incomeAmount'] = "Maksymalna kwota przychodu to 999 999.99 zł";
		}
		
		//date
		$incomeDate = $_POST['date'];
		
		$theLastDayOfTheCurrentMonth = date('Y-m-t');
		
		if ($incomeDate > $theLastDayOfTheCurrentMonth) {
			$allGood = false;
			$_SESSION['e_incomeDate'] = "Maksymalna data do wyboru to ostatni dzień bieżącego miesiąca";	
		}
		
		if ($incomeDate < '2000-01-01') {
			$allGood = false;
			$_SESSION['e_incomeDate'] = "Minimalna data do wyboru to 01-01-2000";	
		}
		
		//category
		if(isset($_POST['category'])) 
		{
			$incomeCategory = $_POST['category'];
			$_SESSION['fr_incomeCategory'] = $incomeCategory;
		}
		else
		{
			$allGood = false;
			$_SESSION['e_incomeCategory'] = "Wybierz kategorię wydatku";
		}
		
		//comment
		$comment = $_POST['comment'];
		$comment = htmlentities($comment, ENT_QUOTES, "UTF-8");
		
		if (strlen($comment) > 100) {
			$allGood = false;
			$_SESSION['e_comment'] = "Komentarz może zawierać maksymalnie 100 znaków";
		}
		
		//remember the entered data
		$_SESSION['fr_incomeAmount'] = $incomeAmount;
		$_SESSION['fr_incomeDate'] = $incomeDate;
		$_SESSION['fr_comment'] = $comment;

		if ($allGood == true) {
			require_once "connect.php";
			mysqli_report(MYSQLI_REPORT_STRICT);
			
			try {
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				
				if ($connection->connect_errno != 0) {
					throw new Exception(mysqli_connect_errno());
				} else {
					$userId  = $_SESSION['id'];
					
					if ($connection->query("INSERT INTO incomes VALUES (NULL, '$userId', (SELECT id FROM incomes_category_assigned_to_users WHERE user_id = '$userId' AND name = '$incomeCategory'), '$incomeAmount', '$incomeDate', '$comment')")) {
						$_SESSION['saveIncome'] = true;
						header('Location: menu.php');	
					} else {
						throw new Exception($connection->error);
					}
				}
				$connection->close();
				
			} catch(Exception $e) {
				echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy spróbować w innym terminie!</span>';
				//echo '<br />Informacja developerska: '.$e;
			}
		
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
						<a class="nav-link" href="logout.php"><i class="icon-logout"> Wyloguj (<?= $_SESSION['username']; ?>) </i></a>
					</li>
					
				</ul>
			
			</div>
			
		</nav>
		
		<main>
			
			<article>
				<div class="container">
					<div class="row">
						<div class="mx-auto">
							<form class="text-center" method="post">
								<h2 class="font-weight-bold mt-4">Dodaj przychód</h2>

								<div class="row mx-auto mt-4 mb-0">
									<div class="form-group form-inline mx-auto mb-2">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-money-1"></i></span>
										</div>
										<label class="sr-only">Kwota</label>
										<input type="number" name="amount" min="0" step="0.01" placeholder="Podaj kwotę w zł" aria-label="Kwota" required value="<?php
											if (isset($_SESSION['fr_incomeAmount'])) {
												echo $_SESSION['fr_incomeAmount'];
												unset($_SESSION['fr_incomeAmount']);
											}?>">
									</div>
								</div>
								<?php 	
									if (isset($_SESSION['e_incomeAmount'])) {
										echo '<div class="row mb-2 mx-auto justify-content-center text-danger">'.$_SESSION['e_incomeAmount'].'</div>';
										unset($_SESSION['e_incomeAmount']);
									}
								?>
								
								<div class="row mx-auto mt-4 mb-0">
									<div class="form-group form-inline mx-auto mb-2">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar"></i></span>
										</div>
										<label class="sr-only">Data</label>
										<input type="date" id="date" name="date" aria-label="Data" required value="<?php
											if (isset($_SESSION['fr_incomeDate'])) {
												echo $_SESSION['fr_incomeDate'];
												unset($_SESSION['fr_incomeDate']);
											} else {
												echo date('Y-m-d');
											}?>">
									</div>
								</div>
								<?php 	
									if (isset($_SESSION['e_incomeDate'])) {
										echo '<div class="row mb-3 mx-auto justify-content-center text-danger">'.$_SESSION['e_incomeDate'].'</div>';
										unset($_SESSION['e_incomeDate']);
									}
								?>

								<fieldset class="mx-auto mt-4">
									
									<legend class="font-weight-bold">Kategoria:</legend>
									<?php
										require_once "connect.php";
										mysqli_report(MYSQLI_REPORT_STRICT);
		
										try {
											$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
											if ($connection->connect_errno != 0) {
												throw new Exception(mysqli_connect_errno());
											} else {
												$userId  = $_SESSION['id'];
												
												if (!$resultOfQuery = $connection->query(sprintf("SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '%s'", 
												mysqli_real_escape_string($connection, $userId)))) throw new Exception($connection->error);
		
												$howManyNames = $resultOfQuery->num_rows;
			
												if ($howManyNames > 0) {
													while ($row = $resultOfQuery->fetch_assoc()) {
														echo '<div style="padding: 1.5px;">';
														echo '<label>';
														echo '<input type="radio" name="category" value="'.$row['name'];
														
														if (isset($_SESSION['fr_incomeCategory'])) {
															if ($row['name'] == $_SESSION['fr_incomeCategory']) {
																echo '"checked = checked"';
															}
														}
														
														echo '">'.$row['name'].'</label>';
														echo '</div>';
													}
													$resultOfQuery->free_result();
												}
											}
											$connection->close();
										} catch (Exception $e) {
											echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy spróbować w innym terminie!</span>';
											//echo '<br />Informacja developerska: '.$e;
										}
									?>
								</fieldset>
								<?php
										if (isset($_SESSION['e_incomeCategory'])) {
											echo '<div class="row mx-auto justify-content-center text-danger">'.$_SESSION['e_incomeCategory'].'</div>';
											unset($_SESSION['e_incomeCategory']);
										}
									?>
								
								<div class="mx-auto mt-4 mb-1">
									<label class="h4 font-weight-bold">Komentarz (opcjonalnie):</label>
									<textarea name="comment" class="col-10" rows="2" cols="50"><?php
											if (isset($_SESSION['fr_comment'])) {
												echo $_SESSION['fr_comment'];
												unset($_SESSION['fr_comment']);
											}?></textarea>
								</div>
								<?php 	
									if (isset($_SESSION['e_comment'])) {
										echo '<div class="row mb-2 justify-content-center text-danger mx-auto">'.$_SESSION['e_comment'].'</div>';
										unset($_SESSION['e_comment']);
									}
								?>
								
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
			Wszelkie prawa zastrzeżone &copy; 2020-<?php echo date("Y");?> Dziękuję za wizytę!
		</footer>
		
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
		
</body>
</html>