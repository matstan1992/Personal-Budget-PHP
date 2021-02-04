<?php

	session_start();
	
	if (!isset($_SESSION['logged'])) {
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset("utf8");
		
		if ($connection->connect_errno != 0) {
			throw new Exception(mysqli_connect_errno());
		} else {
			$dateStart = $_POST['dateStart'];
			$dateEnd = $_POST['dateEnd'];
			
			//incomes
			$getIncomes = 'SELECT c.name, SUM(i.amount) FROM incomes_category_assigned_to_users c INNER JOIN incomes i ON i.income_category_assigned_to_user_id = c.id WHERE i.user_id = "'.$_SESSION['id'].'" AND i.date_of_income >= STR_TO_DATE("'.$dateStart.'", "%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$dateEnd.'", "%Y-%m-%d") AND i.user_id = "'.$_SESSION['id'].'" GROUP BY c.name ORDER BY SUM(i.amount) DESC';
			
			if ($resultOfQuery = $connection->query($getIncomes)) {
				$incomes = $resultOfQuery->fetch_all();
				$_SESSION['incomes'] = $incomes;
			} else {
				throw new Exception($connection->error);
			}
			
			//expenses
			$getExpenses = 'SELECT c.name, SUM(e.amount) FROM expenses_category_assigned_to_users c INNER JOIN expenses e ON expense_category_assigned_to_user_id = c.id WHERE e.user_id = "'.$_SESSION['id'].'" AND e.date_of_expense >= STR_TO_DATE("'.$dateStart.'", "%Y-%m-%d") AND e.date_of_expense <= STR_TO_DATE("'.$dateEnd.'", "%Y-%m-%d") AND e.user_id = "'.$_SESSION['id'].'" GROUP BY c.name ORDER BY SUM(e.amount) DESC';
			
			if ($resultOfQuery = $connection->query($getExpenses)) {
				$expenses = $resultOfQuery->fetch_all();
				$_SESSION['expenses'] = $expenses;
			} else {
				throw new Exception($connection->error);
			}
			
			//incomes details
			$getIncomesDetails = 'SELECT i.date_of_income, c.name, i.amount, i.income_comment FROM incomes i INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id WHERE i.user_id = "'.$_SESSION['id'].'" AND i.date_of_income >= STR_TO_DATE("'.$dateStart.'", "%Y-%m-%d") AND i.date_of_income <= STR_TO_DATE("'.$dateEnd.'", "%Y-%m-%d") AND i.user_id = "'.$_SESSION['id'].'" ORDER BY i.date_of_income';
			
			if ($resultOfQuery = $connection->query($getIncomesDetails)) {
				$incomesDetails = $resultOfQuery->fetch_all();
				$_SESSION['incomesDetails'] = $incomesDetails;
			} else {
				throw new Exception($connection->error);
			}
			
			//expenses details
			$getExpensesDetails = 'SELECT e.date_of_expense, c.name, p.name, e.amount, e.expense_comment FROM expenses e INNER JOIN expenses_category_assigned_to_users c ON expense_category_assigned_to_user_id = c.id INNER JOIN payment_methods_assigned_to_users p ON e.payment_method_assigned_to_user_id = p.id WHERE e.user_id = "'.$_SESSION['id'].'" AND e.date_of_expense >= STR_TO_DATE("'.$dateStart.'", "%Y-%m-%d") AND e.date_of_expense <= STR_TO_DATE("'.$dateEnd.'", "%Y-%m-%d") AND e.user_id = "'.$_SESSION['id'].'" ORDER BY e.date_of_expense';
			
			if ($resultOfQuery = $connection->query($getExpensesDetails)) {
				$expensesDetails = $resultOfQuery->fetch_all();
				$_SESSION['expensesDetails'] = $expensesDetails;
			} else {
				throw new Exception($connection->error);
			}
			
			$resultOfQuery->free_result();
			
			$_SESSION['heading'] = 'Bilans za wybrany okres ('.$dateStart->format('d/m/Y').' - '.$dateEnd->format('d/m/Y').')';
			
			$_SESSION['secondPeriod'] = true;
			header('Location: balance.php');
			
			$connection->close();
		}
		
	} catch (Exception $e) {
		echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy spróbować w innym terminie!</span>';
		//echo '<br />Informacja developerska: '.$e;
	}
	
?>