<?php
    session_start();
	
	if((!isset($_SESSION['udana']))) //dzieki temu strona powitania zostaje wyswietlona tylko raz i po wspianiu linku w przegladarce zostaniemy przekierowani do index.php
	{
		header('Location: index.php');
		exit(); // powoduje ze caly kod na dole sie nie wykonuje i dzieki temu nie obciaza serwera
	}
	else
	{
		unset($_SESSION['udana']);
	}
	
	require ('header.php');
?>


  <h1> Nin3</h1>
  <p>Dziękujemy za rejestracje!</p>
  <a href="zaloguj.php">Zapraszamy do logowania!</a>
  

<?php
require ('footer.php');
?>