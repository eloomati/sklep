
<?php
 require('header.php');
 
  session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) //dzieki temu od razu jest wyswietlany LOR a nie formularz logowania
	{
		header('Location: indexLogIn.php');
		exit(); // powoduje ze caly kod na dole sie nie wykonuje i dzieki temu nie obciaza serwera
	}
?>

<?php require('login.php');?>


<?php	
  require ('footer.php')
?>