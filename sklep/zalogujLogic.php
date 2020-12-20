<?php

    session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo']))) //jesli nie ustawiono loginu i hasla udaj sie do pliku index.php
	{
		header('Location: index.php');
		exit();
	}

	
	
    //laczenie bazy danych i bledy
	$pdo = new PDO ('mysql:host:localhost;port=3306;dbname=sklep','root','');
 
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo -> exec("SET NAMES 'utf8'");
 //koniec laczenia i bledow
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name); //@ <- operator kontroli błędów
	
	if($polaczenie->connect_errno!=0) //ostatnia podjęta próba połączenia się z bazą zakończyła się sukcesem
	{
       echo "Erorr: ".$polaczenie->connect_errno;
	}
	else
	{
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
	
	$login=htmlentities($login, ENT_QUOTES, "UTF-8"); //htmlentities - zabezpieczenie przed wstrzykiwaniem SQL, zamiana na encje html ENT_QUOTES - mowi zebysmy zamieniali na encje takze cudzyslowie i apostrofy
	
	

	
	if($rezultat=@$polaczenie->query(
	sprintf("SELECT * FROM user WHERE nazwa='%s'",
	mysqli_real_escape_string($polaczenie,$login)))) //sprintf=printf z jezyka C %s = tu wstawimy łańcuch (string) sprintf wstawia  w miejsce pierwszego %s pierwszą rzecz po przecinku, a w miejsce drugiego drugą rzecz po przecinku mysqli_real_escape_string=funkcja ktora zostala specjalnie napisana do wykrywania prob wplywania na zapytania operatorami dwoch myślników lub apostrofami i zabezpiecza naszą bazę przed wstrzykiwaniem SQL, ($polaczenie=identyfikator połączenia, $login=ciąg znaków które chcemy poddać sanizacji
	{
		$ile_userow=$rezultat->num_rows; //liczba wierszy w tabeli
		if($ile_userow>0)
		{
			$wiersz=$rezultat->fetch_assoc(); // fetch assoc - przynieś dane i włóż je do tablicy asocjacyjnej | fetch=przynies | asocjacja=skojarzenie
			
			if(password_verify($haslo, $wiersz['haslo']))   // weryfikacja hasha
			
			{
				//require "user.php";
				//require "function.php";
				$_SESSION['zalogowany']=true; //flaga
				
				
				
				
				$_SESSION['id']=$wiersz['id'];
				
				$_SESSION['user']=$wiersz['nazwa'];
				$_SESSION['email']=$wiersz['mail'];
				
				$result=user::checkPassword($login);
				if($result instanceof user){
				$session->updateSession($result);}
				//echo 'Zalogowano: '.$session->GetUser()->getLogin();
				unset($_SESSION['blad']); //unset - usun zmienna z sesji
				$rezultat->free_result();
				header('Location: indexLogIn.php');
			}
			else
			{
			
			$_SESSION['blad']="<p> Nieprawidłowy login lub hasło!</p>";
			
			header('Location: zaloguj.php');
			
		    }
		}
		else{
			
			$_SESSION['blad']="<p> Nieprawidłowy login lub hasło!</p>";
			
			header('Location: zaloguj.php');
			
		}
	}
	
	$polaczenie->close();
	}
	

?>